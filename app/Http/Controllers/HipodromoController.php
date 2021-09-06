<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Hipodromo;

class HipodromoController extends Controller
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

        $total = Hipodromo::count();
        
        $hipodromos = Hipodromo::orderBy('id', 'DESC');       
        $hipodromos = $hipodromos->limit($limit)->offset($offset);

        if ($request->search) {
            $search = strtolower($request->search);
            $hipodromos = Hipodromo::whereRaw('lower(name) like (?)',["%{$search}%"]);
        }
        $hipodromos = $hipodromos->get();
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
        $hipodromo = $request->id ? Hipodromo::find($request->id) : new Hipodromo;      
        $hipodromo->name = $request->name;
        $hipodromo->status = $request->status;
        if ($hipodromo->save()){
            return $hipodromo;
        }
    }

    public function upload(Request $request) {

        $hipodromo =  Hipodromo::find($request->id);
        $file = $request->file('image');
        if($file) {
            $imageName = time().'.'.$request->image->getClientOriginalExtension();
            $request->image->move(public_path('/hipodromos'), $imageName);
           $hipodromo->image = $imageName;
           $hipodromo->save();
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
        $post = Hipodromo::destroy($id);
        if ($post) return $post;
    }
}
