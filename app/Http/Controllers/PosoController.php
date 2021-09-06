<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Poso;
use App\Balance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Setting;
use Illuminate\Support\Facades\Mail;

class PosoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = $request->limit;
        $offset = $request->offset;

        $total = Poso::count();
        
        $hipodromos = Poso::orderBy('id', 'DESC');       
        $hipodromos = $hipodromos->limit($limit)->offset($offset);

        if ($request->search) {
            $search = strtolower($request->search);
            $users = $hipodromos->whereRaw('lower(description) like (?)', ["%{$search}%"]);
        }

        if (isset($request->payment_type)) {
            $payment_type = $request->payment_type;
            $hipodromos = $hipodromos->where('payment_type', $payment_type);
        }
        if (isset($request->status_authorization)) {
            $status_authorization = $request->status_authorization;
            $hipodromos = $hipodromos->where('status_authorization', $status_authorization);
        }
        if (isset($request->code_bank)) {
            $code_bank = $request->code_bank;
            $hipodromos = $hipodromos->where('origin_bank', $code_bank)->Orwhere('destination_bank', $code_bank);
        }
        if (isset($request->from)) {
            $dateFrom = $request->from;
            $dateTo= $request->to;
            $hipodromos = $hipodromos->whereBetween('created_at', [$dateFrom, $dateTo]) ;
        }

        //from
        $hipodromos = $hipodromos->with('user')->get();
        $arrayQuery = array('total' => $total, 'data' => $hipodromos);
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
        $rules = [
             'monto' => 'required',
         ];
         // Ejecutamos el validador, en caso de que falle devolvemos la respuesta
         $validator = Validator::make($request->all(), $rules);
         if ($validator->fails()) {
             return response()->json([
                 'errors'  => $validator->errors()->all()
             ], 422);
         }

        $user = Auth::user();
        $setting = Setting::first();
        
        if ($request->payment_type == 1 && $request->monto  < $setting->min_poso) {
            return response()->json([
                'error' => 'El poso minimo debe ser de '. $setting->min_poso
            ], 450);
        }
        if ($request->payment_type == 2 && $request->monto  < $setting->min_retiro) {
            return response()->json([
                'errors' => ['El monto minimo de retiro es de '. $setting->min_poso]
            ], 422);
        }
        $user_id = $user->role_id == 1 ? $request->user_id : $user->id;
         if ($request->payment_type == 2 && $user_id != 1) {

            //consultar saldo
            $available = User::leftjoin('balance_general', 'balance_general.user_id', '=', 'users.id')
            ->select(
                DB::raw('SUM(balance_general.monto) as available')
            )
            ->groupBy('balance_general.user_id')
            ->groupBy('users.user', 'users.id')
            ->find($user_id);
            $available = $available->available ? $available->available : 0;
            if ($request->monto > $available) {
            return response()->json([
                'errors' => ['Saldo insuficiente']
            ], 422);
            }
        }


        $ponle = $request->id ? Poso::find($request->id) : new Poso; 

        $ponle->user_id = $user->role_id == 1 ? $request->user_id : $user->id;
        $ponle->user_approvals_id = $user->role_id == 1 ? $user->id : 0;
        $ponle->origin_bank = $request->payment_type != 1 ? $request->origin_bank : '';
        $ponle->destination_bank = $request->payment_type == 1 ? $request->destination_bank : '';
        $ponle->payment_type = $request->payment_type;
        $ponle->monto = $request->monto;
        $ponle->description = $request->description;

        $ponle->id_account_user = $request->id_account_user ? $request->id_account_user : null;

        //$ponle->user_to_id = $request->user_to_id; //usuario que recibe fondos
        $ponle->status_authorization = $user->role_id == 1 ? $request->status_authorization : 0;
        $ponle->save();
        //user admin

        if ($user->role_id ==1 && $request->status_authorization ==1) {
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
        $balance->operations = $ponle->payment_type == 1 ? 'posos': 'retiro';
        $balance->poso_id = $ponle->id;
        $balance->status = 1;
        $balance->save();

        return $balance;
    }

    public function userBalance($user_id) {
        $user = User::leftjoin('balance_general', 'balance_general.user_id', '=', 'users.id')
        ->select('users.id', 'users.status', 'users.email', 
        'users.phone', 'users.user','users.name', DB::raw('SUM(balance_general.monto) as posed_available'))
        ->groupBy('balance_general.user_id')
        ->groupBy('users.user', 'users.email', 'users.phone','users.name', 'users.id' , 'users.status')
         ->orderBy('id','ASC')
         ->where('poso_id', $user_id)->first();

         return $user;
    }

    public function upload(Request $request) {

        $poso =  Poso::find($request->id);

        $user = User::where('id', $poso->user_id)->first();

        $file = $request->file('image');
        if($file) {
           $imageName = time().'.'.$request->image->getClientOriginalExtension();
           $request->image->move(public_path('/attachments'), $imageName);
           $poso->image = $imageName;
           $poso->save();
        }

        $name = $user->name;
        $email = $user->email;

        $subject = "Confirmacion de Pago Hipico 2020";
        Mail::send(
            'emails.pago',
            ['name' => $name, 'user' => $user->user],
            function ($mail) use ($email, $name, $subject, $imageName) {
                $mail->from(getenv('MAIL_USERNAME'), getenv('APP_NAME'));
                $mail->to($email, $name);
                $mail->subject($subject);
                $mail->attach(public_path('attachments\\').$imageName, [
                    'as' => 'comprobante.jpg',
                    'mime' => 'image/jpeg',
                ]);

            }
        );
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
            $users = User::whereRaw('lower(description) like (?)',["%{$user}%"])->get();
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
}
