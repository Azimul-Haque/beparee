<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Store;
use Image, File, DB;

class StoreController extends Controller
{
    public function __construct()
    {        
        // $this->middleware('auth:api'); 
    }

    public function index()
    {
        $stores = Store::latest()->paginate(5);
        $stores->load('users');

        return response()->json($stores);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,array(
            'name'                   => 'required|max:191',
            'established'            => 'required',
            'address'                => 'required',
            'activation_status'      => 'required',
            'payment_status'         => 'required',
            'monogram'               => 'sometimes',
            'owners'                  => 'required'
        ));

        $store = new Store;
        $store->name = $request->name;
        $store->established = $request->established;
        $store->address = $request->address;
        $store->activation_status = $request->activation_status;
        $store->payment_status = $request->payment_status;

        $store->token = generate_token(100);
        $store->code = random_string(10);

        $store->payment_method = 0;  // 0 means manual, 1 means automatic

        if ($request->monogram) {
            // $image = time(). '.' . explode('/', explode(':', substr($request->monogram, 0, strpos($request->monogram, ':')))[1])[0];
            $filename = $store->code . '_' . time(). '.' . explode(';', explode('/', $request->monogram)[1])[0];
            $location   = public_path('/images/stores/'. $filename);
            // Image::make($request->monogram)->resize(800, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
            Image::make($request->monogram)->resize(200, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
            $store->monogram = $filename;
        }

        $store->save();

        foreach ($request->owners as $owner) {
            DB::table('store_user')->insert([
                'store_id' => $store->id,
                'user_id' => $owner['id'],
            ]);
        }

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
            'established'            => 'required',
            'address'                => 'required',
            'activation_status'      => 'required',
            'payment_status'         => 'required',
            'monogram'               => 'sometimes',
            'owners'                  => 'required'
        ));

        $store = Store::findOrFail($id);
        $store->name = $request->name;
        $store->established = $request->established;
        $store->address = $request->address;
        $store->activation_status = $request->activation_status;
        $store->payment_status = $request->payment_status;

        if ($request->monogram != $store->monogram) {
            $image_path = public_path('/images/stores/'. $store->monogram);
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            $filename = $store->code . '_' . time() . '.' . explode(';', explode('/', $request->monogram)[1])[0];
            $location   = public_path('/images/stores/'. $filename);
            Image::make($request->monogram)->resize(200, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
            $store->monogram = $filename;
        }

        $store->save();
        
        DB::table('store_user')->where('store_id', $id)->delete();
        foreach ($request->owners as $owner) {
            DB::table('store_user')->insert([
                'store_id' => $store->id,
                'user_id' => $owner['id'],
            ]);
        }

        return ['message' => 'সফলভাবে হালনাগাদ করা হয়েছে!'];
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

    public function searchStore($query)
    {
        $stores = Store::where(function($search) use ($query) {
            $search->where('name', 'LIKE', '%'.$query.'%')
                   ->orWhere('code', 'LIKE', '%'.$query.'%')
                   ->orWhere('address', 'LIKE', '%'.$query.'%');
         })->paginate(5);
        

        return $stores;
    }

    public function getOwners()
    {
        $owners = User::select('id','name')
                      ->whereHas('roles', function ($query) {
                        $query->where('name', '=', 'shopowner');
                      })->get();
        return $owners;
    }
}
