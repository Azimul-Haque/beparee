<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Store;
use App\Productcategory;
use App\Vendor;
use App\Product;
use App\Stock;
use App\Purchase;

class PurchaseController extends Controller
{
    public function loadPurchases($code)
    {
        $store = Store::where('code', $code)->first();
        $purchases = Purchase::where('store_id', $store->id)->paginate(5);
        $purchases->load('product');

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
            'due'                  => 'sometimes|max:191',

            
        ));

        

        return ['message' => 'সফলভাবে সংরক্ষণ করা হয়েছে!'];
    }
}
