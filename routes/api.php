<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

// shared routes
$roles = ['admin', 'super-admin'];

Route::any("/login", "UserController@login");
Route::any("/auth", "CustomerController@otpAuth");
Route::any("/resendOtp/{id}", "CustomerController@resendOtp");
Route::post('/ussd/{bundle_id}', 'UssdController@sendUssdConfirmation');
Route::middleware(['api'])->group(function () {
    Route::post('/ussd', 'UssdController@store');
    Route::get('/ussd/index', 'UssdController@index');
});
Route::get('/charge', 'UssdController@requestForCharge');
Route::get('/admin/users/getOtp/{msisdn}', 'CustomerController@getOtp');
Route::get('/admin/users/{id}/getPermissions', 'UserController@getPermissions');
Route::resource('/admin/categories', 'CategoryController');
Route::resource('/admin/services', 'ServiceController');
Route::resource('/service-updates', 'ServiceUpdateController');


Route::middleware(['auth:api'])->prefix('files')->group(function () {
    Route::post('/uploadFile', 'FileController@uploadFile');
    Route::get('/viewFile', 'FileController@viewFile');
    Route::get('/readExcel', 'SmsController@sendMessageFromRequestData');
});

Route::middleware(['auth:api','ability'])->group(function () {
    Route::resource('letters', 'LetterController');
    Route::resource('letter-requests', 'LetterRequestController');
    Route::resource('workflow-steps', 'StepWorkFlowController');
    Route::post('process-request/{id}', 'LetterRequestController@processRequestAction');
    Route::get("/logOut", "UserController@logOut");
});

Route::prefix('super-admin')->middleware(['auth:api','ability'])->group(function () {
    Route::resource('organizations', 'OrganizationController');
    Route::resource('employees', 'EmployeeController');
    Route::get('/organizations/show/{id}', 'OrganizationController@show');
});

Route::prefix('admin')->middleware(['auth:api','ability'])->group(function () {
    Route::resource('permissions', 'PermissionController');
    Route::get('/permissions/show/{id}', 'PermissionController@show');
    Route::resource('users', 'UserController');
    Route::get('/users/show/{id}', 'UserController@show');
    Route::resource('roles', 'RoleController');
    Route::get('/roles/show/{id}', 'RoleController@show');
   
});

Route::prefix('admin')->group(function (){
        Route::post('/users/{uId}/changePassword', 'UserController@changePassword')->middleware('can:changePassword');
        Route::get('/users/{uId}/restPassword', 'UserController@restPassword')->middleware('can:restPassword');
});

foreach ($roles as $role) :
    Route::prefix($role)->group(function () use ($role) {
        Route::get('getRoles', 'UserController@getRoles');
        Route::get('getDashboardData', 'DashboardController@getDashboardData');
        Route::get('refreshDashboard', 'DashboardController@refreshDashboardCache');
        Route::get('monthlyDetail', 'ReportController@monthlyDetail')->middleware('can:report');
        Route::get('monthlySummary', 'ReportController@monthlySummary')->middleware('can:report');
        Route::post('dailySummary', 'ReportController@dailySummary')->middleware('can:report');
    });
endforeach;