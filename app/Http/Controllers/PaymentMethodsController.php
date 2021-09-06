<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaymentMethods;

class PaymentMethodsController extends Controller
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

        $total = PaymentMethods::count();
        
        $hipodromos = PaymentMethods::orderBy('id', 'DESC');       
        $hipodromos = $hipodromos->limit($limit)->offset($offset);

        if ($request->search) {
            $search = strtolower($request->search);
            $hipodromos = PaymentMethods::whereRaw('lower(name) like (?)',["%{$search}%"]);
        }
        $hipodromos = $hipodromos->get();
        $arrayQuery = array('total' => $total, 'data' => $hipodromos);
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
        $currency = $request->id ? PaymentMethods::find($request->id) : new PaymentMethods;      
        $currency->typePayment = $request->typePayment;
        $currency->typeDocument = $request->typeDocument;

        $currency->typeDocument = $request->typeDocument;
        $currency->document = $request->document;
        $currency->phone = $request->phone;
        $currency->name_beneficiary = $request->name_beneficiary;
        $currency->account_number = $request->account_number;
        $currency->code_bank = $request->code_bank;
        $currency->email = $request->email;
        $currency->currency_id = $request->currency_id;
        
        if ($currency->save()){
            return $currency;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = PaymentMethods::destroy($id);
        if ($post) return $post;
    }

    
    public function upload(Request $request) {

        $payment =  PaymentMethods::find($request->id);
        $file = $request->file('image');
        if($file) {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/banck'), $imageName);
           $payment->image = $imageName;
           $payment->save();
        }
    }
}
