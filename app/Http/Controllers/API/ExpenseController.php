<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Store;
use App\Expense;
use App\Expensecategory;

use DB;

class ExpenseController extends Controller
{

    public function loadExpenses($code)
    {
        $store = Store::where('code', $code)->first();

        $expenses = Expense::where('store_id', $store->id)
                      ->select('expensecategory_id', DB::raw('SUM(amount) as totalamount'), DB::raw('COUNT(*) as count'))
                      ->groupBy('expensecategory_id')
                      ->paginate(10);
        $expenses->load('expensecategory');

        return response()->json($expenses);
    }

    public function loadExpenseHistory($code)
    {
        $store = Store::where('code', $code)->first();

        $expenses = Expense::where('store_id', $store->id)
                           ->orderBy('id', 'desc')
                           ->paginate(10);

        $expenses->load('expensecategory');
        $expenses->load('staff');

        return response()->json($expenses);
    }

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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
}
