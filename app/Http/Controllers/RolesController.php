<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RolesRequest;
use App\Role;
use App\User;

class RolesController extends Controller
{
    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('roles.list', array( 'meta_title' => 'User Roles', 'roles' => Role::all(), 'users' => User::all() ));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('roles.create', array( 'users' => User::all()->sortBy("name") ));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(RolesRequest $request)
	{
        $role = new Role;
        $role->id = $request->input('id');
        $role->level = $request->input('level');
		$role->save();
		return redirect('roles');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		return view('roles.edit', array( 'role' => Role::find($id) ));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(RolesRequest $request, $id)
	{
		$role = Role::find($id);
        $role->id = $request->input('id');
        $role->level = $request->input('level');
		$role->save();
		return redirect('roles');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Role::find($id)->delete();
		return redirect('roles');
	}
}
