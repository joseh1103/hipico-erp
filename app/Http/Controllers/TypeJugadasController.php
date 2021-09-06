<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TypeJugada;

class TypeJugadasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $hipodromos = TypeJugada::orderBy('id', 'ASC');     

        if ($request->search) {
            $search = strtolower($request->search);
            $hipodromos = TypeJugada::whereRaw('lower(name) like (?)',["%{$search}%"]);
        }
        $hipodromos = $hipodromos->get();
        $arrayQuery = array('data' => $hipodromos);
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
        $currency = $request->id ? TypeJugada::find($request->id) : new TypeJugada;      
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
        $post = TypeJugada::destroy($id);
        if ($post) return $post;
    }
}
