<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Store;
use App\Upazilla;
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

    public function loadStoresForDashboard($id)
    {
        $stores = Store::whereHas('users', function($q) use($id) {
                        $q->where('user_id', $id);
                    })->get();
        // dd($stores);
        return response()->json($stores);
    }

    public function loadDistricts()
    {
        $districts = Upazilla::orderBy('id', 'asc')->groupBy('district_bangla')->get()->pluck('district_bangla');

        return response()->json($districts);
    }

    public function loadUpazillas($district)
    {
        $upazillas = Upazilla::where('district_bangla', $district)->get()->pluck('upazilla_bangla');

        return response()->json($upazillas);
    }

    public function store(Request $request)
    {
        $this->validate($request,array(
            'name'                   => 'required|max:191',
            'established'            => 'required',
            'address'                => 'required',
            'upazilla'               => 'required',
            'district'               => 'required',
            'activation_status'      => 'required',
            'payment_status'         => 'required',
            'monogram'               => 'sometimes',
            'slogan'                 => 'sometimes',
            'users'                 => 'required'
        ));

        $store = new Store;
        $store->name = $request->name;
        $store->established = $request->established;
        $store->address = $request->address;
        $store->upazilla = $request->upazilla;
        $store->district = $request->district;
        $store->activation_status = $request->activation_status; // 0 means প্রক্রিয়াধীন, 1 means অনুমোদিত
        $store->payment_status = $request->payment_status; // 0 means অপরিশোধিত, 1 means পরিশোধিত

        $store->token = generate_token(100);
        $store->code = random_string(10);

        $store->payment_method = 0;  // 0 means manual, 1 means automatic

        if ($request->monogram) {
            // $filename = time(). '.' . explode('/', explode(':', substr($request->monogram, 0, strpos($request->monogram, ':')))[1])[0];
            $filename = $store->code . '_' . time(). '.' . explode(';', explode('/', $request->monogram)[1])[0];
            $location   = public_path('/images/stores/'. $filename);
            Image::make($request->monogram)->resize(200, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
            $store->monogram = $filename;
        }
        $store->slogan = $request->slogan;

        $store->save();

        foreach ($request->users as $user) {
            DB::table('store_user')->insert([
                'store_id' => $store->id,
                'user_id' => $user['id'],
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
            'upazilla'               => 'required',
            'district'               => 'required',
            'activation_status'      => 'required',
            'payment_status'         => 'required',
            'monogram'               => 'sometimes',
            'slogan'                 => 'sometimes',
            'users'                 => 'required'
        ));

        $store = Store::findOrFail($id);
        $store->name = $request->name;
        $store->established = $request->established;
        $store->address = $request->address;
        $store->upazilla = $request->upazilla;
        $store->district = $request->district;
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
        $store->slogan = $request->slogan;

        $store->save();
        
        DB::table('store_user')->where('store_id', $id)->delete();
        foreach ($request->users as $user) {
            DB::table('store_user')->insert([
                'store_id' => $store->id,
                'user_id' => $user['id'],
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
        return 'it works, deleter kaaj baki ache';
    }

    public function searchStore($query)
    {
        $stores = Store::where(function($search) use ($query) {
            $search->where('name', 'LIKE', '%'.$query.'%')
                   ->orWhere('code', 'LIKE', '%'.$query.'%')
                   ->orWhere('address', 'LIKE', '%'.$query.'%')
                   ->orWhere('upazilla', 'LIKE', '%'.$query.'%')
                   ->orWhere('district', 'LIKE', '%'.$query.'%');
         })->paginate(5);
        
        $stores->load('users');
        return $stores;
    }

    public function getOwners()
    {
        $users = User::select('id','name')
                      ->whereHas('roles', function ($query) {
                        $query->where('name', '=', 'shopowner');
                        $query->orWhere('name', '=', 'superadmin');
                      })->get();
        return $users;
    }

    public function loadStore($code)
    {
        $store = Store::where('code', $code)->first();
        $store->load('users');

        return $store;
    }

    public function updateByUser(Request $request, $id)
    {
        $this->validate($request,array(
            'name'                   => 'required|max:191',
            'established'            => 'required',
            'address'                => 'required',
            'monogram'               => 'sometimes',
            'slogan'                 => 'sometimes'
        ));

        $store = Store::findOrFail($id);
        $store->name = $request->name;
        $store->established = $request->established;
        $store->address = $request->address;

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
        $store->slogan = $request->slogan;
        
        $store->save();
        
        return ['message' => 'সফলভাবে হালনাগাদ করা হয়েছে!'];
    }

    public function getStoreID($code)
    {
        $store = Store::where('code', $code)->first();
        return $store->id;
    }
}
