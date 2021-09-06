<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Suggestions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SuggestionsController extends Controller
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

        $total = Suggestions::count();
        
        $hipodromos = Suggestions::orderBy('id', 'DESC');       
        $hipodromos = $hipodromos->limit($limit)->offset($offset);

        if ($request->search) {
            $search = strtolower($request->search);
            $hipodromos = Suggestions::whereRaw('lower(message) like (?)',["%{$search}%"]);
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
        $rules = [
            'type' => 'required',
            'message' => 'required',
            'phone' => 'required'
        ];
        // Ejecutamos el validador, en caso de que falle devolvemos la respuesta
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'errors'  => $validator->errors()->all()
            ], 422);
        }
        $user = Auth::user();
        $user_id = $request->user_id ? $request->user_id : $user->id;

        $suggestions = $request->id ? Suggestions::find($request->id) : new Suggestions;     
        $suggestions->type = $request->type;
        $suggestions->message = $request->message;
        $suggestions->phone = $request->phone;
        $suggestions->user_id = $user_id;
        $suggestions->status = $request->status;
        
        if ($suggestions->save()){
            return $suggestions;
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
        $post = Suggestions::destroy($id);
        if ($post) return $post;
    }
}
