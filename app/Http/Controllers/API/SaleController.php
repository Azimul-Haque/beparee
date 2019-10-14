<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Store;
use App\Product;
use App\Stock;
use App\Customer;
use App\Customerdue;
use App\Sale;
use App\Saleitem;

use DB;

class SaleController extends Controller
{
    
    public function __construct()
    {        
        // $this->middleware('auth:api'); 
    }

    public function loadSales($code)
    {
        $store = Store::where('code', $code)->first();
        $sales = Sale::where('store_id', $store->id)->orderBy('id', 'desc')->paginate(5);
        $sales->load('saleitems');
        $sales->load('saleitems')->load('saleitems.product');
        $sales->load('customer');

        return response()->json($sales);
    }
    
    public function loadProducts($code)
    {
        $store = Store::where('code', $code)->first();
        $products = Product::select('id', 'name', 'unit')->where('store_id', $store->id)->get();
        $products->load('stocks');

        return response()->json($products);
    }

    public function loadCustomers($code)
    {
        $store = Store::where('code', $code)->first();

        $customers = Customer::select('id', DB::raw(DB::raw("CONCAT(name, ' (', mobile, ')') AS name")))
                             ->where('store_id', $store->id)
                             ->get();

        return response()->json($customers);
    }


    public function store(Request $request)
    {
        $this->validate($request,array(
            'code'                 => 'required',
            'customer'             => 'required',

            'total_cost'          => 'required',
            'total_price'          => 'required',
            'discount_unit'        => 'required',
            'discount'             => 'required',
            'payment_method'       => 'required',
            'payable'              => 'required',
            'paid'                 => 'required',
            'due'                  => 'sometimes'            
        ));

        $sale = new Sale;

        $store = Store::where('code', $request->code)->first();

        $sale->store_id = $store->id;

        $sale->code = 'S'.date('dmyhis').$store->id;
        $sale->total_cost = number_format($request->total_cost, 2, '.', '');
        $sale->total_price = number_format($request->total_price, 2, '.', '');
        $sale->discount_unit = $request->discount_unit;
        $sale->discount = number_format($request->discount, 2, '.', '');
        $sale->payment_method = $request->payment_method;
        $sale->payable = number_format($request->payable, 2, '.', '');
        $sale->paid = number_format($request->paid, 2, '.', '');
        $sale->due = number_format($request->due, 2, '.', '');

        // save the customer, dues and others...
        if(isset($request->customer['id'])) {
            $checkcustomer = Customer::findOrFail($request->customer['id']);
            if($checkcustomer) {
                $sale->customer_id = $checkcustomer->id;
                $checkcustomer->total_purchase = $checkcustomer->total_purchase + 1;
                if($request->due > 0) {
                    $checkcustomer->current_due = number_format(($checkcustomer->current_due + $request->due), 2, '.', '');
                    $checkcustomer->total_due = number_format(($checkcustomer->total_due + $request->due), 2, '.', '');
                }
                $checkcustomer->save();
            } else {
                $newcustomer = new Customer;
                $newcustomer->store_id = $store->id;
                if(isset($request->customer['name'])) {
                    $newcustomer->name = $request->customer['name'];
                } else {
                    $newcustomer->name = $request->customer;
                }                
                $newcustomer->total_purchase = $newcustomer->total_purchase + 1;
                if($request->due > 0) {
                    $newcustomer->current_due = number_format(($newcustomer->current_due + $request->due), 2, '.', '');
                    $newcustomer->total_due = number_format(($newcustomer->total_due + $request->due), 2, '.', '');
                }
                $newcustomer->save();
                $sale->customer_id = $newcustomer->id;
            }
        } else {
            $newcustomer = new Customer;
            $newcustomer->store_id = $store->id;
            if(isset($request->customer['name'])) {
                $newcustomer->name = $request->customer['name'];
            } else {
                $newcustomer->name = $request->customer;
            }
            $newcustomer->total_purchase = $newcustomer->total_purchase + 1;
            if($request->due > 0) {
                $newcustomer->current_due = number_format(($newcustomer->current_due + $request->due), 2, '.', '');
                $newcustomer->total_due = number_format(($newcustomer->total_due + $request->due), 2, '.', '');
            }
            $newcustomer->save();
            $sale->customer_id = $newcustomer->id;
        }

        $sale->save();
        

        // save the customer due HISTORY if due is greater than 0
        if($request->due > 0) {
            $customerdues = new Customerdue;
            $customerdues->customer_id = $sale->customer_id;
            $customerdues->transaction_type = 0; // 0 is due, 1 is due_paid
            $customerdues->amount = number_format($request->due, 2, '.', '');
            $customerdues->save();
        }

        // save the saleitems...
        $product_array = [];
        foreach ($request->product as $key => $value) {
            if($request->product[$key]['id'] != null) {
                $product_array[$key]['product_id'] = $request->product[$key]['id'];
                // $product_array[$key]['expiry_date'] = $request->expiry_date[$key];
                $product_array[$key]['quantity'] = $request->quantity[$key];
                $product_array[$key]['buying_price'] = $request->buying_price[$key];
                $product_array[$key]['unit_price'] = $request->unit_price[$key];
                
                $saleitem = new Saleitem;
                $saleitem->product_id = $product_array[$key]['product_id'];
                $saleitem->sale_id = $sale->id;
                // $saleitem->expiry_date = $request->expiry_date;
                $saleitem->quantity = $product_array[$key]['quantity'];
                $saleitem->buying_price = number_format($product_array[$key]['buying_price'], 2, '.', '');
                $saleitem->unit_price = number_format($product_array[$key]['unit_price'], 2, '.', '');
                $saleitem->save();

                // reduce from the stocks
                $stock_calc_quantity = $product_array[$key]['quantity'];
                $stocks = Stock::where('product_id', $product_array[$key]['product_id'])
                               ->where('current_quantity', '>', 0)
                               ->orderBy('id', 'asc')
                               ->get();

                foreach ($stocks as $stock) {
                    if($stock->current_quantity > $stock_calc_quantity) {
                        $stock->current_quantity = $stock->current_quantity - $stock_calc_quantity;
                        $stock->save();
                        break;
                    } else {
                        $stock_calc_quantity = $stock_calc_quantity - $stock->current_quantity;
                        $stock->current_quantity = 0;
                        $stock->save();
                    }
                }
            }
        }
        return ['message' => 'সফলভাবে সংরক্ষণ করা হয়েছে!'];
    }

    public function searchPurchase($query)
    {
        $purchases = Purchase::where(function($search) use ($query) {
                        $search->where('code', 'LIKE', '%'.$query.'%')
                               ->orWhere('total', 'LIKE', '%'.$query.'%');
                     })->paginate(5);
        $purchases->load('stocks');
        $purchases->load('stocks')->load('stocks.product', 'stocks.vendor');

        return response()->json($purchases);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
