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

        return $stores;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        $owners = User::whereHas('roles', function ($query) {
                            $query->where('name', '=', 'shopowner');
                 })->get();
        return $owners;
    }
}
