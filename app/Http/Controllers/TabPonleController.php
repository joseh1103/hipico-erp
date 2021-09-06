<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\TabPonle;

class TabPonleController extends Controller
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

        $total = TabPonle::count();
        
        $hipodromos = TabPonle::orderBy('id', 'DESC');       
        $hipodromos = $hipodromos->limit($limit)->offset($offset);

        if ($request->search) {
            $search = strtolower($request->search);
            $hipodromos = TabPonle::whereRaw('lower(name) like (?)',["%{$search}%"]);
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
        $ponle = $request->id ? TabPonle::find($request->id) : new TabPonle;      
        $ponle->ini_monto = $request->ini_monto;
        $ponle->end_monto = $request->end_monto;
        $ponle->value = $request->value;
        if ($ponle->save()){
            return $ponle;
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
        $post = TabPonle::destroy($id);
        if ($post) return $post;
    }
}
