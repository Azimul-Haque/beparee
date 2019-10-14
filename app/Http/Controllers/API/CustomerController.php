<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Store;
use App\Customer;
use App\Customerdue;
use App\Sale;

class CustomerController extends Controller
{
    public function loadCustomers($code)
    {
        $store = Store::where('code', $code)->first();

        $customers = Customer::where('store_id', $store->id)->paginate(10);

        return response()->json($customers);
    }
    
    public function store(Request $request)
    {
        $this->validate($request,array(
            'code'                   => 'required',
            'name'                   => 'required|max:191',
            'address'                => 'required',
            'mobile'                 => 'required',
            'nid'                    => 'sometimes',
            'ldue'                   => 'sometimes'
        ));

        $customer = new Customer;

        $store = Store::where('code', $request->code)->first();

        $customer->store_id = $store->id;
        $customer->name = $request->name;
        $customer->address = $request->address;
        $customer->mobile = $request->mobile;
        $customer->nid = $request->nid;
        if($request->ldue != '' && $request->ldue > 0) {
            $customer->current_due = $request->ldue;
            $customer->total_due = $request->ldue;
        }
        $customer->save();

        if($request->ldue != '' && $request->ldue > 0) {
            $customerdue = new Customerdue;
            $customerdue->customer_id = $customer->id;
            $customerdue->transaction_type = 0; // 0 is due, 1 is due_paid
            $customerdue->amount = $request->ldue;
            $customerdue->remark = 'পূর্বের বকেয়া';
            $customerdue->save();
        }

        return ['message' => 'সফলভাবে সংরক্ষণ করা হয়েছে!'];
    }

   public function update(Request $request, $id)
    {
        $this->validate($request,array(
            'name'                   => 'required|max:191',
            'address'                => 'required',
            'mobile'                 => 'required',
            'nid'                    => 'sometimes',
            'ldue'                   => 'sometimes'
        ));

        $customer = Customer::findOrFail($id);
        $customer->name = $request->name;
        $customer->address = $request->address;
        $customer->mobile = $request->mobile;
        $customer->nid = $request->nid;
        

        $customerdue = Customerdue::where('customer_id', $customer->id)->where('remark', 'পূর্বের বকেয়া')->first();
        if($customerdue) {
            if($customerdue->amount != $request->ldue) {
                // aage update, then change
                $customer->current_due = $customer->current_due - $customerdue->amount + $request->ldue;
                $customer->total_due = $customer->total_due - $customerdue->amount + $request->ldue;

                $customerdue->amount = $request->ldue;
                $customerdue->save();
            }
        } else {
            $customerdue = new Customerdue;
            $customerdue->customer_id = $customer->id;
            $customerdue->transaction_type = 0; // 0 is due, 1 is due_paid
            $customerdue->amount = $request->ldue;
            $customerdue->remark = 'পূর্বের বকেয়া';
            $customerdue->save();

            $customer->current_due = $customer->current_due + $request->ldue;
            $customer->total_due = $customer->total_due + $request->ldue;
        }

        // customer current_due and total_due update/ new er jonno eta niche...
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

    public function loadSingleCustomerPurchases($id, $code)
    {
        $store = Store::where('code', $code)->first();

        $customerpurchases = Sale::where('customer_id', $id)
                                 ->where('store_id', $store->id)
                                 ->orderBy('id', 'desc')
                                 ->paginate(5);

        // $customerpurchases->load('saleitems');
        // $customerpurchases->load('saleitems')->load('saleitems.product');

        return response()->json($customerpurchases);
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

    // CUSTOMER DUES PAGE METHODS
    // CUSTOMER DUES PAGE METHODS
    // CUSTOMER DUES PAGE METHODS
    // CUSTOMER DUES PAGE METHODS
    // CUSTOMER DUES PAGE METHODS

    public function loadDues($code)
    {
        $store = Store::where('code', $code)->first();

        $customers = Customer::where('store_id', $store->id)
                             ->where('total_due', '>', 0)
                             ->orderBy('updated_at', 'desc')
                             ->paginate(5);

        return response()->json($customers);
    }
    
    public function loadCustomersDues($code)
    {
        $store = Store::where('code', $code)->first();

        $customerdues = Customerdue::whereHas("customer", function($q) use ($store) {
                            $q->where("store_id", $store->id);
                        })->orderBy('id', 'desc')->paginate(5);

        $customerdues->load('customer');
        return response()->json($customerdues);
    }
}
