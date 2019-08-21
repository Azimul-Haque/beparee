<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResources(['user' => 'API\UserController']);

Route::get('roles', 'API\UserController@getRoles'); // For user Select Options
Route::get('roles/list', 'API\UserController@getRolesList');
Route::post('role/create', 'API\UserController@createRole');
Route::put('role/update/{id}', 'API\UserController@updateRole');
Route::delete('role/delete/{id}', 'API\UserController@deleteRole');

Route::get('permissions', 'API\UserController@getPermissions'); // For role Select Options
Route::get('permissions/names/{id}', 'API\UserController@getPermissionsNames'); // For Permission

Route::apiResources(['store' => 'API\StoreController']);
Route::get('load/store/{code}', 'API\StoreController@loadStore');
Route::get('load/districts', 'API\StoreController@loadDistricts');
Route::get('load/upazilla/{district}', 'API\StoreController@loadUpazillas');
Route::get('owners', 'API\StoreController@getOwners'); // For store Select Options
Route::put('store/update/by/user/{id}', 'API\StoreController@updateByUser');

Route::apiResources(['product' => 'API\ProductController']);
Route::get('load/product/{code}', 'API\ProductController@loadProducts');
Route::get('load/single/product/{id}/{code}', 'API\ProductController@loadSingleProduct');
Route::get('load/single/product/sales/{id}/{code}', 'API\ProductController@loadSingleProductSales');
Route::put('single/product/stock/update/{id}', 'API\ProductController@updateSingleProductStock');
Route::delete('single/product/stock/delete/{id}', 'API\ProductController@deleteSingleProductStock');

Route::get('load/product/vendor/{code}', 'API\ProductController@loadVendors');
Route::get('product/category/{code}', 'API\ProductController@loadCategories');
Route::post('product/category/store', 'API\ProductController@storeCategory');
Route::put('product/category/update/{code}', 'API\ProductController@updateCategory');


Route::apiResources(['vendor' => 'API\VendorController']);
Route::get('load/vendor/{code}', 'API\VendorController@loadVendors');
Route::get('load/single/vendor/{id}/{code}', 'API\VendorController@loadSingleVendor');
Route::get('load/vendors/due/{code}', 'API\VendorController@loadDues');
Route::put('load/vendor/pay/due/{id}', 'API\VendorController@payDue');
Route::get('load/duehistory/{code}', 'API\VendorController@loadDuehistories');

Route::apiResources(['purchase' => 'API\PurchaseController']);
Route::get('load/purchase/{code}', 'API\PurchaseController@loadPurchases');
Route::get('load/purchase/product/{code}', 'API\PurchaseController@loadProducts');

Route::apiResources(['staff' => 'API\StaffController']);
Route::get('load/staff/{code}', 'API\StaffController@loadStaffs');
Route::get('load/staff/for/attendance/{code}', 'API\StaffController@loadStaffsForAtt');
Route::get('load/staff/attendance/for/calendar/{code}', 'API\StaffController@loadStaffsAttForCal');
Route::post('post/staff/attendance', 'API\StaffController@postStaffAtt');
Route::get('load/single/staff/{id}/{code}', 'API\StaffController@loadSingleStaff');
Route::get('load/single/staff/salary/history/{id}/{code}', 'API\StaffController@loadSingleStaffSalaryHistory');
Route::get('load/single/staff/salary/history/totals/{id}/{code}', 'API\StaffController@loadSingleStaffSalaryTotals');
Route::post('load/staff/pay/salary', 'API\StaffController@storeSingleStaffSalary');

Route::apiResources(['customer' => 'API\CustomerController']);
Route::get('load/customer/{code}', 'API\CustomerController@loadCustomers');
Route::get('load/single/customer/{id}/{code}', 'API\CustomerController@loadSingleCustomer');
Route::get('load/single/customer/dues/{id}/{code}', 'API\CustomerController@loadSingleCustomerDueHistories');
Route::put('load/customer/pay/due/{id}', 'API\CustomerController@payDue');
Route::get('load/single/customer/purchases/{id}/{code}', 'API\CustomerController@loadSingleCustomerPurchases');
Route::get('load/customers/due/{code}', 'API\CustomerController@loadDues');
Route::get('load/customersdues/{code}', 'API\CustomerController@loadCustomersDues');

Route::apiResources(['expense' => 'API\ExpenseController']);
Route::get('load/expense/{code}', 'API\ExpenseController@loadExpenses');
Route::get('load/expense/history/{code}', 'API\ExpenseController@loadExpenseHistory');
Route::get('load/expense/category/{code}', 'API\ExpenseController@loadExpenseCategories');
Route::get('load/expense/staff/{code}', 'API\ExpenseController@loadExpenseStaff');
Route::get('load/single/category/expense/{id}/{code}', 'API\ExpenseController@loadSingleExpense');
Route::get('load/single/category/expenses/store/wise/{id}/{code}', 'API\ExpenseController@loadSingleExpenseStoreWise');
Route::get('load/single/category/expenses/totals/{id}/{code}', 'API\ExpenseController@loadSingleExpenseTotals');

Route::apiResources(['sale' => 'API\SaleController']);
Route::get('load/sale/{code}', 'API\SaleController@loadSales');
Route::get('load/sale/product/{code}', 'API\SaleController@loadProducts');
Route::get('load/sale/customer/{code}', 'API\SaleController@loadCustomers');

Route::get('get/store/id/{code}', 'API\StoreController@getStoreID');


Route::get('load/accounts/lastsevendays/sales/{code}', 'API\AccountsController@loadLastSevenDaysSales');
Route::get('load/accounts/thisyears/profit/{code}', 'API\AccountsController@loadThisYearsProfit');
Route::get('load/accounts/profit/calc/this/month/{code}', 'API\AccountsController@loadProfitCaclThisMonth');



// each search function has a big bug, it does not filters user's stores!!!
// each search function has a big bug, it does not filters user's stores!!!
// each search function has a big bug, it does not filters user's stores!!!
// each search function has a big bug, it does not filters user's stores!!!
Route::get('searchuser/{query}', 'API\UserController@searchUser'); 
Route::get('searchrole/{query}', 'API\UserController@searchRole');
Route::get('searchstore/{query}', 'API\StoreController@searchStore');
Route::get('searchproduct/{query}', 'API\ProductController@searchProduct');
Route::get('searchpurchase/{query}', 'API\PurchaseController@searchPurchase');
Route::get('searchvendor/{query}', 'API\VendorController@searchVendor');
Route::get('searchstaff/{query}', 'API\StaffController@searchStaff');
Route::get('searchcustomer/{query}', 'API\CustomerController@searchCustomer');
