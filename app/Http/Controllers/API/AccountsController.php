<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Store;
use App\Sale;
use App\Expense;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AccountsController extends Controller
{
    public function loadLastSevenDaysSales($code) 
    {   
    	$store = Store::where('code', $code)->first();
      $lastsevendayssales = Sale::where('store_id', $store->id)
	                          ->select(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as date"), DB::raw('SUM(payable) as total')) // payable is used, as total_price is discounted later
	                          ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
	                          ->orderBy('created_at', 'DESC')
	                          ->take(7)
	                          ->get();
                                     
      // $datesforcharte = [];
      // foreach ($lastsevendayssales as $key => $days) {
      //     $datesforcharte[] = date_format(date_create($days->created_at), "M d");
      // }
      // // $datesforcharte = json_encode(array_reverse($datesforcharte));
      // $totalsforcharte = [];
      // foreach ($lastsevendayssales as $key => $days) {
      //     $totalsforcharte[] = $days->total;
      // }
      // $totalsforcharte = json_encode($totalsforcharte);

      // $chartData = array_combine($datesforcharte, $totalsforcharte);

      return response()->json($lastsevendayssales);
      
      // dd($totalsforcharte);
    }

    public function loadThisYearsProfit($code) 
    {   
    	$store = Store::where('code', $code)->first();
        $profitcalc = Sale::where('store_id', $store->id)
                          ->select(DB::raw("DATE_FORMAT(created_at, '%M') as date"), DB::raw('SUM(payable) as total'), DB::raw('SUM(total_cost) as cost')) // payable is used, as total_price is discounted later
                          ->where(DB::raw("DATE_FORMAT(created_at, '%Y')"), "=", Carbon::now()->format('Y'))
                          ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"))
                          ->orderBy('created_at', 'ASC')
                          ->get();

        return response()->json($profitcalc);
        
        // dd($profitcalc);
    }

    public function loadProfitCaclThisMonth($code) 
    {   
    	$store = Store::where('code', $code)->first();
        $profitcalc = Sale::where('store_id', $store->id)
                          ->select(DB::raw("DATE_FORMAT(created_at, '%M-%d') as date"), DB::raw('SUM(payable) as total'), DB::raw('SUM(total_cost) as cost')) // payable is used, as total_price is discounted later
                          ->where(DB::raw("DATE_FORMAT(created_at, '%Y-%m')"), "=", Carbon::now()->format('Y-m'))
                          ->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d')"))
                          ->orderBy('created_at', 'ASC')
                          ->get();

        return response()->json($profitcalc);
        
        // dd($profitcalc);
    }
}
