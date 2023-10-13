<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| doctor Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'auth:client', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'xss', 'UserStatus']
    ], function () {

    //################################ dashboard patient ########################################
    Route::get('/dashboard/client', function () {
        return view('Dashboard.dashboard_client.dashboard');
    })->name('dashboard.client');
    //################################ end dashboard patient #####################################

        //############################# clients route ##########################################

        //############################# end clients route ######################################
});
require __DIR__ . '/auth.php';





