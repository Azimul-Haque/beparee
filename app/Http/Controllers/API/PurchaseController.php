<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Store;
use App\Vendor;
use App\Product;
use App\Stock;
use App\Purchase;
use App\Duehistory;

class PurchaseController extends Controller
{
	public function __construct()
	{        
	    // $this->middleware('auth:api'); 
	}
	
    public function loadPurchases($code)
    {
        $store = Store::where('code', $code)->first();
        $purchases = Purchase::where('store_id', $store->id)->orderBy('id', 'desc')->paginate(5);
        $purchases->load('stocks');
        $purchases->load('stocks')->load('stocks.product', 'stocks.vendor');

        return response()->json($purchases);
    }

    public function loadProducts($code)
    {
        $store = Store::where('code', $code)->first();
        $products = Product::select('id','name', 'unit')->where('store_id', $store->id)->get();

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $this->validate($request,array(
            'code'                 => 'required',
            
            // 'product'              => 'required',
            'vendor'               => 'required',

            // 'expiry_date'          => 'sometimes|max:191',
            // 'quantity'             => 'required|max:191',
            // 'buying_price'         => 'required|max:191',
            // 'selling_price'        => 'required|max:191',

            'total'                => 'required',
            'discount_unit'        => 'required',
            'discount'             => 'required',
            'payable'              => 'required',
            'paid'                 => 'required',
            'due'                  => 'sometimes'            
        ));

        $purchase = new Purchase;

        $store = Store::where('code', $request->code)->first();

        $purchase->store_id = $store->id;
        $purchase->code = random_string(8);
        $purchase->total = number_format($request->total, 2, '.', '');
        $purchase->discount_unit = $request->discount_unit;
        $purchase->discount = number_format($request->discount, 2, '.', '');
        $purchase->payable = number_format($request->payable, 2, '.', '');
        $purchase->paid = number_format($request->paid, 2, '.', '');
        $purchase->due = number_format($request->due, 2, '.', '');

        $purchase->save();

        // save the dues and others...
        $vendor = Vendor::findOrFail($request->vendor['id']);
        $vendor->total_purchase = $vendor->total_purchase + 1;
        if($request->due > 0) {
            $vendor->current_due = number_format(($vendor->current_due + $request->due), 2, '.', '');
            $vendor->total_due = number_format(($vendor->total_due + $request->due), 2, '.', '');
        }
        $vendor->save();

        // save the dues HISTORY if due is greater than 0
        if($request->due > 0) {
            $duehistory = new Duehistory;
            $duehistory->vendor_id = $request->vendor['id'];
            $duehistory->transaction_type = 0; // 0 is due, 1 is due_paid
            $duehistory->amount = number_format($request->due, 2, '.', '');
            $duehistory->save();
        }

        // save the stocks...
        $product_array = [];
        foreach ($request->product as $key => $value) {
            if($request->product[$key]['id'] != null) {
                $product_array[$key]['product_id'] = $request->product[$key]['id'];
                // $product_array[$key]['expiry_date'] = $request->expiry_date[$key];
                $product_array[$key]['quantity'] = $request->quantity[$key];
                $product_array[$key]['buying_price'] = $request->buying_price[$key];
                $product_array[$key]['selling_price'] = $request->selling_price[$key];
                
                $stock = new Stock;
                $stock->product_id = $product_array[$key]['product_id'];
                $stock->vendor_id = $request->vendor['id'];
                $stock->purchase_id = $purchase->id;
                // $stock->expiry_date = $request->expiry_date;
                $stock->quantity = $product_array[$key]['quantity'];
                $stock->current_quantity = $product_array[$key]['quantity'];
                $stock->buying_price = number_format($product_array[$key]['buying_price'], 2, '.', '');
                $stock->selling_price = number_format($product_array[$key]['selling_price'], 2, '.', '');
                $stock->save();
            }
        }
        return ['message' => 'সফলভাবে সংরক্ষণ করা হয়েছে!'];
    }

    public function destroy($id)
    {
        return ['message' => 'সফলভাবে ডিলেট করা হয়েছে!'];
    }

    public function searchPurchase($query)
    {
        $purchases = Purchase::where(function($search) use ($query) {
			            $search->where('code', 'LIKE', '%'.$query.'%')
			                   ->orWhere('total', 'LIKE', '%'.$query.'%');
			         })->paginate(5);
        $purchases->load('stocks');
        $purchases->load('stocks')->load('stocks.vendor');

        return response()->json($purchases);
    }
}
