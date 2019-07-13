<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;
use App\Store;
use App\User;
use App\Expensecategory;
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
              'name' => 'admin-menu',
              'display_name' => 'Admin Menu',
              'description' => 'Admin Menu Permission'
          ],
          [
              'name' => 'store-crud',
              'display_name' => 'Store CRUD',
              'description' => 'Store CRUD Permission'
          ],


          [
              'name' => 'store-profile',
              'display_name' => 'Store Profile',
              'description' => 'Store Profile Permission'
          ],
          [
              'name' => 'product-page',
              'display_name' => 'Product Page',
              'description' => 'Product Page'
          ],
          [
              'name' => 'vendor-page',
              'display_name' => 'Vendor Page',
              'description' => 'Vendor Page'
          ],
          [
              'name' => 'purchase-page',
              'display_name' => 'Purchase CRUD',
              'description' => 'Purchase Crud Permission'
          ],
          [
              'name' => 'due-page',
              'display_name' => 'Due CRUD',
              'description' => 'Due Crud Permission'
          ],
          [
              'name' => 'staff-page',
              'display_name' => 'Staff CRUD',
              'description' => 'Staff Crud Permission'
          ],
          [
              'name' => 'customer-page',
              'display_name' => 'Customer CRUD',
              'description' => 'Customer Crud Permission'
          ],
          [
              'name' => 'expense-page',
              'display_name' => 'Expense CRUD',
              'description' => 'Expense Crud Permission'
          ],
          [
              'name' => 'sale-page',
              'display_name' => 'Sale CRUD',
              'description' => 'Sale Crud Permission'
          ],
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
            'mobile' => '0111118392',
            'address' => 'মোহাম্মদপুর, ঢাকা-১২০৭',
            'password' => Hash::make('secret123') 
          ],
          [
            'name' => 'রিফাত',
            'email' => 'rifat@beparee.com',
            'mobile' => '01750398392',
            'address' => 'মোহাম্মদপুর, ঢাকা-১২০৭',
            'password' => Hash::make('secret123') 
          ],
          [
            'name' => 'মালিক ১',
            'email' => 'owner1@beparee.com',
            'mobile' => '01222298392',
            'address' => 'মোহাম্মদপুর, ঢাকা-১২০৭',
            'password' => Hash::make('secret123') 
          ],
          [
            'name' => 'মালিক ২',
            'email' => 'owner2@beparee.com',
            'mobile' => '01333398392',
            'address' => 'মোহাম্মদপুর, ঢাকা-১২০৭',
            'password' => Hash::make('secret123') 
          ],
          [
            'name' => 'মালিক ৩',
            'email' => 'owner3@beparee.com',
            'mobile' => '01444498392',
            'address' => 'মোহাম্মদপুর, ঢাকা-১২০৭',
            'password' => Hash::make('secret123') 
          ]
        ];

        foreach ($user as $key => $value) {
          User::create($value);
        }

        $expensecategory = [
          [
            'store_id' => null,
            'type' => 0,
            'name' => 'বেতন'
          ],
          [
            'store_id' => null,
            'type' => 0,
            'name' => 'বিদ্যুৎ বিল'
          ],
          [
            'store_id' => null,
            'type' => 0,
            'name' => 'গ্যাস বিল'
          ],
          [
            'store_id' => null,
            'type' => 0,
            'name' => 'পণ্য পরিবহন খরচ'
          ],
          [
            'store_id' => null,
            'type' => 0,
            'name' => 'দোকান ভাড়া'
          ],
          [
            'store_id' => null,
            'type' => 0,
            'name' => 'পরিবহন'
          ],
          [
            'store_id' => null,
            'type' => 0,
            'name' => 'আপ্যায়ন'
          ],
          [
            'store_id' => null,
            'type' => 0,
            'name' => 'অন্যান্য'
          ]
        ];

        foreach ($expensecategory as $key => $value) {
          Expensecategory::create($value);
        }
        
    }
}


// INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ('1', '1');
// INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ('2', '1');
// INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ('3', '1');
// INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ('4', '1');
// INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ('5', '1');
// INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ('6', '1');
// INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ('7', '1');
// INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ('8', '1');
// INSERT INTO `permission_role` (`permission_id`, `role_id`) VALUES ('9', '1');

// INSERT INTO `role_user` (`user_id`, `role_id`) VALUES ('1', '1');
// INSERT INTO `role_user` (`user_id`, `role_id`) VALUES ('2', '1');

// INSERT INTO `store_user` (`user_id`, `store_id`) VALUES ('3', '1');
// INSERT INTO `store_user` (`user_id`, `store_id`) VALUES ('3', '2');
// INSERT INTO `store_user` (`user_id`, `store_id`) VALUES ('4', '2');
