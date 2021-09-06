<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Subasta;
use App\Carrera;
use App\Balance;
use App\TabPonle;
use App\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use OneSignal;

class SubastaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subastas = Subasta::orderBy('id', 'DESC');
        if ($request->jornada_id && $request->carrera_id) {
            $subastas = Subasta::where('jornada_id', $request->jornada_id)
                ->where('carrera_id', $request->carrera_id);
        }
        $subastas = $subastas->with('user')->get();

        $jornada = Carrera::where('carrera', $request->carrera_id)
            ->where('jornada_id', $request->jornada_id)
            ->with('jornada')
            ->first();
        $total = 0;
        $responserSubasta = [];
        foreach ($subastas as $caballos) {
            $value = array(
                "id" => $caballos->id,
                "ejemplar" => $caballos->ejemplar,
                "name_ejemplar" => $caballos->name_ejemplar,
                "apostador" => $caballos->user,
                "monto" => $caballos->monto,
                "status_retired" => $caballos->status_retired ? true : false,
                "winner" => $caballos->winner ? true : false,
            );
            $total += $caballos->monto > 0 ? $caballos->monto : 0;
            array_push($responserSubasta, $value);
        }

        /* Informacion de la jornada*/
        if ($jornada) {
            //total ca pagar de la tabla
            $commission = $jornada['jornada']['commission'];
            $youtube_id = $jornada['jornada']['youtube_id'];
            $incentive = $jornada->incentive;
            $comisionCasa = ($commission * $total) / 100;
            $subTotal = ($total - $comisionCasa);
            $totalApagar = ($subTotal + $incentive);



            $date = Carbon::parse($jornada['jornada']['date'] . $jornada->hour);
            //Carbon::parse($jornada->hour);
            $now = Carbon::now();
            $diff_hor = $date->diff($now);

            $validate = $date->gt($now);

            $horaSeg = ($diff_hor->h * 3600);
            $minSeg = ($diff_hor->i * 60);
            $seg = ($horaSeg + $minSeg + $diff_hor->s);

            $jornada = array(
                "hipodromo" => $jornada['jornada']['name'],
                "pizarra" => $jornada['pizarra'],
                "winning" => $jornada['dividendo_ganador'],
                "carrera" => $jornada->carrera,
                "incentive" => number_format($jornada->incentive, 2), //incentive por carrera
                "date" => $jornada['jornada']['date'],
                "hour" => $jornada->hour,
                "distance" => $jornada->distance,
                "detail" => $jornada->detail,
                "total" => number_format($totalApagar, 2),
                "status_cierre" => $jornada->status_cierre ? true : false,
                "youtube_id" => $youtube_id,
                "dif_hors" => $validate ? ($diff_hor->h) + ($diff_hor->days * 24) : 0,
                "dif_min" => $validate ? $diff_hor->i : 0,
                "dif_seg" => $validate ? $diff_hor->s : 0,
                "v" =>  $validate,
                "erp_time" => $validate ? $seg : 0
            );
        }



        $arrayQuery = array('data' => $jornada, 'carrera' => $responserSubasta);
        return json_encode($arrayQuery);
    }
    /**
     * Display a listing of the resource.
     * @param idJornada
     * @param idCarrera
     * @return [1]CARRERA
     */

    public function subastaMovil(Request $request)
    {
        $rules = [
            'ejemplar' => 'required',
            'carrera_id' => 'required',
            'jornada_id' => 'required'

        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'errors'  => $validator->errors()->all()
            ], 422);
        }

        $user = auth()->user();

        $jornada = Carrera::where('carrera', $request->carrera_id)
            ->where('jornada_id', $request->jornada_id)
            ->with('jornada')
            ->first();


        if ($jornada['jornada']['date'] <= now()->toDateString()) {
            // Se valida que el horario del
            // y que aun no este premiado
            $validateSorteo = $this->validateHoraCierre($request->jornada_id, $request->carrera_id);
            if (!empty($validateSorteo)) {
                return response()->json([
                    'error' => 'TARDEEEEEEEEE CARRERA CERRADA'
                ], 420);
            }
        }

        //consultar saldo bloqueado
        $saldo_bloqueado = $this->blockedBalance($user);

        $carrera = Carrera::where('carrera', $request->carrera_id)
            ->where('jornada_id', $request->jornada_id)
            ->first();

        //Verificar que la carrera este abierta
        if ($carrera->status_cierre == 0) {
            return response()->json([
                'error' => 'TARDEEEEEEEEE CARRERA CERRADA'
            ], 420);
        } else {
            /* si la carrera esta abierta procede la siguiente verificacion*/

            /* Verificar si el usuario tiene poso */
            $saldo = User::leftjoin('balance_general', 'balance_general.user_id', '=', 'users.id')
                ->select(
                    'users.id',
                    'users.user',
                    DB::raw('SUM(balance_general.monto) as available')
                )
                ->groupBy('balance_general.user_id')
                ->groupBy('users.user', 'users.id')
                ->find($user->id);

            //verificar monto del ponle actual
            $detail = Subasta::where('jornada_id', $request->jornada_id)
                ->where('carrera_id', $request->carrera_id)
                ->where('ejemplar', $request->ejemplar)
                ->first();

            $valuePonle = $detail ? (int) $detail->monto : (int) $request->monto;
            /* Verificar el siguiente ponle */
            $ponle = $this->ponleActual($valuePonle);
            $ponleValue = $ponle ? $ponle->value : 0;

            $montoApuesta = $detail ? ($detail->monto + $ponleValue) : ($request->monto + $ponleValue);

            $unloack = $saldo_bloqueado ? $saldo_bloqueado->locked : 0;

            $disponible = ($saldo->available - $unloack);

            if ($disponible >= $montoApuesta) {
                $carreraDb = $detail;
                $carreraDb->user_id = $user->id;
                $carreraDb->monto = !$detail['status_retired'] ? 0 : $montoApuesta;
                $detail->save();
            } else {
                return response()->json([
                    'error' => 'Saldo insuficiente'
                ], 421);
            }

            return $this->index($request);
        }
    }

    public function ponleActual($valuePonle)
    {
        $ponles = TabPonle::get();
        foreach ($ponles as $ponle) {
            if ($valuePonle >= $ponle->ini_monto && $valuePonle < $ponle->end_monto) {
                return $ponle;
            }
        }
    }



    /**
     *VALIDAMOS LA HORA DE LA CARRERA
     */
    private function validateHoraCierre($jornada_id, $carrera_id)
    {

        $response = [];
        $carrera = Carrera::where('jornada_id', $jornada_id)->where('carrera', $carrera_id)->first(['hour']);
        $now = Carbon::now();
        $closeTime = new Carbon($carrera->hour);
        if ($now->gte($closeTime)) {
            $response = trans("TARDEEEEEEEEE CARRERA CERRADA");
        } else {
            $balance = Balance::where('jornada_id', $jornada_id)->where('carrera_id', $carrera_id)->first();
            if ($balance) {
                $response = trans("CARRERA CERRADA");
            }
        }

        return $response;
    }


    /**
     * Display monto bloqueado o diferido.
     * @param idJornada
     * @param idCarrera
     * @return [1]CARRERA
     */
    public function blockedBalance($user)
    {
        $locked = Subasta::select('user_id', DB::raw('SUM(monto) as locked'))
            ->groupBy('user_id')
            ->where('status_close', 1)
            ->where('user_id', $user->id)
            ->first();
        return $locked;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),  [
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $jornada_id = $request->id;
        $n_carrera = $request->n_carrera;
        $carreras = $request->carrera; //numero de carrera


        // CERRAR SUBASTA O TABLA
        $carreraClose = Carrera::where('carrera', $n_carrera)
            ->where('jornada_id', $jornada_id)
            ->first();
        $carreraClose->status_cierre = $request->data['status_cierre'];
        $carreraClose->pizarra = $request->data['pizarra'];
        $carreraClose->dividendo_ganador = $request->data['winning'];
        if ($carreraClose->save()) {
            $this->closeSubasta($n_carrera, $jornada_id, $request->data['status_cierre']);
        }

        if (!$request->data['status_cierre'] && !empty($request->data['pizarra']) && !empty($request->data['winning'])) {
            OneSignal::sendNotificationToSegment(
                "Pizarra " . $request->data['pizarra']. ' Dividendo'. $request->data['winning'],
                "All",
                null,
                null,
                null,
                null,
                "Orden de llegada carrera #".$n_carrera
            );
        }

        //verificar si esta cerrada para calcular premio
        $totalPremio = 0;
        $count_winner = 0;
        $monto_pagar = 0;
        $array_id_subasta = [];

        if (!$request->data['status_cierre']) {
            foreach ($carreras as $item) {
                if ($item['winner'] == 1) {
                    $count_winner += 1;
                    $monto_pagar += $item['monto'] > 0 ? $item['monto'] : 0;
                } else {
                    array_push($array_id_subasta, $item['id']);
                }
            }
            //procedemos a limpiar los que no son ganadores
            if (count($array_id_subasta) > 0) $this->deleteGanadores($array_id_subasta);

            $totalPremio = $this->calculatePremio($jornada_id, $n_carrera);
            $response = json_decode($totalPremio);
            $totalPremio = $response->total_pagar;
        }

        // registrar subasta
        foreach ($carreras as $item) {
            $carreraDb = isset($item['id']) ? Subasta::find($item['id']) : new Subasta;
            $carreraDb->jornada_id = $jornada_id;
            $carreraDb->user_id = $item['apostador']['id'];
            $carreraDb->jornada_id = $jornada_id;
            $carreraDb->carrera_id = $n_carrera;
            $carreraDb->ejemplar = $item['ejemplar'];
            $carreraDb->name_ejemplar = $item['name_ejemplar'];
            $carreraDb->monto_winner = $item['winner'] == 1 ? ($totalPremio / $count_winner) : 0;
            $carreraDb->monto = !$item['status_retired'] ? 0 : $item['monto'];
            $carreraDb->winner = $item['winner'];
            $carreraDb->status_retired = $item['status_retired'];
            //CUENAOD CIERRE LA CARRERA SE PROCEDE A DESCONTAR EL SALDO
            if ($carreraDb->save()) {
                if (!$request->data['status_cierre']) {
                    $this->discountBalance($carreraDb, $request->data);
                    //verificamos que es ganador para premiar 
                    if ($item['winner'] == 1) {
                        $this->addPremioBalance($carreraDb, $request->data);
                    }
                }
            }
        }
    }

    public function closeSubasta($n_carrera, $jornada_id, $status)
    {
        Subasta::where('carrera_id', $n_carrera)
            ->where('jornada_id', $jornada_id)
            ->update(['status_close' => $status]);
    }


    public function discountBalance($subasta, $dataJornada)
    {
        if (!$dataJornada['status_cierre']) {
            $balance = Balance::where('subastas_id', $subasta->id)->first();
            $balance = $balance ? $balance : new Balance;
            $balance->user_id = $subasta->user_id;
            $balance->monto = (-$subasta->monto);
            $balance->description = $dataJornada['hipodromo'] . ' REMATE Carrera#' . $subasta->carrera_id .  ' Ejemplar#' . $subasta->ejemplar;
            $balance->operations = 'jugada';
            $balance->subastas_id = $subasta->id;
            $balance->jornada_id = $subasta->jornada_id;
            $balance->carrera_id = $subasta->carrera_id;
            $balance->status = 1;
            $balance->save();
        }
    }

    public function addPremioBalance($subasta, $dataJornada)
    {
        if (!$dataJornada['status_cierre']) {
            $balance = Balance::where('subastas_id', $subasta->id)->where('operations', 'premio')->first();
            $balance = $balance ? $balance : new Balance;
            $balance->user_id = $subasta->user_id;
            $balance->monto = $subasta->monto_winner;
            $balance->description = 'Premio ' . $dataJornada['hipodromo'] . ' REMATE Carrera#' . $subasta->carrera_id .  ' Ejemplar#' . $subasta->ejemplar;
            $balance->operations = 'premio';
            $balance->subastas_id = $subasta->id;
            $balance->jornada_id = $subasta->jornada_id;
            $balance->carrera_id = $subasta->carrera_id;
            $balance->status = 1;
            $balance->save();
        }
    }


    public function deleteGanadores($array_id_subasta)
    {
        Balance::whereIn('subastas_id', $array_id_subasta)->where('operations', 'premio')
            ->get()->each(function ($msg) {
                $msg->delete();
            });
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function calculatePremio($jornada_id, $carrera_id)
    {

        $jornada = Carrera::where('carrera', $carrera_id)
            ->where('jornada_id', $jornada_id)
            ->with('jornada')
            ->first();
        if ($jornada) {
            $subastas = Subasta::where('jornada_id', $jornada_id)
                ->where('carrera_id', $carrera_id)->get();
        }

        $total = 0;
        foreach ($subastas as $caballos) {
            $total += $caballos->monto > 0 ? $caballos->monto : 0;
        }

        /* Informacion de la jornada*/
        if ($jornada) {
            //total ca pagar de la tabla
            $commission = $jornada['jornada']['commission'];
            $incentive = $jornada->incentive;
            $comisionCasa = ($commission * $total) / 100;
            $subTotal = ($total - $comisionCasa);
            $totalApagar = ($subTotal + $incentive);
            $jornada = array(
                "total_pagar" => $totalApagar
            );
        }

        // $arrayQuery = array('data' => $jornada);
        return json_encode($jornada);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = [];
        if (isset($search)) {
            $user = strtolower($search);
            $users = Subasta::whereRaw('lower(description) like (?)', ["%{$user}%"])->get();
        }
        return $users;
    }

    public function search(Request $request)
    {
        $users = [];
        if (is_numeric($request->search)) {
            $users = Subasta::where('id', $request->search)->get();
        } else if (isset($request->search)) {
            $search = strtolower($request->search);
            $users = Subasta::whereRaw('lower(name) like (?)', ["%{$search}%"])->get();
        }
        return $users;
    }

    //search

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Subasta::destroy($id);
        if ($post) return $post;
    }
}
