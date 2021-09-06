<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Carrera;
use OneSignal;

class CarreraController extends Controller
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

        $total = Carrera::count();

        $users = Carrera::orderBy('id', 'DESC');
        $users = $users->limit($limit)->offset($offset);

        if ($request->search) {
            $search = strtolower($request->search);
            $users = Carrera::whereRaw('lower(name) like (?)', ["%{$search}%"]);
        }
        $users = $users->get();
        $arrayQuery = array('total' => $total, 'data' => $users);
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
        $validator = Validator::make($request->all(),  [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $jornada_id = $request->id;
        $carreras = $request->carreras;
        foreach ($carreras as $item) {

            $carreraDb = Carrera::where('carrera', $item['carrera'])->where('jornada_id', $jornada_id)->first();
            $carreraDb = $carreraDb ? $carreraDb : new Carrera;

            $carreraDb->jornada_id = $jornada_id;
            $carreraDb->carrera = $item['carrera'];
            $carreraDb->distance = $item['distance'];
            $carreraDb->detail = $item['detail'];
            $carreraDb->hour = $item['hour'];
            $carreraDb->incentive = $item['incentive'];
            $carreraDb->status_cierre = $item['status_cierre'] == 1 ? true : false;
            $carreraDb->status_movil = $item['status_movil'] == 1 ? true : false;
            $carreraDb->save();

            if ($item['status_cierre'] == 1 && $item['status_movil'] == 1) {
                OneSignal::sendNotificationToSegment(
                    "Carrera #" . $carreraDb->carrera. " Disponible",
                    "All",
                    null,
                    null,
                    null,
                    null,
                    "Nueva subasta abierta"
                );
            }
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
        $users = [];
        if (isset($search)) {
            $user = strtolower($search);
            $users = Carrera::whereRaw('lower(description) like (?)', ["%{$user}%"])->get();
        }
        return $users;
    }

    public function search(Request $request)
    {
        $users = [];
        if (is_numeric($request->search)) {
            $users = Carrera::where('id', $request->search)->get();
        } else if (isset($request->search)) {
            $search = strtolower($request->search);
            $users = Carrera::whereRaw('lower(name) like (?)', ["%{$search}%"])->get();
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
        $post = Carrera::destroy($id);
        if ($post) return $post;
    }
}
