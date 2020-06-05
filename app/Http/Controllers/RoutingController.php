<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RoutingRequest;
use App\Routing;

class RoutingController extends Controller
{
	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getRoute($item_code)
	{
		return view('routing', array( 'route' => Routing::find($item_code) ));
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function changeStatus($id)
	{
		Routing::where('in_out', '=', 'hold')->update(['in_out' => $id, 'created_at' => date('Y-m-d H:m:s')]);

		return redirect('routing');

	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getList($date)
	{
		$transferList = Routing::where('created_at', 'like', '%'.$date.'%')->get();

		return view('routing.codelist', compact( 'transferList' ));
	}

	
    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		$in_count = Routing::where('created_at', '>=', date('Y-m-d').' 00:00:00')->where('in_out', 'in')->count();
		$out_count = Routing::where('created_at', '>=', date('Y-m-d').' 00:00:00')->where('in_out', 'out')->count();
		$hold_count = Routing::where('created_at', '>=', date('Y-m-d').' 00:00:00')->where('in_out', 'hold')->count();

		return view('routing.list', array( 'meta_title' => 'Transfered items list', 'routings' => Routing::all()->sortByDesc("created_at"), 'in_count' => $in_count, 'out_count' => $out_count, 'hold_count' => $hold_count ));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('routing.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(RoutingRequest $request)
	{
		function multiexplode ($delimiters,$data) {
			$MakeReady = str_replace($delimiters, $delimiters[0], $data);
			$Return = explode($delimiters[0], $MakeReady);
			return $Return;
		}
		$item_codes = multiexplode(array(",", ", ", ".", ". ", " ", "\n"), $request->input('item_code'));

		foreach ($item_codes as $code) {
			$code = trim($code, " \t\n\r\x0B");
			$code = strtoupper($code);
			$data = new Routing;
			$data->user_id = $request->input('user_id');
			$data->item_code = $code;
			$data->in_out = $request->input('in_out');
			$data->quantity = $request->input('quantity');
			$data->description = $request->input('description');
			$data->save();
		}
		return redirect('routing');
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
		return view('routing.edit', array( 'route' => Routing::find($id) ));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(RoutingRequest $request, $id)
	{
		$data = Routing::find($id);
		$code = strtoupper($request->input('item_code'));
		$data->item_code = $code;
		$data->in_out = $request->input('in_out');
		$data->quantity = $request->input('quantity');
		$data->description = $request->input('description');
		$data->created_at = $request->input('created_at');
		$data->save();
		return redirect('routing');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Routing::find($id)->delete();
		return redirect('routing');
	}
	
}
