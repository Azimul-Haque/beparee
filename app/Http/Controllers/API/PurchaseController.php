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
        $purchases->load('stock');
        $purchases->load('stock')->load('stock.product', 'stock.vendor');

        return response()->json($purchases);
    }

    public function loadProducts($code)
    {
        $store = Store::where('code', $code)->first();
        $products = Product::select('id','name')->where('store_id', $store->id)->get();

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $this->validate($request,array(
            'code'                 => 'required',
            
            'product'              => 'required',
            'vendor'               => 'required|max:191',

            'expiry_date'          => 'sometimes|max:191',
            'quantity'             => 'required|max:191',
            'buying_price'         => 'required|max:191',
            'selling_price'        => 'required|max:191',

            'total'                => 'required|max:191',
            'discount_unit'        => 'required|max:191',
            'discount'             => 'required|max:191',
            'payable'              => 'required|max:191',
            'paid'                 => 'required|max:191',
            'due'                  => 'sometimes|max:191'            
        ));

        $store = Store::where('code', $request->code)->first();

        $stock = new Stock;
        $stock->product_id = $request->product['id'];
        $stock->expiry_date = $request->expiry_date;
        $stock->quantity = $request->quantity;
        $stock->buying_price = number_format($request->buying_price, 2, '.', '');
        $stock->selling_price = number_format($request->selling_price, 2, '.', '');

        $checkvendor = Vendor::where('name', $request->vendor['name'])->first();
        if($checkvendor) {
            $stock->vendor_id = $request->vendor['id'];
        } else {
            $newvendor = new Vendor;
            $newvendor->store_id = $store->id;
            $newvendor->name = $request->vendor['name'];
            $newvendor->save();
            $stock->vendor_id = $newvendor->id;
        }
        
        $stock->save();

        // save the purchase...
        $purchase = new Purchase;

        $purchase->store_id = $store->id;
        $purchase->stock_id = $stock->id; // just saved stock id
        $purchase->code = random_string(8);
        $purchase->total = $request->total;
        $purchase->discount_unit = $request->discount_unit;
        $purchase->discount = $request->discount;
        $purchase->payable = $request->payable;
        $purchase->paid = $request->paid;
        $purchase->due = $request->due;

        $purchase->save();

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
        $purchases->load('stock');
        $purchases->load('stock')->load('stock.product', 'stock.vendor');

        return response()->json($purchases);
    }
}
