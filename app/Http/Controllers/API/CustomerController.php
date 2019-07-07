<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Store;
use App\Customer;

class CustomerController extends Controller
{
    public function loadCustomers($code)
    {
        $store = Store::where('code', $code)->first();

        $customers = Customer::where('store_id', $store->id)->paginate(5);

        return response()->json($customers);
    }
    
    public function store(Request $request)
    {
        $this->validate($request,array(
            'code'                   => 'required',
            'name'                   => 'required|max:191',
            'address'                => 'required',
            'mobile'                 => 'required',
            'nid'                    => 'sometimes'
        ));

        $customer = new Customer;

        $store = Store::where('code', $request->code)->first();

        $customer->store_id = $store->id;
        $customer->name = $request->name;
        $customer->address = $request->address;
        $customer->mobile = $request->mobile;
        $customer->nid = $request->nid;
        $customer->save();

        return ['message' => 'সফলভাবে সংরক্ষণ করা হয়েছে!'];
    }

   public function update(Request $request, $id)
    {
        $this->validate($request,array(
            'name'                   => 'required|max:191',
            'address'                => 'required',
            'mobile'                 => 'required',
            'nid'                    => 'sometimes'
        ));

        $customer = Customer::findOrFail($id);;
        $customer->name = $request->name;
        $customer->address = $request->address;
        $customer->mobile = $request->mobile;
        $customer->nid = $request->nid;
        $customer->save();

        return ['message' => 'সফলভাবে সংরক্ষণ করা হয়েছে!'];
    }

    public function destroy($id)
    {
        //
    }

    public function searchCustomer($query)
    {
        $customers = Customer::where(function($search) use ($query) {
                        $search->where('name', 'LIKE', '%'.$query.'%')
                               ->orWhere('address', 'LIKE', '%'.$query.'%')
                               ->orWhere('mobile', 'LIKE', '%'.$query.'%')
                               ->orWhere('nid', 'LIKE', '%'.$query.'%');
                     })->paginate(5);

        return response()->json($customers);
    }

    public function loadSingleCustomer($id, $code)
    {
        $customer = Customer::findOrFail($id);
        // $customer->load('duehistories');
        // $customer->load('stocks')->load('stocks.product', 'stocks.purchase');
        
        $store = Store::where('code', $code)->first();
        if($store) {
           if($store->id != $customer->store_id) {
               $customer = null;
           } 
        } else {
            $customer = null;
        }

        return response()->json($customer);
    }
}
