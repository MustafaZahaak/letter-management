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



Route::middleware([])->prefix('subscriptions')->group(function () {
    Route::resource('', 'SubscriptionController');
    Route::post('testSMS', 'SmsController@smsReceived');
    Route::get('/listSubCats/{id}', 'SubscriptionController@listSubCats');//->middleware('can:subscriptions-list');
    Route::get('/listUnsubCats/{id}', 'SubscriptionController@listNotSubCats');//->middleware('can:subscriptions-list');;
    Route::post('/deactive', 'SubscriptionController@unSubscribe');
});

Route::middleware(['auth:api'])->prefix('files')->group(function () {
    Route::post('/uploadFile', 'FileController@uploadFile');
    Route::get('/viewFile', 'FileController@viewFile');
    Route::get('/readExcel', 'SmsController@sendMessageFromRequestData');
});

Route::middleware(['auth:api','ability'])->group(function () {
    Route::resource('letters', 'LetterController');
    Route::resource('sms', 'SmsController');
    Route::get("/logOut", "UserController@logOut");
    Route::post("/sendSms", "SmsController@sendMessage");
    Route::post('/receiveSms', "SmsController@receiveSms");
});

Route::prefix('super-admin')->middleware(['auth:api','ability'])->group(function () {
    Route::resource('organizations', 'OrganizationController');
    Route::resource('employees', 'EmployeeController');
    Route::get('/organizations/show/{id}', 'OrganizationController@show');
    Route::get('archive', 'SendLogArchiveController@archive');
    Route::post('createNationalEmployeeGroup', 'GroupController@createNationalEmployeeGroup');
    Route::post('createInternationalEmployeeGroup', 'GroupController@createInternationalEmployeeGroup');
    Route::post('createAllEmployeeGroup', 'GroupController@createAllEmployeeGroup');
    /** used by administration */
    Route::put('updateNationalEmployeeGroup', 'GroupController@updateNationalEmployeeGroup');
    Route::put('updateInternationalEmployeeGroup', 'GroupController@updateInternationalEmployeeGroup');
    Route::put('updateAllEmployeeGroup', 'GroupController@updateAllEmployeeGroup');
});

Route::prefix('admin')->middleware(['auth:api','ability'])->group(function () {
    Route::resource('permissions', 'PermissionController');
    Route::get('/permissions/show/{id}', 'PermissionController@show');
    Route::resource('users', 'UserController');
    Route::get('/users/show/{id}', 'UserController@show');
    Route::resource('roles', 'RoleController');
    Route::get('/roles/show/{id}', 'RoleController@show');
    Route::resource('members', 'GroupMemberController');
    Route::get('/members/show/{id}', 'GroupMemberController@show');
    Route::get('groups/withMembers', 'GroupController@withMembers');
    Route::get('/groups/show/{id}', 'GroupController@show');
    Route::resource('groups', 'GroupController');
    Route::resource('customers', 'CustomerController');
    Route::post('/customers/subscribedTo', 'CustomerController@subscribedTo');
    Route::get('/customers/show/{id}', 'CustomerController@show');
    Route::post('/customers/batchSubs', 'CustomerController@batchProcess');
    Route::get('/subscriptions/show/{id}', 'SubscriptionController@show');
    Route::get('smsReceived', 'SmsController@smsReceived');
    Route::resource('packages', 'PackageController');
    Route::get('/packages/show/{id}', 'PackageController@show');
    // Route::resource('categories', 'CategoryController');
    Route::get('/categories/show/{id}', 'CategoryController@show');
   
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