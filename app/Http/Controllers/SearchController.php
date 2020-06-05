<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Items;
use App\Routing;

class SearchController extends Controller
{
    /**
	 * Display a listing of the resource.
	 *
     * @param  string  $search
	 * @return Response
	 */
    public function postSearch(Request $request)
    {
        $meta_title = "Search results";
        $search = $request->input('search');

        $query = Items::where('item_code', 'like', '%'.$search.'%')
                            ->orWhere('manufacture', 'like', '%'.$search.'%')
                            ->orWhere('model', 'like', '%'.$search.'%')
                            ->orWhere('serial_number', 'like', '%'.$search.'%')
                            ->orWhere('category_id', 'like', '%'.$search.'%')
                            ->orWhere('description', 'like', '%'.$search.'%');
        $items = $query->get()->sortBy("item_code");

        $query2 = Routing::where('item_code', 'like', '%'.$search.'%')
                            ->orWhere('description', 'like', '%'.$search.'%')
                            ->orWhere('created_at', 'like', '%'.$search.'%');
        $itemsTransfer = $query2->get()->sortByDesc("created_at");

        return view('search', compact('items', 'itemsTransfer', 'search', 'meta_title'));
    }
}
