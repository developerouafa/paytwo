<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Dashboard\Clients\profiles\ProfileclientController;
use App\Http\Controllers\Auth\PasswordController;

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

    //############################# Start Partie Client route ##########################################

        Route::group(['prefix' => 'ProfileClient'], function(){
            Route::put('password', [PasswordController::class, 'update'])->name('password.update');
            Route::controller(ProfileclientController::class)->group(function() {
                Route::get('/profile', 'edit')->name('profileclient.edit');
                Route::patch('/profile', 'update')->name('profileclient.update');
                Route::delete('/profile', 'destroy')->name('profileclient.destroy');
            });
        });
    //############################# end Partie Client route ######################################

});
require __DIR__ . '/auth.php';





