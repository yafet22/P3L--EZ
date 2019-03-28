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

Route::resource('suppliers','SupplierController');

Route::resource('services','ServiceController');

Route::resource('sparepart_types','Sparepart_typeController');

Route::resource('spareparts','SparepartController');

Route::resource('customers','CustomerController');

Route::resource('motorcycle_brands','Motorcycle_brandController');

Route::resource('motorcycle_types','Motorcycle_typeController');

Route::resource('motorcycles','MotorcycleController');
Route::get('usermotorcycles/{id}','MotorcycleController@showByUser');