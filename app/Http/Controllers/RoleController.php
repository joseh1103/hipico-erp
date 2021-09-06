<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Role;

class RoleController extends Controller
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

        $total = Role::count();
        
        $users = Role::orderBy('id', 'DESC');       
        $users = $users->limit($limit)->offset($offset);

        if ($request->search) {
            $search = strtolower($request->search);
            $users = Role::whereRaw('lower(name) like (?)',["%{$search}%"]);
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
            $user = $request->id ? Role::find($request->id) : new Role;      
            $user->name           =   $request->name;
        if ($user->save()){
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
        $users = [];
        if (isset($search)) {
            $user = strtolower($search);
            $users = Role::whereRaw('lower(description) like (?)',["%{$user}%"])->get();
        }
        return $users;
    }

    public function search(Request $request)
    {
        $users = [];
        if (is_numeric($request->search)) {
            $users = Role::where('id', $request->search)->get();
        } else if (isset($request->search)) {
            $search = strtolower($request->search);
            $users = Role::whereRaw('lower(name) like (?)', ["%{$search}%"])->get();
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
        $post = Role::destroy($id);
        if ($post) return $post;
    }
}
