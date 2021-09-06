<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Polla;
use App\Carrera;
use App\Balance;
use App\TabPonle;
use App\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use OneSignal;

class PollaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $subastas = Polla::orderBy('id', 'DESC');
        if ($request->jornada_id && $request->carrera_id) {
            $subastas = Polla::where('jornada_id', $request->jornada_id)
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
                "apostador" => $caballos->user,
                "puntos" => $caballos->puntos
            );
            $total += 1;
            array_push($responserSubasta, $value);
        }

        /* Informacion de la jornada*/
        if ($jornada) {
            //total ca pagar de la tabla
            $commission = $jornada['jornada']['commission'];
            $youtube_id = $jornada['jornada']['youtube_id'];
            $incentive = $jornada->incentive;
            $total = ($total * $jornada['jornada']['monto']);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),  [
            'jornada_id' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $jornada_id = $request->jornada_id;
        $carreras = $request->caballos; //numero de carrera

        $jornada = Carrera::where('carrera', $request->carrera_id)
            ->where('jornada_id', $request->jornada_id)
            ->with('jornada')
            ->first();
        if (isset($request->pizarra)) {
            $jornada->pizarra = $request->pizarra;
            $jornada->save();
        }

        $group = Polla::orderBy('group_polla', 'desc')
            ->first();

        $group_id = $group ? ($group->group_polla + 1) : 1;

        // registrar subasta
        foreach ($carreras as $item) {
            $carreraDb = isset($item['id']) ? Polla::find($item['id']) : new Polla;
            if (isset($request->apostador['id'])) {
                $carreraDb->user_id = $request->apostador['id'];
                $carreraDb->jornada_id = $jornada_id;
            }

            if (isset($item['carrera'])) {
                $carreraDb->carrera_id = $item['carrera'];
            }

            $carreraDb->puntos = $item['puntos'];
            if (!isset($item['id'])) {
                $carreraDb->group_polla = $group_id;
            }
            $carreraDb->ejemplar = $item['ejemplar'];
            $carreraDb->save();
        }
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



    public function search(Request $request)
    {
        $users = [];
        if (is_numeric($request->search)) {
            $users = Polla::where('id', $request->search)->get();
        } else if (isset($request->search)) {
            $search = strtolower($request->search);
            $users = Polla::whereRaw('lower(name) like (?)', ["%{$search}%"])->get();
        }
        return $users;
    }

    public function max_attribute_in_array($arr, $key) {
        $max=null;
        foreach ($arr as $row) {
            if ($row[$key]>$max) {
                $max=$row[$key];
            }
        }
        return $max;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function pollasPremio(Request $request)
    {
        if ($request->jornada_id) {
            $users = Polla::select(
                'users.id',
                'users.user',
                'jornada_id',
                'group_polla',
                DB::raw('SUM(puntos) as posed_available')
            )
                ->leftjoin('users', 'polla.user_id', '=', 'users.id')
                ->groupBy('group_polla', 'jornada_id', 'users.id', 'users.user')
                ->orderBy('posed_available', 'Desc')
                ->with('jornada')
                ->where('jornada_id', $request->jornada_id)
                ->get();
            $dataMax = $this->max_attribute_in_array($users , 'posed_available'); 

            if ($dataMax > 0) {
                return $users;
                foreach ($users as $user) {
                    /*
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
                    }*/
                    
                }

            }
            return $dataMax;
        }
    }
}
