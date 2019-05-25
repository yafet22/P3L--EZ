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
Route::get('/generate-transaction-per-month/{year}', 'FileController@generateTransactionPerMonth');
Route::get('/generate-sparepart-best-seller', 'FileController@generateSparepartBestSeller');
Route::get('/generate-service-selling/{year}/{month}', 'FileController@generateServiceSelling');
Route::get('/generate-remaining-stock/{year}/{sparepart}', 'FileController@generateRemainingStock');
Route::get('/chart-remaining-stock', 'FileController@chartRemainingStock');
Route::get('/generate-transaction-per-year', 'FileController@generateTransactionPerYear');
Route::get('/generate-expense/{year}','FileController@generateExpenseReport');
Route::get('/generate-receipt/{id}','FileController@generateReceipt');

Route::get('/transaction-per-year/{year}','ReportController@TransactionperYear');
Route::get('/expense-per-year/{year}','ReportController@ExpenseperYear');
Route::get('/transaction-by-branch','ReportController@TransactionbyBranch');
Route::get('/best-seller-sparepart','ReportController@BestSellerSparepart');
Route::get('/service-selling/{year}/{month}','ReportController@ServiceSelling');
Route::get('/remaining-stock/{year}/{sparepart}','ReportController@RemainingStock');

Route::get('/detail-sparepart/{id}','ReportController@DetailSparepart');
Route::get('/detail-service/{id}','ReportController@DetailService');
Route::get('/work-order/{id}','ReportController@WorkOrder');
Route::get('/customer-service/{id}','ReportController@DataCS');
Route::get('/mechanic-detail-sparepart/{id}','ReportController@MechanicSP');
Route::get('/mechanic-detail-service/{id}','ReportController@MechanicSV');
Route::get('/motor-sparepart/{id}','ReportController@MotorSparepart');
Route::get('/motor-service/{id}','ReportController@MotorService');
Route::get('/generate-spk/{id}','ReportController@cetaksuratperintahkerja');
Route::get('/generate-sp/{id}','ReportController@CetakPemesanan');