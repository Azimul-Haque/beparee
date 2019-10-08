<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Store;
use App\Staff;
use App\Staffattendance;
use App\Expense;
use App\Vendor;
use App\Duehistory;
use App\Product;

use Image, File, DB;

class ReportController extends Controller
{
	public function __construct()
	{        
	    // $this->middleware('auth:api'); 
	}

    public function loadVendorsForAttReport($code)
    {
        $store = Store::where('code', $code)->first();

        $vendors = Vendor::select('id', 'name', 'store_id')->where('store_id', $store->id)->get();
        
        $vendors->push(['id' => 0, 'name' => 'সব ভেন্ডর/ ডিলার', 'store_id' => $store->id]);

        return response()->json(array_reverse($vendors->all()));
    }

    public function loadProducts($code)
    {
        $store = Store::where('code', $code)->first();
        
        $products = Product::select('id','name', 'unit')->where('store_id', $store->id)->get();

        $products->push(['id' => 0, 'name' => 'সব পণ্য', 'store_id' => $store->id]);

        return response()->json(array_reverse($products->all()));
    }
}
