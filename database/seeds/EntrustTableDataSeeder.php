<?php

use Illuminate\Database\Seeder;
use App\Permission;
use App\Role;

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
        
    }
}
