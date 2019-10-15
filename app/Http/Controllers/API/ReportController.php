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
use App\Customer;
use App\Expensecategory;
use App\Purchase;
use App\Sale;

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
        
        $products = Product::select('id','name', 'store_id')->where('store_id', $store->id)->get();

        $products->push(['id' => 0, 'name' => 'সব পণ্য', 'store_id' => $store->id]);

        return response()->json(array_reverse($products->all()));
    }

    public function loadCustomersForReport($code)
    {
        $store = Store::where('code', $code)->first();
        
        $customers = Customer::select('id', DB::raw(DB::raw("CONCAT(name, ' (', mobile, ')') AS name")))->where('store_id', $store->id)->get();

        $customers->push(['id' => 0, 'name' => 'সকল কাস্টমার', 'store_id' => $store->id]);

        return response()->json(array_reverse($customers->all()));
    }

    public function loadExpenseCategoriesForReport($code)
    {
        $store = Store::where('code', $code)->first();
        
        $expensecategories = Expensecategory::select('id', 'name')
                                            ->where('store_id', $store->id)
                                            ->orWhere('type', 0) // 0 for common categories
                                            ->get();

        $expensecategories->push(['id' => 0, 'name' => 'সকল খরচের ধরণ', 'store_id' => $store->id]);

        return response()->json(array_reverse($expensecategories->all()));
    }

    public function loadStaffsForAttReport($code)
    {
        $store = Store::where('code', $code)->first();
       
        $staffs = Staff::select('id', 'name', 'store_id')->where('store_id', $store->id)->get();
        
        $staffs->push(['id' => 0, 'name' => 'সব কর্মচারী', 'store_id' => $store->id]);

        return response()->json(array_reverse($staffs->all()));
    }

    public function loadAllTransactionsToday($code)
    {
        $store = Store::where('code', $code)->first();
        $date = date('2019-10-11'); // change to today Y-m-d
        $purchases = Purchase::where('store_id', $store->id)
                             ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($date)), date('Y-m-d 23:59:59', strtotime($date . '+1 day'))])
                             ->get();
        foreach ($purchases as $purchase) {
            $purchase->transaction_type = 'purchase';
        }

        $sales = Sale::where('store_id', $store->id)
                     ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($date)), date('Y-m-d 23:59:59', strtotime($date . '+1 day'))])
                     ->get();
        foreach ($sales as $sale) {
            $sale->transaction_type = 'sale';
        }

        $expenses = Expense::where('store_id', $store->id)
                           ->whereBetween('created_at', [date('Y-m-d 00:00:00', strtotime($date)), date('Y-m-d 23:59:59', strtotime($date . '+1 day'))])
                           ->get();
        foreach ($expenses as $expense) {
            $expense->transaction_type = 'expense';
        }

        $alltransactions = $purchases->merge($sales)->merge($expenses)->sortBy('created_at');

        $markup = '';
        foreach($alltransactions as $transacetion) {
            $markup .= '<span>Rifat</span><br>';
        }
        return $markup;
    }
}
