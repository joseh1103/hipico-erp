<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Poso;
use App\Balance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use App\Subasta;
use App\Jornada;
use Carbon\Carbon;
use App\Polla;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $balance = User::leftjoin('balance_general', 'balance_general.user_id', '=', 'users.id')
            ->select(
                'users.id',
                DB::raw('SUM(balance_general.monto) as posed_available')
            )
            ->groupBy('balance_general.user_id')
            ->groupBy('users.id')
            ->orderBy('id', 'ASC')
            ->where('user_id','!=' ,1)
            ->get();

        $posos = Poso::select(
            DB::raw('SUM(poso.monto) as posed_pending')
        )
            ->where('status_authorization', 0)->where('user_id','!=' ,1)->get();

        $bank = Poso::select(
            'destination_bank',
            'origin_bank',
            'payment_type',
            DB::raw('SUM(monto) as posed_available')
        )
            ->groupBy('poso.destination_bank')
            ->groupBy('poso.origin_bank')
            ->groupBy('poso.payment_type')
            ->orderBy('id', 'ASC')
            ->where('status_authorization', 1)
            ->get();

        //ganancia o perdida casa por jornada

        //resumen por jornada
        $jornadas = Jornada::where('status', 1)->get(['id']);
        $id_jornadas = [];
        foreach ($jornadas as $item) {
            array_push($id_jornadas, $item['id']);
        }

        $resumenWin = $this->dataResponse();


        $user = User::where('status', 1)->count();

        $arrayQuery = array('data' => $balance, 'posos' => $posos, 'users' => $user, 'bank' => $bank, 'win' => $resumenWin);
        return json_encode($arrayQuery);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $ponle = $request->id ? Poso::find($request->id) : new Poso;

        $ponle->user_id = $request->user_id;
        $ponle->user_approvals_id = $user->id;
        $ponle->origin_bank = $request->payment_type != 1 ? $request->origin_bank : '';
        $ponle->destination_bank = $request->payment_type == 1 ? $request->destination_bank : '';
        $ponle->payment_type = $request->payment_type;
        $ponle->monto = $request->monto;
        $ponle->description = $request->description;

        //$ponle->user_to_id = $request->user_to_id; //usuario que recibe fondos
        $ponle->status_authorization = $user->role_id !== 1 ? 0 : $request->status_authorization;
        $ponle->save();
        //user admin
        if ($user->role_id == 1 && $ponle->status_authorization == 1) {
            $this->addBalance($ponle);
        }
        return $ponle;
    }

    public function addBalance($ponle)
    {
        $balance = Balance::where('poso_id', $ponle->id)->first();
        $balance = $balance ? $balance : new Balance;
        $balance->user_id = $ponle->user_id;
        $balance->monto = $ponle->payment_type == 1 ? $ponle->monto : (-$ponle->monto);
        $balance->description = $ponle->description;
        $balance->operations = $ponle->payment_type == 1 ? 'posos' : 'retiro';
        $balance->poso_id = $ponle->id;
        $balance->status = 1;
        $balance->save();

        return $balance;
    }

    public function userBalance($user_id)
    {
        $user = User::leftjoin('balance_general', 'balance_general.user_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.status',
                'users.email',
                'users.phone',
                'users.user',
                'users.name',
                DB::raw('SUM(balance_general.monto) as posed_available')
            )
            ->groupBy('balance_general.user_id')
            ->groupBy('users.user', 'users.email', 'users.phone', 'users.name', 'users.id', 'users.status')
            ->orderBy('id', 'ASC')
            ->where('poso_id', $user_id)->first();

        return $user;
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
            $users = User::whereRaw('lower(description) like (?)', ["%{$user}%"])->get();
        }
        return $users;
    }

    public function search(Request $request)
    {
        $users = [];
        if (is_numeric($request->search)) {
            $users = User::where('id', $request->search)->get();
        } else if (isset($request->search)) {
            $search = strtolower($request->search);
            $users = User::whereRaw('lower(name) like (?)', ["%{$search}%"])->get();
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
        $post = Poso::destroy($id);
        if ($post) return $post;
    }

    public function generatePDF(Request $request)
    {

        $jornadas = Jornada::with('carreras')
            ->where('jornadas.id', $request->id)->first();


        $subasta = Subasta::where('jornada_id', $request->id)
            ->with('user')
            ->get()->groupBy('carrera_id');

        $responserSubasta = [];
        $commission = $jornadas['commission'];

        foreach ($subasta as $carrera) {
            //carrera a carrera
            $total = 0;
            $carrera_id = 0;
            $monto_winner = 0;
            $jugada_casa = 0;
            $users_winner = '';
            $id_users_winner = [];
            $winner_premio_repartir = 0;
            foreach ($carrera as $item) {
                $total += $item['monto'] > 0 ? $item['monto'] : 0;
                $carrera_id = $item['carrera_id'];
                $monto_winner += $item['monto_winner'];
                $jugada_casa += $item['user_id'] == 1 ? $item['monto'] : 0;
                $users_winner .= $item['winner'] > 0 ? $item['user']['user'] . ' ' : null;
                $item['winner'] > 0 ? array_push($id_users_winner, $item['user']['id']) : null;

                $winner_premio_repartir += $item['user_id'] == 1 ? 0 : $item['monto_winner'];
            }
            $commission_casa = ($total * $commission) / 100;
            $carreraData = $this->filterCarrera($jornadas, $carrera_id);

            //total a pagar de la tabla
            $total_pay = ($total - $commission_casa) + $carreraData['incentive'];

            // ganancia o perdida de casa sin premio

            if (in_array('1', $id_users_winner)) {
                //verificar si hay + de 1 ganador incluyendo a la casa
                $countGandores = count($id_users_winner);
                if ($countGandores > 1) {
                    $total_ganancia = ($total_pay - $winner_premio_repartir) - $jugada_casa;
                } else {
                    //casa recoge todo el premio neto de los inversionista
                    $total_ganancia = ($total - $jugada_casa);
                }
            } else {
                $total_ganancia = ($commission_casa - $jugada_casa) - $carreraData['incentive'];
            }

            $value = array(
                "total" => $total,
                "commssion" => $commission_casa,
                "carrera_id" => $carrera_id,
                "monto_winner" => $monto_winner,
                "monto_casa" => $jugada_casa,
                "incentive" => $carreraData['incentive'],
                "users_winner" => $users_winner,

                "total_pay" => $total_pay,
                "total_ganancia" => $total_ganancia
            );
            array_push($responserSubasta, $value);
        }
        //  return $responserSubasta;

        $data = [
            'jornada_name' => $jornadas['name'],
            'carreras' => count($jornadas['carreras']),
            'numero' => $request->id,
            'commission' => $jornadas['commission'],
            'porcentajeImpuestos' => 0,
            'data' => $responserSubasta,
            'date' => $jornadas['date']
        ];



        $pdf = PDF::loadView('pdf.invoice', $data);
        return $pdf->download('invoice#' . $request->id . '.pdf');
    }

    public function generatePDFPolla(Request $request)
    {

        $jornadas = Jornada::where('jornadas.id', $request->id)->first();


        $pollas = Polla::select(
                'users.id',
                'users.user',
                'jornada_id',
                'group_polla',
                DB::raw('SUM(puntos) as posed_available')
            )
                ->leftjoin('users', 'polla.user_id', '=', 'users.id')
                ->groupBy('group_polla', 'jornada_id', 'users.id', 'users.user')
                ->orderBy('posed_available', 'Desc')
                ->where('jornada_id', $request->id)
                ->get();

        $commission = $jornadas['commission'];

        $subtotalJugada = count($pollas) * $jornadas['monto'];
        $ganancianeta = ($subtotalJugada *  $commission) / 100;


        $data = [
            'jornada_name' => $jornadas['name'],
            'carreras' => count($jornadas['carreras']),
            'numero' => $request->id,
            'commission' => $jornadas['commission'],
            'porcentajeImpuestos' => 0,
            'data' => $pollas,
            'date' => $jornadas['date'],
            'subtotal' => $subtotalJugada,
            'ganancia' => $ganancianeta,
            'combinaciones' => count($pollas),
            'cost' => $jornadas['monto']
        ];



        $pdf = PDF::loadView('pdf.pdfpolla', $data);
        return $pdf->download('invoice#' . $request->id . '.pdf');
    }

    /*
     REPORT: JORNADAS ABIERTAS

    */
    public function generateReporte(Request $request)
    {
        
        $dataResponse = $this->dataResponse();

        $today = new Carbon;
        $data = [
           'data' => $dataResponse,
           'date' => $today->toDateString()
        ];
   
       $pdf = PDF::loadView('pdf.jornada_invoice', $data);
       return $pdf->download('reporte.pdf');
    }
    
    public function dataResponse() {
        $jornadas = Jornada::with('carreras')
            ->where('jornadas.status', 1)->get();
        
        $responserSubasta = [];
        foreach ($jornadas as $jornada) {
            $subasta = Subasta::where('jornada_id', $jornada['id'])
                ->with('user')
                ->get()->groupBy('carrera_id');
            $commission = $jornada['commission'];

            foreach ($subasta as $carrera) {
                //carrera a carrera
                $total = 0;
                $carrera_id = 0;
                $monto_winner = 0;
                $jugada_casa = 0;
                $users_winner = '';
                $id_users_winner = [];
                $winner_premio_repartir = 0;
                foreach ($carrera as $item) {
                    $total += $item['monto'] > 0 ? $item['monto'] : 0;
                    $carrera_id = $item['carrera_id'];
                    $monto_winner += $item['monto_winner'];
                    $jugada_casa += $item['user_id'] == 1 ? $item['monto'] : 0;
                    $users_winner .= $item['winner'] > 0 ? $item['user']['user'] . ' ' : null;
                    $item['winner'] > 0 ? array_push($id_users_winner, $item['user']['id']) : null;

                    $winner_premio_repartir += $item['user_id'] == 1 ? 0 : $item['monto_winner'];
                }
                $commission_casa = ($total * $commission) / 100;
                $carreraData = $this->filterCarrera($jornada, $carrera_id);

                //total a pagar de la tabla
                $total_pay = ($total - $commission_casa) + $carreraData['incentive'];

                // ganancia o perdida de casa sin premio

                if (in_array('1', $id_users_winner)) {
                    //verificar si hay + de 1 ganador incluyendo a la casa
                    $countGandores = count($id_users_winner);
                    if ($countGandores > 1) {
                        $total_ganancia = ($total_pay - $winner_premio_repartir) - $jugada_casa;
                    } else {
                        //casa recoge todo el premio neto de los inversionista
                        $total_ganancia = ($total - $jugada_casa);
                    }
                } else {
                    $total_ganancia = ($commission_casa - $jugada_casa) - $carreraData['incentive'];
                }

                $value = array(
                    "total" => $total,
                    "commssion" => $commission_casa,
                    "jornada_id" => $jornada['id'],
                    "carrera_id" => $carrera_id,
                    "monto_winner" => $monto_winner,
                    "monto_casa" => $jugada_casa,
                    "incentive" => $carreraData['incentive'],
                    "users_winner" => $users_winner,
                    "date" => $jornada['date'],
                    "total_pay" => $total_pay,
                    "total_ganancia" => $total_ganancia
                );
                array_push($responserSubasta, $value);
            }
            //  return $responserSubasta;
        }
        $dataResponse = $this->groupby($responserSubasta, 'jornada_id');
        $reportResponse = [];

        foreach($dataResponse as $jornadaResponse) {
            $total_ganancia = 0;
            $incentive = 0;
            $jornada_id = 0;
            $monto_casa = 0;
            $total_pay = 0;
            $date = null;
            foreach($jornadaResponse as $data) {
                $total_ganancia += $data['total_ganancia'];
                $incentive += $data['incentive'];
                $monto_casa += $data['monto_casa'];
                $total_pay += $data['total_pay'];
                $jornada_id = $data['jornada_id'];
                $date = $data['date'];
            }

        
        $value = array(
            "total" => $total,
            "monto_casa" => $monto_casa,
            "jornada_id" => $jornada_id,
            "incentive" => $incentive,
            "total_ganancia" => $total_ganancia,
            "total_pay" => $total_pay,
            "date" => $date
        );
        array_push($reportResponse, $value);
        }
        return $reportResponse;
    }

    public function groupby($array, $key) {
        $return = array();
        foreach($array as $val) {
            $return[$val[$key]][] = $val;
        }
        return $return;
    }

    public function filterCarrera($jornada, $carrera_id)
    {

        foreach ($jornada['carreras'] as $item) {
            if ($item['carrera'] == $carrera_id) {
                return $item;
            }
        }
    }
}
