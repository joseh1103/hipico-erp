<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Jornada;
use App\Carrera;
use App\Subasta;
use OneSignal;

class JornadaController extends Controller
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

        $total = Jornada::count();
        
        $jornadas = Jornada::orderBy('jornadas.id', 'DESC'); 
      

        if (!$request->filter) {
            $jornadas = $jornadas->limit($limit)->offset($offset);
        }

        if ($request->status) {
            $jornadas = Jornada::where('jornadas.status', $request->status);
        }
        if ($request->typeJornada != 0) {
            $jornadas = Jornada::where('typeJornada', $request->typeJornada);
        }
        if ($request->movil) {
            $jornadas = Jornada::where('movil', 1);
        }

        $jornadas = $jornadas
        ->leftjoin('hipodromos', 'hipodromos.id', '=', 'jornadas.hipodromo_id')
        ->with('carreras')->get(['jornadas.id','jornadas.name', 'jornadas.commission',
        'jornadas.date','jornadas.movil', 'jornadas.status', 'jornadas.typeJornada',
        'hipodromos.id as hipodromo_id', 'hipodromos.image', 'jornadas.currency_id',
        'jornadas.youtube_id',
        'jornadas.url_retrospecto',
        'jornadas.monto'
        ]);
        $arrayQuery = array('total' => $total, 'data' => $jornadas);
        return json_encode($arrayQuery);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function jornadasNotifications(Request $request)
    {
        if ($request->title) {
            OneSignal::sendNotificationToSegment(
                $request->message,
                "All", 
                null, null, null, null, 
                $request->title
            );
        }
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
            'name' => 'required|max:255',
            'date' =>' required',
            'hipodromo_id' =>' required',
            'commission' =>' required',
            'typeJornada' =>' required',
            'status' => 'required',
            'currency_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
            $jornada = $request->id ? Jornada::find($request->id) : new Jornada;      
            $jornada->name = $request->name;
            $jornada->youtube_id = $request->youtube_id;
            $jornada->date = $request->date;
            $jornada->currency_id = $request->currency_id;
            $jornada->hipodromo_id = $request->hipodromo_id;
            $jornada->commission = $request->commission;
            $jornada->typeJornada = $request->typeJornada;
            $jornada->status = $request->status;
            $jornada->movil = $request->movil ? $request->movil : false;
            $jornada->url_retrospecto = $request->url_retrospecto ? $request->url_retrospecto : null;
            $jornada->monto = $request->monto ? $request->monto : null;
            $jornada->jornada_master_id = $request->clone ==1 && $request->id_jornada ? $request->id_jornada : null;
            $jornada->save();

             // or to all users 
             if ($request->movil) {
                OneSignal::sendNotificationToSegment(
                    $jornada->name,
                    "All", 
                    null, null, null, null, 
                    "Nueva jornada disponible"
                );
             }

        //crear las carreras de una jornada clonada
        if ($request->clone ==1 && $request->id_jornada) {
            $this->createCarrera($jornada->id, $request->carreras);
            if ($request->typeJornada == 1) {
                $this->clonateSubasta($request->id_jornada, $jornada->id, $request->carreras);
            }
            
        }
        
        return $jornada;
    }

    public function createCarrera($jornada_id, $carreras) {
        foreach($carreras as $item) {
            $carreraDb = Carrera::where('carrera',$item['carrera'])->where('jornada_id', $jornada_id)->first();
            $carreraDb = $carreraDb ? $carreraDb : new Carrera;
            $carreraDb->jornada_id = $jornada_id;
            $carreraDb->carrera = $item['carrera'];
            $carreraDb->distance = $item['distance'];
            $carreraDb->detail = $item['detail'];
            $carreraDb->hour = $item['hour'];
            $carreraDb->incentive = $item['incentive'];
            $carreraDb->status_cierre = $item['status_cierre'];
            $carreraDb->status_movil = $item['status_movil'];
            $carreraDb->save();    
        }
    }

    public function clonateSubasta($jornada_id,$new_jornada_id ,$carreras) {

        if ($jornada_id) {
            $array_id_subasta = [];
            foreach($carreras as $item) {
                array_push($array_id_subasta, $item['carrera']);
            }

            $subastas = Subasta::where('jornada_id',$jornada_id)
            ->whereIn('carrera_id', $array_id_subasta)->get();
           
            foreach($subastas as $item) {
                $carreraDb = new Subasta;  
                $carreraDb->user_id = $item['user_id'];
                $carreraDb->jornada_id = $new_jornada_id;
                $carreraDb->carrera_id = $item['carrera_id'];
                $carreraDb->ejemplar = $item['ejemplar'];
                $carreraDb->name_ejemplar = $item['name_ejemplar']; 
                $carreraDb->monto_winner = 0;
                $carreraDb->monto = !$item['status_retired'] ? 0 : $item['monto'];
                $carreraDb->winner = $item['winner'];
                $carreraDb->status_retired = $item['status_retired'];
                $carreraDb->save();
            }
        }
    }

    public function upload(Request $request) {

        $hipodromo =  Jornada::find($request->id);
        $file = $request->file('image');
        if($file) {
           $imageName = time().'.'.$request->image->getClientOriginalExtension();
           $request->image->move(public_path('/hipodromos/file'), $imageName);
           $hipodromo->url_retrospecto = $imageName;
           $hipodromo->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if ($id) {
            $jornada = Jornada::with('carreras')->with('hipodromo')->find($id);
            return $jornada;
        } 
    }

    public function search(Request $request)
    {
        $users = [];
        if (is_numeric($request->search)) {
            $users = Jornada::where('id', $request->search)->get();
        } else if (isset($request->search)) {
            $search = strtolower($request->search);
            $users = Jornada::whereRaw('lower(name) like (?)', ["%{$search}%"])->get();
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
        $post = Jornada::destroy($id);
        if ($post) return $post;
    }
}
