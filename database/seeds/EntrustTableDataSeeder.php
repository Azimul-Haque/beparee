<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;
use App\Store;
use App\User;
use Illuminate\Support\Facades\Hash;

class EntrustTableDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
        	[
        		'name' => 'user-crud',
        		'display_name' => 'User CRUD',
        		'description' => 'See only Listing Of Role'
        	],
        	[
        		'name' => 'role-crud',
        		'display_name' => 'Role CRUD',
        		'description' => 'Create New Role'
        	],
        	[
        		'name' => 'purchase-crud',
        		'display_name' => 'Purchase CRUD',
        		'description' => 'Purchase Crud Permission'
        	],
            [
                'name' => 'sales-crud',
                'display_name' => 'Sales CRUD',
                'description' => 'Sales Crud Permission'
            ],
            [
                'name' => 'inventory-crud',
                'display_name' => 'Inventory CRUD',
                'description' => 'Inventory Crud Permission'
            ],
            [
                'name' => 'accounting-crud',
                'display_name' => 'Accounting CRUD',
                'description' => 'Accounting Crud Permission'
            ],
            [
                'name' => 'hr-crud',
                'display_name' => 'HR CRUD',
                'description' => 'HR Crud Permission'
            ],
            [
                'name' => 'admin-menu',
                'display_name' => 'Admin Menu',
                'description' => 'Admin Menu Permission'
            ],
        	[
        		'name' => 'store-crud',
        		'display_name' => 'Store CRUD',
        		'description' => 'Store CRUD Permission'
        	]
        ];

        foreach ($permission as $key => $value) {
        	Permission::create($value);
        }


        $role = [
          [
            'name' => 'superadmin',
            'display_name' => 'Super Admin',
            'description' => 'Super Admin'
          ],
          [
            'name' => 'shopowner',
            'display_name' => 'Shop Owner',
            'description' => 'Shop Owner'
          ],
          [
            'name' => 'manager',
            'display_name' => 'Manager',
            'description' => 'Manager'
          ]
        ];

        foreach ($role as $key => $value) {
          Role::create($value);
        }

        $store = [
          [
            'token' => 'assASDASd455465465465465ASDASDASd8aksjdhakjsdASLKdjlkasjdlkJSLKDJLKASd534654SPOiauqwejncxzvbv45457sd',
            'code' => '6GTYH45A5S',
            'name' => 'ডেমো স্টোর',
            'established' => 1992,
            'address' => 'ধানমন্ডি ১৯, ঢাকা-১২০৭',
            'activation_status' => 1,
            'payment_status' => 1,
            'payment_method' => 0
          ],
          [
            'token' => 'assASDA458lkj465465465ASDASDASd8aksjdhakjsdASLKdjlka547kjySLKDJLKASd534654S4587lkjejncxzvbvacsds47',
            'code' => '5GLTR20AXI',
            'name' => 'ডেমো স্টোর ২',
            'established' => 1993,
            'address' => 'ধানমন্ডি ১৯, ঢাকা-১২০৭',
            'activation_status' => 1,
            'payment_status' => 1,
            'payment_method' => 0
          ]
        ];

        foreach ($store as $key => $value) {
          Store::create($value);
        }

        $user = [
          [
            'name' => 'আব্দুল মান্নান',
            'email' => 'mannan@beparee.com',
            'store_id' => 0,
            'password' => Hash::make('secret123') 
          ],
          [
            'name' => 'রিফাত',
            'email' => 'rifat@beparee.com',
            'store_id' => 0,
            'password' => Hash::make('secret123') 
          ]
        ];

        foreach ($user as $key => $value) {
          User::create($value);
        }
        
    }
}


// INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ('9', '1');
// INSERT INTO `role_user` (`user_id`, `role_id`) VALUES ('2', '1');
