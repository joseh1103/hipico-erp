<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Subasta;
use App\SettingBank;
use Illuminate\Support\Facades\Auth;
use App\BankVe;
use App\User;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $bank = SettingBank::orderBy('id', 'DESC');   
        $total = 0;
        if ($request->limit && $request->offset) {

            $total = BankVe::count();
        
            $limit = $request->limit;
            $offset = $request->offset;
            $bank = $bank->limit($limit)->offset($offset);
        } 
        if ($user->role_id !=1) {
            $bank = $bank->where('user_id', $user->id);
        }
        $bank = $bank->get();


        $listBankVe = BankVe::orderBy('id', 'DESC');       

        $listBankVe = $listBankVe->get();

         //consultar saldo
         $available = User::leftjoin('balance_general', 'balance_general.user_id', '=', 'users.id')
         ->select(
             DB::raw('SUM(balance_general.monto) as available')
         )
         ->groupBy('balance_general.user_id')
         ->groupBy('users.user', 'users.id')
         ->find($user->id);
         $user->available = $available->available ? $available->available : 0;

        $arrayQuery = array('list_bank_user' => $bank, 'bank_ve'=> $listBankVe, 'available' => $user->available, 'total' => $total);
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
        $rules = [
           // 'typePayment' => 'required',
            'typeDocument' => 'required',
            'account_number' => 'required|max:20|min:20',
            'name_beneficiary' => 'required',
            'document' => 'required',
            //'phone' => 'required|min:10',
            'code_bank' => 'required|max:4',
           // 'status' => 'required'
        ];
        // Ejecutamos el validador, en caso de que falle devolvemos la respuesta
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'errors'  => $validator->errors()->all()
            ], 422);
        }
        $user = Auth::user();

        $bank = $request->id ? SettingBank::find($request->id) : new SettingBank;

        $bank->user_id           =   $user->id;
        $bank->typePayment          =   'Transferencia';
        $bank->typeDocument          =   $request->typeDocument;
        $bank->document       =   $request->document;
        $bank->name_beneficiary          =   $request->name_beneficiary;
        $bank->account_number          =   $request->account_number;
        $bank->code_bank          =   $request->code_bank;
        $bank->phone = $request->phone;
        $bank->status = 1;

        if ($bank->save()) {
            return response()->json($bank, 201);
        }
    }



    //search

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function datosRetiro($id)
    {
        $bank = SettingBank::find($id);
        return $bank;
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
