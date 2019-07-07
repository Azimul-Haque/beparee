<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Store;
use App\Expense;
use App\Expensecategory;
use App\Staff;

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
                           ->paginate(5);

        $expenses->load('expensecategory');
        $expenses->load('staff');

        return response()->json($expenses);
    }

    public function loadExpenseCategories($code)
    {
        $store = Store::where('code', $code)->first();
        $expensecategories = Expensecategory::select('id', 'name')
                                            ->where('store_id', $store->id)
                                            ->orWhere('type', 0) // 0 for common categories
                                            ->get();

        return response()->json($expensecategories);
    }

    public function loadExpenseStaff($code)
    {
        $store = Store::where('code', $code)->first();
        $staff = Staff::select('id', 'name')
                      ->where('store_id', $store->id)
                      ->get();

        return response()->json($staff);
    }

    public function store(Request $request)
    {
        $this->validate($request,array(
            'expensecategory'        => 'required',
            'staff'                  => 'required_if:expensecategory.id,==,1',
            'amount'                 => 'required',
            'remark'                 => 'sometimes',
            'code'                   => 'required'
        ));

        $expense = new Expense;

        $store = Store::where('code', $request->code)->first();

        $expense->store_id = $store->id;
        $expense->amount = number_format($request->amount, 2, '.', '');
        $expense->remark = $request->remark;

        // jehetu data alada table e store korar bepar tai ei duita niche
        $store_id_check = $store->id; // for the where function
        $checkcategory = Expensecategory::where('name', $request->expensecategory['name'])
                                        ->where(function ($query) use ($store_id_check) {
                                            $query->where('store_id', '=', $store_id_check)
                                                  ->orWhere('type', '=', 0);
                                        })
                                        ->first();
                                        
        if($checkcategory) {
            $expense->expensecategory_id = $checkcategory->id;
        } else {
            $newcategory = new Expensecategory;
            $newcategory->store_id = $store->id;
            $newcategory->name = $request->expensecategory['name'];
            $newcategory->type = 1; // 1 for specific store categories
            $newcategory->save();

            $expense->expensecategory_id = $newcategory->id;
        }

        if($checkcategory) {
            if($checkcategory->id == 1) {
                $expense->staff_id = $request->staff['id'];
            }
        }

        $expense->save();

        return ['message' => 'সফলভাবে সংরক্ষণ করা হয়েছে!'];
    }

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