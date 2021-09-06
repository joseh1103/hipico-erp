<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Currency;

class CurrencyController extends Controller
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

        $total = Currency::count();
        
        $hipodromos = Currency::orderBy('id', 'DESC');       
        $hipodromos = $hipodromos->limit($limit)->offset($offset);

        if ($request->search) {
            $search = strtolower($request->search);
            $hipodromos = Currency::whereRaw('lower(name) like (?)',["%{$search}%"]);
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
        $currency = $request->id ? Currency::find($request->id) : new Currency;      
        $currency->name = $request->name;
        $currency->symbol = $request->symbol;
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
        $post = Currency::destroy($id);
        if ($post) return $post;
    }
}
