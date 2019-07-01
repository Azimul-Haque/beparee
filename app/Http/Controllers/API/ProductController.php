<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Store;
use App\Productcategory;
use App\Product;
use App\Vendor;

class ProductController extends Controller
{
    public function __construct()
    {        
        // $this->middleware('auth:api'); 
    }

    public function index()
    {
        //
    }

    public function loadVendors($code)
    {
        $store = Store::where('code', $code)->first();

        $vendors = Vendor::select('id','name')->where('store_id', $store->id)->get();

        return response()->json($vendors);
    }

    public function loadProducts($code)
    {
        $store = Store::where('code', $code)->first();
        $products = Product::where('store_id', $store->id)->paginate(5);

        $products->load('productcategory');
        $products->load('vendor');

        return response()->json($products);
    }

    public function loadCategories($code)
    {
        $store = Store::where('code', $code)->first();
        $categories = Productcategory::where('store_id', $store->id)->get();

        return response()->json($categories);
    }

    public function storeCategory(Request $request)
    {
        $this->validate($request,array(
            'code'               => 'required',
            'name'               => 'required|max:191'
        ));

        $category = new Productcategory;

        $store = Store::where('code', $request->code)->first();
        
        $category->store_id = $store->id;
        $category->name = $request->name;
        
        $category->save();

        return ['message' => 'সফলভাবে সংরক্ষণ করা হয়েছে!'];
    }

    public function updateCategory(Request $request, $id)
    {
        $this->validate($request,array(
            'name'                   => 'required|max:191'
        ));

        $category = Productcategory::findOrFail($id);
        $category->name = $request->name;
        $category->save();

        return ['message' => 'সফলভাবে হালনাগাদ করা হয়েছে!'];
    }

    public function store(Request $request)
    {
        $this->validate($request,array(
            'code'                 => 'required',
            'productcategory'      => 'required',
            'vendor'               => 'required',
            'name'                 => 'required|max:191',
            'brand'                => 'sometimes|max:191',
            'unit'                 => 'required|max:191',
            'sku'                  => 'sometimes|max:191',
            'expire_date'          => 'sometimes|max:191',
            'stock_alert'          => 'sometimes|max:191',
            'quantity'             => 'required|max:191',
            'buying_price'         => 'required|max:191',
            'selling_price'        => 'required|max:191',
        ));

        $product = new Product;

        $store = Store::where('code', $request->code)->first();
        
        $product->store_id = $store->id;        
        $product->name = $request->name;
        $product->brand = $request->brand;
        $product->unit = $request->unit;
        $product->sku = $request->sku;
        $product->expire_date = $request->expire_date;
        $product->stock_alert = $request->stock_alert;
        $product->quantity = $request->quantity;
        $product->buying_price = $request->buying_price;
        $product->selling_price = $request->selling_price;
        
        // jehetu data alada table e store korar bepar tai ei duita niche
        $checkcategory = Productcategory::where('name', $request->productcategory['name'])->first();
        if($checkcategory) {
            $product->productcategory_id = $request->productcategory['id'];
        } else {
            $newcategory = new Productcategory;
            $newcategory->store_id = $store->id;
            $newcategory->name = $request->productcategory['name'];
            $newcategory->save();

            $product->productcategory_id = $newcategory->id;
        }

        $checkvendor = Vendor::where('name', $request->vendor['name'])->first();
        if($checkvendor) {
            $product->vendor_id = $request->vendor['id'];
        } else {
            $newvendor = new Vendor;
            $newvendor->store_id = $store->id;
            $newvendor->name = $request->vendor['name'];
            $newvendor->save();
            $product->vendor_id = $newvendor->id;
        }

        $product->save();

        return ['message' => 'সফলভাবে সংরক্ষণ করা হয়েছে!'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,array(
            'productcategory'      => 'required',
            'vendor'               => 'required',
            'name'                 => 'required|max:191',
            'brand'                => 'sometimes|max:191',
            'unit'                 => 'required|max:191',
            'sku'                  => 'sometimes|max:191',
            'expire_date'          => 'sometimes|max:191',
            'stock_alert'          => 'sometimes|max:191',
            'quantity'             => 'required|max:191',
            'buying_price'         => 'required|max:191',
            'selling_price'        => 'required|max:191',
        ));

        $product = Product::findOrFail($id);
       
        $product->name = $request->name;
        $product->brand = $request->brand;
        $product->unit = $request->unit;
        $product->sku = $request->sku;
        $product->expire_date = $request->expire_date;
        $product->stock_alert = $request->stock_alert;
        $product->quantity = $request->quantity;
        $product->buying_price = $request->buying_price;
        $product->selling_price = $request->selling_price;
        
        // jehetu data alada table e store korar bepar tai ei duita niche
        $checkcategory = Productcategory::where('name', $request->productcategory['name'])->first();
        if($checkcategory) {
            $product->productcategory_id = $request->productcategory['id'];
        } else {
            $newcategory = new Productcategory;
            $newcategory->store_id = $store->id;
            $newcategory->name = $request->productcategory['name'];
            $newcategory->save();

            $product->productcategory_id = $newcategory->id;
        }

        $checkvendor = Vendor::where('name', $request->vendor['name'])->first();
        if($checkvendor) {
            $product->vendor_id = $request->vendor['id'];
        } else {
            $newvendor = new Vendor;
            $newvendor->store_id = $store->id;
            $newvendor->name = $request->vendor['name'];
            $newvendor->save();
            $product->vendor_id = $newvendor->id;
        }
        
        $product->save();

        return ['message' => 'সফলভাবে সংরক্ষণ করা হয়েছে!'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
