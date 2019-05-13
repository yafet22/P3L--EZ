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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/authenticate', 'TokenController@authenticate');
Route::post('/mobileauthenticate', 'TokenController@mobileauthenticate');
Route::get('/whoami', 'TokenController@validateToken');

Route::resource('user','UserController');

Route::resource('branches','BranchController');

Route::resource('roles','RoleController');

Route::resource('users','UserController');

Route::resource('employees','EmployeeController');

Route::resource('sales','SalesController');
Route::get('suppliersales/{id}','SalesController@showbySupplier');

Route::resource('suppliers','SupplierController');

Route::resource('services','ServiceController');

Route::resource('sparepart_types','Sparepart_typeController');

Route::resource('spareparts','SparepartController');
Route::post('updatesparepart/{id}','SparepartController@updateSparepart');
Route::post('updatesparepart','SparepartController@sparepartVerification');
Route::put('updatesparepartmobile/{id}','SparepartController@sparepartVerificationMobile');

Route::resource('customers','CustomerController');

Route::resource('motorcycle_brands','Motorcycle_brandController');

Route::resource('motorcycle_types','Motorcycle_typeController');

Route::resource('motorcycles','MotorcycleController');
Route::get('usermotorcycles/{id}','MotorcycleController@showByUser');

Route::resource('procurements','ProcurementController');
Route::post('procurementDetails','ProcurementController@storeDetail');
Route::put('procurementDetails/{id}','ProcurementController@updateDetail');
Route::get('procurementDetails/{id}','ProcurementController@showdetail');

Route::resource('transactions','TransactionController');
Route::post('detailService','TransactionController@storeDetailService');
Route::get('detailService/{id}','TransactionController@showDetailService');
Route::post('detailSparepart','TransactionController@storeDetailSparepart');
Route::get('detailSparepart/{id}','TransactionController@showDetailSparepart');
Route::put('payment/{id}','TransactionController@payment');
Route::post('searchDetail','TransactionController@searchDetailService');

Route::get('/generate-procurement-docs/{id}', 'FileController@generateProcurementDocs');
Route::get('/generate-work-order-docs/{id}', 'FileController@generateWorkOrderDocs');

Route::get('/transaction-per-year/{year}','ReportController@TransactionperYear');
Route::get('/expense-per-year/{year}','ReportController@ExpenseperYear');
Route::get('/transaction-by-branch','ReportController@TransactionbyBranch');
Route::get('/best-seller-sparepart','ReportController@BestSellerSparepart');
