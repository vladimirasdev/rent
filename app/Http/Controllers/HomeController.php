<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Routing;
use App\Items;

class HomeController extends Controller
{
    public function showIndex()
    {
        function dateDiff($date) {
            $now = time();
            $datediff = $now - strtotime($date);
            return round($datediff / (60 * 60 * 24));
        }

        $meta_title = "Rent Reports";
        $items_total_count = Items::all()->count();
        $items_warehouse_count = 0;
        $items_city_count = 0;
        $items_issue_count = Items::where('issue', '=', 'on')->count();
        $items_issue_in_count = 0;
        $items_issue_out_count = 0;
        $items_intransit_count = 0;
        $items_long_out = [];

        $items = Items::all();
        
        if(isset($items)) {
            foreach ($items as $item) {
                $obj = Routing::where('item_code', $item->item_code)->orderBy('created_at', 'desc')->first();
                if (isset($obj) && $obj["in_out"] == 'in') {
                    $items_warehouse_count = $items_warehouse_count + $obj["quantity"];
                    if ($item->issue == 'on') {
                        ++$items_issue_in_count;
                    }
                }
                elseif (isset($obj) && $obj["in_out"] == 'out') {
                    if (dateDiff($obj["created_at"]) >= 1 && $item->issue != "on") {
                        array_push($items_long_out, $obj);
                    }
                    $items_city_count = $items_city_count + $obj["quantity"];
                    if ($item->issue == 'on') {
                        ++$items_issue_out_count;
                    }
                }
                elseif (isset($obj) && $obj["in_out"] == 'hold') {
                    ++$items_intransit_count;
                }
            }
        }
        
       
        $today_in_count = Routing::where('created_at', '>=', date('Y-m-d').' 00:00:00')->where('in_out', 'in')->sum('quantity');
        $today_out_count = Routing::where('created_at', '>=', date('Y-m-d').' 00:00:00')->where('in_out', 'out')->sum('quantity');
        $all_in_count = Routing::all()->where('in_out', 'in')->sum('quantity');
        $all_out_count = Routing::all()->where('in_out', 'out')->sum('quantity');
        $transfer_dates = Routing::get('created_at')->sortBy('created_at');
        $transfer_all = Routing::all()->sortBy('created_at');

        return view('home', compact( 
                'meta_title',
                'items_total_count',
                'items_warehouse_count',
                'items_city_count',
                'items_intransit_count',
                'items_issue_count',
                'items_issue_in_count',
                'items_issue_out_count',
                'today_in_count',
                'today_out_count',
                'all_in_count',
                'all_out_count',
                'transfer_dates',
                'transfer_all',
                'items_long_out'
            ));
    }
}
