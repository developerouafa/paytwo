<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App\Http\Controllers\Dashboard\Clients\profiles\ProfileclientController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Dashboard\Clients\InvoiceController;
use App\Http\Controllers\Dashboard\Clients\Notification;
use App\Http\Controllers\Dashboard\dashboard_users\ReceiptAccountController;

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
                Route::get('/showinvoicemonetarynt/{id}', 'showinvoicemonetarynt')->name('Invoices.showinvoicemonetarynt');
                Route::get('/showinvoicePostpaid/{id}', 'showinvoicePostpaid')->name('Invoices.showinvoicePostpaid');
                Route::get('/showinvoicePostpaidnt/{id}', 'showinvoicePostpaidnt')->name('Invoices.showinvoicePostpaidnt');
                Route::get('/showinvoiceBanktransfer/{id}', 'showinvoiceBanktransfer')->name('Invoices.showinvoiceBanktransfer');
                Route::get('/showinvoiceBanktransfernt/{id}', 'showinvoiceBanktransfernt')->name('Invoices.showinvoiceBanktransfernt');
                Route::get('/showinvoicereceiptnt/{id}', 'showinvoicereceiptnt')->name('Invoices.showinvoicereceiptnt');
                Route::get('receipt/{id}', 'receipt')->name('Invoices.receipt');
                Route::get('print/{id}', 'print')->name('Invoices.print');
                Route::post('/confirm', 'confirm')->name('Invoices.confirm');
                Route::get('/checkout', 'checkout')->name('Invoices.checkout');
                Route::post('/pay', 'pay')->name('Invoices.pay');
                Route::view('success', 'success')->name('Invoices.success');

                Route::stripeWebhooks('webhook');
            });
        });
    //############################# end Clients route ######################################

});
require __DIR__ . '/auth.php';
