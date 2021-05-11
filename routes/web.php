<?php

use App\Http\Controllers\Admin\Auth\AdminController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

// Basic User Authentication routes
Auth::routes();

// Admin Authentication routes:
// The admin controller routes are prefix with `admin`
Route::group(['prefix' => 'admin'], function(){

    // We are using `guest` middleware with `admin` guard for the authenticated users.
    // for this route.
    // So after colon word `admin` (:admin) represents guard and behind the scenes it
    // will use RedirectIfAuthenticated middleware class to verify Does the authenticate
    // user is authenticated with `admin` guard?

    // If yes then redirect back to the route which had given in middleware
    // otherwise use `next($request)` method to access the `localhost/admin/login`
    // route.
    Route::group(['middleware' => 'guest:admin'], function(){
        Route::get('login', [AdminController::class, 'showLoginForm'])->name('admin.login');
        Route::post('login', [AdminController::class, 'login']);
    });

    // This group is for the protection of admin authentication routes and uses `auth.admin`
    // middleware which redirect the unauthenticated users back to the login form.
    // For example: If user try to access `localhost/admin/dashboard` without login
    // then it will redirect back to the `localhost/admin/login` because of AdminAuthenticate
    // middleware.
    Route::group(['middleware' => 'auth.admin'], function(){
        Route::get('dashboard', [AdminController::class, 'showDashboard'])->name('dashboard');
    });
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
