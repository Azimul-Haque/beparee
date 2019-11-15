<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Role;
use App\Permission;
use App\Store;
use Image, File, DB;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {        
        // $this->middleware('auth:api'); 
    }

    public function index()
    {
        $users = User::latest()->paginate(5);
        $users->load('roles');

        return response()->json($users);
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
            'name'       => 'required|max:191',
            'email'      => 'sometimes|unique:users,email', // email type
            'mobile'     => 'required|min:11|max:11|unique:users,mobile',
            'address'    => 'required|max:191',
            'roles'      => 'required',
            'image'      => 'sometimes',
            'password'   => 'required|min:6'
        ));

        $user = new User;
        $user->name = $request->name;
        if($request->email != '') {
            $user->email = htmlspecialchars(preg_replace("/\s+/", " ", $request->email));
        } else {
            $user->email = htmlspecialchars(preg_replace("/\s+/", " ", $request->mobile)) . '@dokankhata.com';
        }
        $user->mobile = $request->mobile;
        $user->address = $request->address;

        if ($request->image) {
            // $image = time(). '.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ':')))[1])[0];
            $filename = random_string(5) . time(). '.' . explode(';', explode('/', $request->image)[1])[0];
            $location   = public_path('/images/users/'. $filename);
            // Image::make($request->image)->resize(800, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
            Image::make($request->image)->resize(300, 300)->save($location);
            $user->image = $filename;
        }

        $user->password = Hash::make($request->password);
        $user->save();

        foreach ($request->input('roles') as $key => $value) {
            $user->attachRole($value);
        }
        
        // return User::create([
        //     'name'        => $request->name,
        //     'email'       => $request->email,
        //     'image'       => $filename,
        //     'password'    => Hash::make($request->password)
        // ]);
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
        $user = User::findOrFail($id);
        $user->load('stores');

        return response()->json($user);
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
        $user = User::findOrFail($id);

        $this->validate($request,array(
            'name'       => 'required|max:191',
            'email'      => 'required|email|unique:users,email,'. $user->id,
            'mobile'     => 'required|min:11|max:11|unique:users,mobile,'. $user->id,
            'address'    => 'required|max:191',
            'roles'      => 'sometimes',
            'image'      => 'sometimes',
            'password'   => 'sometimes|min:6'
        ));

        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->address = $request->address;

        if ($request->image != $user->image) {
            $image_path = public_path('/images/users/'. $user->image);
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            // $image = time(). '.' . explode('/', explode(':', substr($request->image, 0, strpos($request->image, ':')))[1])[0];
            $filename = random_string(5) . time(). '.' . explode(';', explode('/', $request->image)[1])[0];
            $location   = public_path('/images/users/'. $filename);
            // Image::make($request->image)->resize(800, null, function ($constraint) { $constraint->aspectRatio(); })->save($location);
            Image::make($request->image)->resize(300, 300)->save($location);
            $user->image = $filename;
        }
        if($request->password != '') {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        if($request->roles) {
            DB::table('role_user')->where('user_id',$id)->delete();
            foreach ($request->input('roles') as $key => $value) {
                $user->attachRole($value);
            }
        }
        return ['message' => 'Updated successfully!'];    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return ['message' => 'User deleted!'];
    }

    public function searchUser($query)
    {
        $users = User::where(function($search) use ($query) {
            $search->where('name', 'LIKE', '%'.$query.'%')
                   ->orWhere('mobile', 'LIKE', '%'.$query.'%')
                   ->orWhere('email', 'LIKE', '%'.$query.'%')
                   ->orWhere('address', 'LIKE', '%'.$query.'%');
         })->paginate(5);
        
        $users->load('roles'); // merge roles with users
        return $users;
    }

    public function searchRole($query)
    {
        $roles = Role::where(function($search) use ($query) {
            $search->where('name', 'LIKE', '%'.$query.'%')
                   ->orWhere('display_name', 'LIKE', '%'.$query.'%');
         })->paginate(5);
        

        return $roles;
    }

    public function getRoles()
    {
        $roles = Role::get();
        return $roles;
    }

    public function getRolesList()
    {
        $roles = Role::paginate(20);
        $roles->load('permissions');

        return response()->json($roles);
    }

    public function getPermissions()
    {
        $permissions = Permission::get();
        return $permissions;
    }

    public function getPermissionsNames($id)
    {
        $user = User::findOrFail($id)->roles->load('permissions');
        $user->load('roles.permissions');
        $permissions = $user->roles->first()->permissions;
        $names = [];
        foreach ($permissions as $permission) {
            array_push($names, $permission->name);
        }
        return $user;
    }

    public function createRole(Request $request)
    {
        $this->validate($request,array(
            'name'              => 'required|max:191',
            'display_name'      => 'required|max:191',
            'description'       => 'required|max:191',
            'permissions'       => 'required',
        ));        

        $role = new Role;
        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();

        foreach ($request->input('permissions') as $key => $value) {
            $role->attachPermission($value);
        }
        
        return ['message' => 'সফলভাবে সংরক্ষণ করা হয়েছে!'];   
    }

    public function updateRole(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $this->validate($request,array(
            'name'              => 'required|max:191',
            'display_name'      => 'required|max:191',
            'description'       => 'required|max:191',
            'permissions'       => 'required',
        ));



        $role->name = $request->name;
        $role->display_name = $request->display_name;
        $role->description = $request->description;
        $role->save();

        DB::table('permission_role')->where('role_id', $id)->delete();
        foreach ($request->input('permissions') as $key => $value) {
            $role->attachPermission($value);
        }

        return ['message' => 'সফলভাবে হালনাগাদ করা হয়েছে!'];

           
    }

    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);

        $role->delete();

        return ['message' => 'সফলভাবে ডিলেট করা হয়েছে!'];
    }
}
