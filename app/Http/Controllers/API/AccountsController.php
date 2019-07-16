<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Store;
use App\Sale;
use App\Expense;

use DB;

class AccountsController extends Controller
{
    public function loadLastSevenDaysSales($code) 
    {   
    	$store = Store::where('code', $code)->first();
        $lastsevendayssales = Sale::where('store_id', $store->id)
		                          ->select(DB::raw("DATE_FORMAT(created_at, '%M-%d') as date"), DB::raw('SUM(payable) as total')) // payable is used, as total_price is discounted later
		                          ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
		                          ->orderBy('created_at', 'ASC')
		                          ->take(7)
		                          ->get();
        
        $datesforcharte = [];
        foreach ($lastsevendayssales as $key => $days) {
            $datesforcharte[] = date_format(date_create($days->created_at), "M d");
        }
        // $datesforcharte = json_encode(array_reverse($datesforcharte));
        $totalsforcharte = [];
        foreach ($lastsevendayssales as $key => $days) {
            $totalsforcharte[] = $days->total;
        }
        // $totalsforcharte = json_encode($totalsforcharte);

        // $chartData = array_combine($datesforcharte, $totalsforcharte);

        return response()->json($lastsevendayssales);
        
        dd($totalsforcharte);
    }
}
