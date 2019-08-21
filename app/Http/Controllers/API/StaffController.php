<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Store;
use App\Staff;
use App\Staffattendance;
use App\Expense;

use Image, File, DB;

class StaffController extends Controller
{
    public function index()
    {
        //
    }

    public function loadStaffs($code)
    {
        $store = Store::where('code', $code)->first();
        $staffs = Staff::where('store_id', $store->id)->paginate(5);

        return response()->json($staffs);
    }

    public function loadStaffsForAtt($code)
    {
        $store = Store::where('code', $code)->first();
        $staffs = Staff::where('store_id', $store->id)->get();

        return response()->json($staffs);
    }

    public function loadStaffsAttForCal($code)
    {
        $store = Store::where('code', $code)->first();
        $attendences = Staffattendance::where('store_id', $store->id)->get();

        $staffsforcal = [];
        foreach ($attendences as $attendence) {
            
            $staffsforcal[$attendence->id]['start'] = $attendence->date;
            if($attendence->type == 1) {
                $staffsforcal[$attendence->id]['title'] = '☂ ' . $attendence->staff->name;
                $staffsforcal[$attendence->id]['color'] = '#d3d3d3';
                $staffsforcal[$attendence->id]['textColor'] = '#000000';
            } else {
                $colors = ['#0069D9', '#f66d9b', '#f6993f', '#ffC107', '#38c172', '#4dc0b5', '#6cb2eb'];

                $staffsforcal[$attendence->id]['title'] = '✓ ' . $attendence->staff->name;
                $staffsforcal[$attendence->id]['color'] = $colors[array_rand($colors)];
                $staffsforcal[$attendence->id]['textColor'] = '#fff';
            }
        }

        $staffsforcal = collect($staffsforcal);
        $staffsforcal = $staffsforcal->values()->all();

        return response()->json($staffsforcal);
    }

    public function postStaffAtt(Request $request) 
    {
        $this->validate($request,array(
            'staff'      => 'required',
            'date'       => 'required',
            'type'       => 'required'
        ));

        $attendence = new Staffattendance;
        $attendence->staff_id = $request->staff['id'];
        $attendence->store_id = $request->staff['store_id'];
        $attendence->date = date('Y-m-d', strtotime($request->date));
        $attendence->type = $request->type;

        $attendence->save();

        return ['message' => 'সফলভাবে সংরক্ষণ করা হয়েছে!'];
    }

    public function store(Request $request)
    {
        $this->validate($request,array(
            'name'       => 'required|max:191',
            'mobile'     => 'required|min:11|max:11',
            'address'    => 'required|max:191',
            'salary'     => 'required|max:191',
            'image'      => 'sometimes'
        ));

        $staff = new Staff;

        $store = Store::where('code', $request->code)->first();

        $staff->store_id = $store->id;
        $staff->name = $request->name;
        $staff->mobile = $request->mobile;
        $staff->address = $request->address;
        $staff->salary = $request->salary;

        if ($request->image) {
            // $image = time(). '.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ':')))[1])[0];
            $filename = random_string(5) . time(). '.' . explode(';', explode('/', $request->image)[1])[0];
            $location   = public_path('/images/users/'. $filename);
            // Image::make($request->image)->resize(800, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
            Image::make($request->image)->resize(300, 300)->save($location);
            $staff->image = $filename;
        }

        $staff->save();

        return ['message' => 'সফলভাবে সংরক্ষণ করা হয়েছে!'];
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,array(
            'name'       => 'required|max:191',
            'mobile'     => 'required|min:11|max:11',
            'address'    => 'required|max:191',
            'salary'     => 'required|max:191',
            'image'      => 'sometimes'
        ));

        $staff = Staff::findOrFail($id);
        $staff->name = $request->name;
        $staff->mobile = $request->mobile;
        $staff->address = $request->address;
        $staff->salary = $request->salary;

        if ($request->image != $staff->image) {
            $image_path = public_path('/images/users/'. $staff->image);
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            // $image = time(). '.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ':')))[1])[0];
            $filename = random_string(5) . time(). '.' . explode(';', explode('/', $request->image)[1])[0];
            $location   = public_path('/images/users/'. $filename);
            // Image::make($request->image)->resize(800, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
            Image::make($request->image)->resize(300, 300)->save($location);
            $staff->image = $filename;
        }

        $staff->save();

        return ['message' => 'সফলভাবে সংরক্ষণ করা হয়েছে!'];
    }

    public function destroy($id)
    {
        //
    }

    public function searchStaff($query)
    {
        $staff = Staff::where(function($search) use ($query) {
            $search->where('name', 'LIKE', '%'.$query.'%')
                   ->orWhere('mobile', 'LIKE', '%'.$query.'%')
                   ->orWhere('address', 'LIKE', '%'.$query.'%');
         })->paginate(5);
        
        return $staff;
    }

    public function loadSingleStaff($id, $code)
    {
        $staff = Staff::findOrFail($id);
        // $staff->load('duehistories');
        // $staff->load('stocks')->load('stocks.product', 'stocks.purchase');

        $store = Store::where('code', $code)->first();
        if($store) {
           if($store->id != $staff->store_id) {
               $staff = null;
           } 
        } else {
            $staff = null;
        }

        return response()->json($staff);
    }
    
    public function loadSingleStaffSalaryHistory($id, $code)
    {
        $store = Store::where('code', $code)->first();
        $salaryhistories = Expense::where('expensecategory_id', 1)
                                  ->where('store_id', $store->id)
                                  ->where('staff_id', $id)
                                  ->orderBy('id', 'desc')
                                  ->paginate(6);

        return response()->json($salaryhistories);
    }
    
    public function loadSingleStaffSalaryTotals($id, $code)
    {
        $store = Store::where('code', $code)->first();
        $salarytotals = Expense::where('expensecategory_id', 1)
                           ->where('store_id', $store->id)
                           ->where('staff_id', $id)
                           ->select(DB::raw('SUM(amount) as totalsalary'), DB::raw('COUNT(*) as salarycount'))
                           ->first();

        return response()->json($salarytotals);
    }

    public function storeSingleStaffSalary(Request $request)
    {
        $this->validate($request,array(
            'code'                 => 'required',
            'staff_id'             => 'required',
            'amount'               => 'required',
            'remark'               => 'sometimes'
        ));

        $salary = new Expense;

        $store = Store::where('code', $request->code)->first();

        $salary->store_id = $store->id;
        $salary->expensecategory_id = 1;
        $salary->staff_id = $request->staff_id;
        $salary->amount = number_format($request->amount, 2, '.', '');
        $salary->remark = $request->remark;

        $salary->save();

        return ['message' => 'সফলভাবে সংরক্ষণ করা হয়েছে!'];
    }
}
