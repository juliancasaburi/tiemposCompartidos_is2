<?php

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

/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('index');
});

Route::get('contact', function () {
    return view('contact');
});

//--------- User Auth ---------
Auth::routes(['verify' => true]);

Route::get('logout', function() {
    return Redirect::to("/");
});

//----------------------------------------------

//--------- Authenticated Users routes ---------

Route::get('/profile', 'UserController@showUserProfile');

Route::post('logout', function() {
    Auth::logout();
    Session::flush();
    Session::regenerate();
    return Redirect::to("/");
});

Route::get('/profile/modify-email', 'UserController@showEmailForm');
Route::post('/profile/modify-email', 'UserController@modifyEmail')->name('user.modifyEmail');

//----------------------------------------------

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function() {
    //---------------- Admin Auth ----------------
    Route::get('/', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    //--------------------------------------------

    //---------------- Dashboard -----------------
    Route::get('/dashboard', 'AdminController@index')->name('admin.dashboard');
    Route::get('/dashboard/create-property', 'AdminController@showPropertyCreationForm')->name('admin.createProperty');
    Route::post('/dashboard/create-property', 'PropertyCreationController@store')->name('property.create');
    Route::get('/dashboard/user-list', 'AdminController@showUserList')->name('admin.userList');//  Usuarios->Ver listado de usuarios. Dashboard.
    Route::post('/dashboard/user-list', 'AdminController@editUser')->name('admin.editUser');
    Route::get('/dashboard/properties-list', 'AdminController@showPropertyList')->name('admin.propertyList');//  Propiedades->Ver listado de propiedades. Dashboard.
    Route::get('/dashboard/create-week', 'AdminController@showWeekCreationForm')->name('admin.createWeek');
    Route::post('/dashboard/create-week', 'WeekCreationController@store')->name('week.create');
    //--------------------------------------------
});

/*
|--------------------------------------------------------------------------
| Property Routes
|--------------------------------------------------------------------------
*/

Route::get('/property', 'PropertyController@index');

//
