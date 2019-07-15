<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Store;
use App\Customer;
use App\Customerdue;

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
        
        // $customer->load('customerdues');
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

    public function loadSingleCustomerDueHistories($id, $code)
    {
        $customerdues = Customerdue::where('customer_id', $id)
                                   ->orderBy('id', 'desc')
                                   ->paginate(5);

        return response()->json($customerdues);
    }

    public function payDue(Request $request, $id)
    {
        $this->validate($request,array(
            'name'                   => 'required|max:191',
            'current_due'            => 'required',
            'amount_paying'          => 'required',
            'remark'                 => 'sometimes' // remarks history te jaabe
        ));

        $customer = Customer::findOrFail($id);
        if(($customer->current_due - $request->amount_paying) < 0) {
            $customer->current_due = 0.00;
        } else {
            $customer->current_due = number_format(($customer->current_due - $request->amount_paying), 2, '.', '');
        }
        $customer->total_due_paid = number_format(($customer->total_due_paid + $request->amount_paying), 2, '.', '');
        $customer->save(); 

        // save the dues HISTORY if due is greater than 0
        $customerdue = new Customerdue;
        $customerdue->customer_id = $id;
        $customerdue->transaction_type = 1; // 0 is due, 1 is due_paid
        $customerdue->amount = $request->amount_paying;
        $customerdue->remark = $request->remark;
        $customerdue->save();

        return ['message' => 'সফলভাবে সংরক্ষণ করা হয়েছে!'];
    }
}
