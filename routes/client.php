<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Dashboard\Clients\profiles\ProfileclientController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Dashboard\Clients\InvoiceController;
use App\Http\Controllers\Dashboard\Clients\Notification;

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
        'middleware' => [ 'auth:client', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'xss', 'ClientStatus']
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
    //############################# End Partie Client route ######################################

    //############################# Start Notification route ##########################################

        Route::controller(Notification::class)->group(function() {
            Route::get('/Read', 'markeAsRead')->name('Notification.Readclient');
        });
    //############################# End Notification route ##########################################

    //############################# Clients route ##########################################
        Route::prefix('Invoices')->group(function (){
            Route::controller(InvoiceController::class)->group(function() {
                Route::get('/indexmonetary', 'indexmonetary')->name('Invoices.indexmonetary');
                Route::get('/indexPostpaid', 'indexPostpaid')->name('Invoices.indexPostpaid');
                Route::get('/indexBanktransfer', 'indexBanktransfer')->name('Invoices.indexBanktransfer');
                Route::get('/showinvoicemonetary/{id}', 'showinvoicemonetary')->name('Invoices.showinvoicemonetary');
                Route::get('/showinvoicePostpaid/{id}', 'showinvoicePostpaid')->name('Invoices.showinvoicePostpaid');
                Route::get('/showinvoiceBanktransfer/{id}', 'showinvoiceBanktransfer')->name('Invoices.showinvoiceBanktransfer');
                // Route::get('/invoicecheckout', 'checkout')->name('Invoices.checkout');
                // Route::post('/invoicepay', 'pay')->name('Invoices.pay');
                // Route::view('success', 'success')->name('success');
                // Route::stripeWebhooks('webhook');
            });
        });
    //############################# end Clients route ######################################
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('buy/{product_id}', [App\Http\Controllers\HomeController::class, 'buy'])->name('buy');
        Route::post('confirm', [App\Http\Controllers\HomeController::class, 'confirm'])->name('confirm');
        Route::get('checkout', [App\Http\Controllers\HomeController::class, 'checkout'])->name('checkout');
        Route::post('pay', [App\Http\Controllers\HomeController::class, 'pay'])->name('pay');
        Route::view('success', 'success')->name('success');

        Route::stripeWebhooks('webhook');

        // route for view/blade file
        Route::get('paywithpaypal', array('as' => 'paywithpaypal','uses' => 'App\Http\Controllers\PaypalController@payWithPaypal',));
        // route for post request
        Route::post('paypal', array('as' => 'paypal','uses' => 'App\Http\Controllers\PaypalController@postPaymentWithpaypal',));
        // route for check status responce
        Route::get('paypal', array('as' => 'status','uses' => 'App\Http\Controllers\PaypalController@getPaymentStatus',));
});
require __DIR__ . '/auth.php';
