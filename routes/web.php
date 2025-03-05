<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', function () {
    return view('administrator.dashboard');
});

Route::get('/', 'LoginController@login')->name('login');
Route::get('/login', 'LoginController@login')->name('login');
Route::post('/actionlogin', 'LoginController@actionlogin')->name('actionlogin');
Route::get('/reload-captcha', 'LoginController@reloadCaptcha')->name('reload-captcha');

Route::group(['middleware' => ['auth']], function () {
    Route::get('home', 'HomeController@index')->name('home');
    Route::get('actionlogout', 'LoginController@actionlogout')->name('actionlogout');
    Route::get('createbast', 'HomeController@createbast')->name('createbast');
    Route::post('inputbast', 'BastController@store_bast');
    Route::get('history', 'HistoryController@index')->name('history');
    Route::get('detail/id_bast={id}&supplier_id={supplier_id}', 'HistoryController@detail')->name('detail');
    Route::post('approval/{id}', 'ApprovalController@approve')->name('approve');
    Route::post('approvalehs/{id}&userappv={userappv}', 'ApprovalController@approve')->name('approveehs');
    Route::post('approvaluser/{id}&userappv={userappv}', 'ApprovalController@approve')->name('approveuser');
    // Route::post('rating/{id}', 'ApprovalController@rating')->name('rating');
    Route::post('deny/{id}', 'ApprovalController@deny')->name('deny');
    Route::get('editbast/id_bast={id}&supplier_id={supplier_id}', 'HistoryController@editbast')->name('editbast');
    Route::post('inputedit', 'BastController@inputedit')->name('inputedit');
    // Route::get('/generate-pdf/id={id}&supplier_id={supplier_id}&action={action}', 'PDFController@generatePDF')->name('getpdf');
    Route::get('/generate-pdf/{id}/{supplier_id}/{action}', 'PDFController@generatePDF')->name('getpdf');

});

// Restrict supplier to get this route and redirect to home
Route::group(['middleware' => ['cekActing', 'auth']], function () {
    Route::get('approval', 'ApprovalController@index')->name('approval');
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');
    // Route::get('user', 'DashboardController@userlogin')->name('user');

    // Route User Control
    Route::get('userskf', 'UserController@skfuser')->name('userskf');
    Route::get('usersupplier', 'UserController@supplieruser')->name('usersupplier');
    Route::get('userskf/add', 'UserController@indexuserskf')->name('adduserskf');
    Route::get('usersupplier/add', 'UserController@indexusersupplier')->name('addusersupplier');
    Route::post('storeskfuser', 'UserController@addskfuser')->name('storeskfuser');
    Route::post('storesupplieruser', 'UserController@addsupplieruser')->name('storesupplieruser');
    Route::post('deleteuserskf/{id}', 'UserController@deleteuserskf')->name('deleteuserskf');
    Route::post('deleteusersupplier/{id}', 'UserController@deleteusersupplier')->name('deleteusersupplier');
    Route::post('edituserskf/{id}', 'UserController@edituserskf')->name('edituserskf');
    Route::post('editusersupplier/{id}', 'UserController@editusersupplier')->name('editusersupplier');
    // Route Data BAST
    Route::get('bastdata', 'AdminController@indexbast')->name('bastdata');
    Route::post('update-status', 'AdminController@updatestatus')->name('updatestatus');
    Route::post('deletebast/{id}', 'AdminController@deletebast')->name('deletebast');
    // Route Data Department
    Route::get('deptdata', 'AdminController@indexdept')->name('deptdata');
    Route::post('adddept', 'AdminController@adddept')->name('adddept');
    Route::post('editdept/{id}', 'AdminController@editdept')->name('editdept');
    Route::post('deletedept/{id}', 'AdminController@deletedept')->name('deletedept');
    Route::get('test/email', 'DashboardController@test_email');
});
