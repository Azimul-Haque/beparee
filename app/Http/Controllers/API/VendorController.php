<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Store;
use App\Vendor;
use App\Duehistory;

class VendorController extends Controller
{
    public function loadVendors($code)
    {
        $store = Store::where('code', $code)->first();

        $vendors = Vendor::where('store_id', $store->id)->paginate(5);

        return response()->json($vendors);
    }

    public function store(Request $request)
    {
        $this->validate($request,array(
            'code'                   => 'required',
            'name'                   => 'required|max:191',
            'address'                => 'required',
            'mobile'                 => 'required'
        ));

        $vendor = new Vendor;

        $store = Store::where('code', $request->code)->first();

        $vendor->store_id = $store->id;
        $vendor->name = $request->name;
        $vendor->address = $request->address;
        $vendor->mobile = $request->mobile;
        $vendor->save();

        return ['message' => 'সফলভাবে সংরক্ষণ করা হয়েছে!'];
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,array(
            'name'                   => 'required|max:191',
            'address'                => 'required',
            'mobile'                 => 'required'
        ));

        $vendor = Vendor::findOrFail($id);;
        $vendor->name = $request->name;
        $vendor->address = $request->address;
        $vendor->mobile = $request->mobile;
        $vendor->save();

        return ['message' => 'সফলভাবে সংরক্ষণ করা হয়েছে!'];
    }

    public function destroy($id)
    {
        // $vendor = Vendor::findOrFail($id);
        // associated data should be deleted too...
        // $vendor->delete();
        // return ['message' => 'সফলভাবে ডিলেট করা হয়েছে!'];
        return ['message' => 'এই মুহূর্তে ডিলেট বন্ধ আছে!'];
    }


    public function loadDues($code)
    {
        $store = Store::where('code', $code)->first();

        $vendors = Vendor::where('store_id', $store->id)
                         ->where('total_due', '>', 0)
                         ->paginate(5);

        return response()->json($vendors);
    }

    public function payDue(Request $request, $id)
    {
        $this->validate($request,array(
            'name'                   => 'required|max:191',
            'current_due'            => 'required',
            'amount_paying'          => 'required',
            'remark'                 => 'sometimes' // remarks history te jaabe
        ));

        $vendor = Vendor::findOrFail($id);
        if(($vendor->current_due - $request->amount_paying) < 0) {
            $vendor->current_due = 0.00;
        } else {
            $vendor->current_due = number_format(($vendor->current_due - $request->amount_paying), 2, '.', '');
        }
        $vendor->total_due_paid = number_format(($vendor->total_due_paid + $request->amount_paying), 2, '.', '');
        $vendor->save(); 

        // save the dues HISTORY if due is greater than 0
        $duehistory = new Duehistory;
        $duehistory->vendor_id = $id;
        $duehistory->transaction_type = 1; // 0 is due, 1 is due_paid
        $duehistory->amount = $request->amount_paying;
        $duehistory->remark = $request->remark;
        $duehistory->save();

        return ['message' => 'সফলভাবে সংরক্ষণ করা হয়েছে!'];
    }

    public function loadDuehistories($code)
    {
        $store = Store::where('code', $code)->first();

        // $vendors = Vendor::where('store_id', $store->id)->paginate(5);
        // $vendors->load('duehistories');

        $duehistories = Duehistory::whereHas("vendor", function($q) use ($store) {
                       $q->where("store_id", $store->id);
                      })->orderBy('id', 'desc')->paginate(5);

        $duehistories->load('vendor');
        return response()->json($duehistories);
    }

    public function searchVendor($query)
    {
        $vendors = Vendor::where(function($search) use ($query) {
                        $search->where('name', 'LIKE', '%'.$query.'%')
                               ->orWhere('address', 'LIKE', '%'.$query.'%')
                               ->orWhere('mobile', 'LIKE', '%'.$query.'%');
                     })->paginate(5);

        return response()->json($vendors);
    }

    public function loadSingleVendor($id, $code)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->load('duehistories');
        $vendor->load('stocks')->load('stocks.product', 'stocks.purchase');

        $store = Store::where('code', $code)->first();
        if($store) {
           if($store->id != $vendor->store_id) {
               $vendor = null;
           } 
        } else {
            $vendor = null;
        }

        return response()->json($vendor);
    }
}
