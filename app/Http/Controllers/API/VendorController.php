<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Store;
use App\Vendor;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

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


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $vendor = Vendor::findOrFail($id);
        // associated data should be deleted too...
        // $vendor->delete();
        // return ['message' => 'সফলভাবে ডিলেট করা হয়েছে!'];
        return ['message' => 'এই মুহূর্তে ডিলেট বন্ধ আছে!'];
    }
}
