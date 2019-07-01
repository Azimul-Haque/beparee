<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Store;
use App\Productcategory;
use App\Product;
use App\Stock;
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
        $products->load('stocks')->load('stocks.vendor');

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
            'name'                 => 'required|max:191',
            'brand'                => 'sometimes|max:191',
            'unit'                 => 'required|max:191',
            'sku'                  => 'sometimes|max:191',
            'stock_alert'          => 'sometimes|max:191',

            'vendor'               => 'sometimes',
            'expire_date'          => 'sometimes|max:191',
            'quantity'             => 'sometimes|max:191',
            'buying_price'         => 'sometimes|max:191',
            'selling_price'        => 'sometimes|max:191',
        ));

        $product = new Product;

        $store = Store::where('code', $request->code)->first();
        
        $product->store_id = $store->id;        
        $product->name = $request->name;
        $product->brand = $request->brand;
        $product->unit = $request->unit;
        $product->sku = $request->sku;
        $product->stock_alert = $request->stock_alert;


        
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
        $product->save();

        // save the stock
        $stock = new Stock;
        $stock->product_id = $product->id;
        $stock->expire_date = $request->expire_date;
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
            'name'                 => 'required|max:191',
            'brand'                => 'sometimes|max:191',
            'unit'                 => 'required|max:191',
            'sku'                  => 'sometimes|max:191',
            'stock_alert'          => 'sometimes|max:191',
        ));

        $product = Product::findOrFail($id);
        $product->name = $request->name;
        $product->brand = $request->brand;
        $product->unit = $request->unit;
        $product->sku = $request->sku;
        $product->stock_alert = $request->stock_alert;
        
        // jehetu data alada table e store korar bepar tai ei duita niche
        $checkcategory = Productcategory::where('name', $request->productcategory['name'])->first();
        if($checkcategory) {
            $product->productcategory_id = $request->productcategory['id'];
        } else {
            $newcategory = new Productcategory;
            $newcategory->store_id = $product->store_id;
            $newcategory->name = $request->productcategory['name'];
            $newcategory->save();

            $product->productcategory_id = $newcategory->id;
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
        $product = Product::findOrFail($id);
        $product->stocks()->delete();
        $product->delete();
        return ['message' => 'সফলভাবে ডিলেট করা হয়েছে!'];
    }

    public function searchProduct($query)
    {
        $products = Product::where(function($search) use ($query) {
            $search->where('name', 'LIKE', '%'.$query.'%')
                   ->orWhere('brand', 'LIKE', '%'.$query.'%');
         })->paginate(5);
        
        $products->load('productcategory');
        $products->load('stocks')->load('stocks.vendor');

        return $products;
    }

    public function loadSingleProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->load('productcategory');
        $product->load('stocks')->load('stocks.vendor');

        return response()->json($product);
    }
}
