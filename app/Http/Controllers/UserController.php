<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Jornada;
use App\Balance;
use App\Subasta;
use App\Polla;


class UserController extends Controller
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



        $total = User::count();

        $users = User::orderBy('id', 'DESC');

        $users = User::leftjoin('balance_general', 'balance_general.user_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.status',
                'users.email',
                'users.country',
                'users.phone',
                'users.user',
                'users.name',
                'users.role_id',
                DB::raw('SUM(balance_general.monto) as posed_available')
            )
            ->groupBy('balance_general.user_id')
            ->groupBy('users.user', 'users.role_id', 'users.email','users.country' ,'users.phone', 'users.name', 'users.id', 'users.status')
            ->orderBy('id', 'ASC');



        if ($request->search) {
            $search = strtolower($request->search);
            $users = $users->whereRaw('lower(user) like (?)', ["%{$search}%"]);
        }

        if ($request->status) {
          
            $users = $users->where('users.status', $request->status);
        }

        $users = $users->limit($limit)->offset($offset)->get();

        $arrayQuery = array('total' => $total, 'data' => $users);
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
        if ($request->id) {
            $rules = [
                'name' => 'required|max:255',
                'email' => 'unique:users,email,' . $request->id,
                'user' => 'unique:users,user,' . $request->id,
                'password' => 'required|min:8',
                'phone' => 'required|min:10'
            ];
        } else {
            $rules = [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255|unique:users',
                'user' => 'required|max:255|min:4|unique:users',
                'password' => 'required|min:8',
                'phone' => 'required|min:10'
            ];
        }

        // Ejecutamos el validador, en caso de que falle devolvemos la respuesta
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'errors'  => $validator->errors()->all()
            ], 422);
        }

        $user = Auth::user();

        $user = $request->id ? User::find($request->id) : new User;
        $user->name           =   $request->name;
        $user->email          =   $request->email;
        $user->user          =   $request->user;
        $user->password       =   bcrypt($request->password);
        $user->phone          =   $request->phone;
        $user->country        =   substr($request->phone,0,3);

        $user->role_id = $user && $user->role_id == 1 ? $request->role_id : 2;

        if ($user->save()) {
            return $user;
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
        $detail = [];
        $total = 0;
        $infoUser = null;
        if (isset($id)) {

            $infoUser = User::addSelect([
                'users.user',
                'posed_available' => Balance::select(DB::raw('SUM(balance_general.monto) as posed_available'))->whereColumn('id', 'balance_general.user_id'),
                //'diferido'=> Subasta::select(DB::raw('SUM(subasta.monto) as diferido'))->whereColumn('id', 'subasta.user_id'),
            ])->find($id);

            $total = Balance::where('user_id', $id)->count();

            $detail = Balance::where('user_id', $id)->get();
        }
        $arrayQuery = array('total' => $total, 'data' => $detail, 'user' => $infoUser);
        return json_encode($arrayQuery);
    }

    public function detail(Request $request)
    {
        $limit = $request->limit;
        $offset = $request->offset;
        $user = Auth::user();
        $user_id = $user->role_id == 1 && $request->user_id ? $request->user_id: $user->id;

        $detail = [];
        $total = 0;
        $unloack= 0;
        $infoUser = null;
        if (isset($user_id)) {
            $jornadas = Jornada::where('status', 1)->get(['id']);
            $id_jornadas = [];
            foreach ($jornadas as $item) {
                array_push($id_jornadas, $item['id']);
            }

            $infoUser = User::leftjoin('balance_general', 'balance_general.user_id', '=', 'users.id')
                ->select(
                    'users.id',
                    'users.user',
                    DB::raw('SUM(balance_general.monto) as posed_available')
                )
                ->groupBy('balance_general.user_id')
                ->groupBy('users.user', 'users.id')
                ->find($user_id);


            $total = Balance::where('user_id', $user_id)->count();

            $detail = Balance::limit($limit)->offset($offset)->where('user_id', $user_id);

            if ($request->jornada_id) {
                $detail = $detail->whereIn('jornada_id', $request->jornada_id);
            } else {
                $detail = $detail->whereIn('balance_general.jornada_id', $id_jornadas)
                    ->orWhere('balance_general.jornada_id', null)
                    ->where('balance_general.user_id', $user_id);
            }
            $detail = $detail->get();

            // saldo incial
            $saldoI = Balance::leftjoin('jornadas', 'jornadas.id', '=', 'balance_general.jornada_id')
                ->select(
                    DB::raw('SUM(balance_general.monto) as monto')
                )
                ->where('balance_general.user_id', $user_id)
                ->where('balance_general.jornada_id', null)
                ->first();

            //resumen por jornada
            $resumen = Balance::leftjoin('jornadas', 'jornadas.id', '=', 'balance_general.jornada_id')
                ->select(
                    'balance_general.jornada_id',
                    'jornadas.name',
                    DB::raw('SUM(balance_general.monto) as monto')
                )
                ->groupBy('balance_general.jornada_id')
                ->groupBy('balance_general.jornada_id', 'jornadas.name')
                ->orderBy('jornadas.id', 'ASC')
                ->whereIn('balance_general.jornada_id', $id_jornadas)
                ->where('balance_general.user_id', $user_id)
                ->where('jornadas.status', 1)
                ->get();
        $saldo_bloqueado = $this->blockedBalance($user);
        $unloack = $saldo_bloqueado ? $saldo_bloqueado->locked : 0;
                
        }
        $arrayQuery = array('total' => $total, "unloack"=>$unloack ,'data' => $detail, 'user' => $infoUser, 'resumen' => $resumen, 'initialbalance' => $saldoI);
        return json_encode($arrayQuery);
    }

        /**
     * Display monto bloqueado o diferido.
     * @param idJornada
     * @param idCarrera
     * @return [1]CARRERA
     */
    public function blockedBalance($user)
    {
        $locked = Subasta::select('user_id', DB::raw('SUM(monto) as locked'))
            ->groupBy('user_id')
            ->where('status_close', 1)
            ->where('user_id', $user->id)
            ->first();
        return $locked;
    }


    public function search(Request $request)
    {
        $users = [];
        if (is_numeric($request->search)) {
            $users = User::where('id', $request->search)->get();
        } else if (isset($request->search)) {
            $search = strtolower($request->search);
            $users = User::whereRaw('lower(user) like (?)', ["%{$search}%"])->get();
        }
        if (isset($request->all)) {
            $users = User::get();
            $arrayQuery = array('data' => $users);
            return json_encode($arrayQuery);
        }

        return $users;
    }
    //
    public function availablepuntos(Request $request)
    {
        $users = [];
        if ($request->jornada_id) {
            $users = Polla::select(
                'users.id',
                'users.user',
                'jornada_id',
                'group_polla',
                DB::raw('SUM(puntos) as posed_available')
            )
                ->leftjoin('users', 'polla.user_id', '=', 'users.id')
                ->groupBy('group_polla', 'jornada_id', 'users.id', 'users.user')
                ->orderBy('posed_available', 'Desc')
                ->where('jornada_id', $request->jornada_id)
                ->get();
        }
        $arrayQuery = array('data' => $users);
        return json_encode($arrayQuery);
    }

    public function available(Request $request)
    {
        $users = [];
        if ($request->user_array) {
            /*
            $users = User::addSelect([
               'posed_retenido'=> Subasta::select(DB::raw('SUM(subasta.monto) as retenido'))->whereColumn('id', 'subasta.user_id'),
               'posed_available'=> Balance::select(DB::raw('SUM(balance_general.monto) as posed_available'))->whereColumn('id', 'balance_general.user_id'),
            ])
            ->whereIn('users.id', $request->user_array)->orderBy('id', 'ASC')->get();*/



            $users = User::select(
                'users.id',
                'users.user',
                DB::raw('SUM(balance_general.monto) as posed_available'))
                ->leftjoin('balance_general', 'balance_general.user_id', '=', 'users.id')
                ->groupBy('balance_general.user_id')
                ->groupBy('users.user', 'users.id')
                ->orderBy('users.id', 'ASC')
                ->whereIn('users.id', $request->user_array)
                ->get();
        }
        $arrayQuery = array('data' => $users);
        return json_encode($arrayQuery);
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
        $post = User::find($id);
        if ($post) {
            $post->status = 0;
            $post->save();
            return $post;
        }
    }
}
