<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ItemsRequest;
use App\Items;
use App\Category;
use App\Routing;

class ItemsController extends Controller
{
    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('items.list', array( 'meta_title' => 'Inventory items', 'items' => Items::with('category')->get()->sortBy("item_code") ));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        
		return view('items.create', array( 'categories' => Category::all()->sortBy("item_code") ));
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(ItemsRequest $request)
	{
		function multiexplode ($delimiters,$data) {
			$MakeReady = str_replace($delimiters, $delimiters[0], $data);
			$Return = explode($delimiters[0], $MakeReady);
			return $Return;
		}
		$item_codes = multiexplode(array(",", ", ", ".", ". ", " ", "\n"), $request->input('item_code'));

		foreach ($item_codes as $code) {
			if (Items::where('item_code', '=', $code)->exists()) {
				$error = 'Item already exist in database!';
				return view('items.create', array( 'categories' => Category::all()->sortBy("item_code"), 'error' => $error ));
			}
			else {
				$data = new Items;
				$code = strtoupper($code);
				$data->item_code = $code;
				$data->user_id = $request->input('user_id');
				$data->quantity = $request->input('quantity');
				$data->manufacture = $request->input('manufacture');
				$data->model = $request->input('model');
				$data->serial_number = $request->input('serial_number');
				$data->category_id = $request->input('category');
				$data->issue = $request->input('issue');
				$data->description = $request->input('description');
				$data->save();
			}
		}
		return redirect('items');
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
		return view('items.edit', array( 'item' => Items::find($id), 'categories' => Category::all()->sortBy("item_code") ));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(ItemsRequest $request, $id)
	{
		$data = Items::find($id);
		$code = strtoupper($request->input('item_code'));
		$data->item_code = $code;
		$data->quantity = $request->input('quantity');
		$data->manufacture = $request->input('manufacture');
		$data->model = $request->input('model');
		$data->serial_number = $request->input('serial_number');
		$data->category_id = $request->input('category');
		$data->issue = $request->input('issue');
		$data->description = $request->input('description');
		$data->save();
		return redirect('items');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		Items::find($id)->delete();
		return redirect('items');
	}


	public function getItemHistory($code)
    {
		$meta_title = 'Items history';
		$itemInfo = Items::all()->where('item_code', $code);
        $query = Routing::where('item_code', 'like', '%'.$code.'%');
		$itemHistory = $query->get()->sortByDesc("created_at");
		$itemLastTransfer = Routing::where('item_code', $code)->orderBy('created_at', 'desc')->get()->first();

        return view('items.history', compact('meta_title', 'itemInfo', 'itemHistory', 'itemLastTransfer') );
    }
	
	public function getByStatus($status)
	{
		$itemsArray = array();
		$meta_title = 'Items by status: '. $status;
		$items = Items::with('category')->get()->sortBy("item_code");
		foreach ($items as $item) {
			$routeItem = Routing::where('item_code', $item->item_code)->orderBy('created_at', 'desc')->first();
			if ($routeItem->in_out == $status) {
				array_push($itemsArray, $item);
			}
		}
		return view('items.status', array( 'meta_title' => $meta_title, 'items' => $itemsArray ));
	}
}
