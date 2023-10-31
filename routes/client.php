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
                Route::get('/indexcard', 'indexcard')->name('Invoices.indexcard');
                Route::get('/indexbanktransfer', 'indexbanktransfer')->name('Invoices.indexbanktransfer');
                Route::get('/showinvoicemonetary/{id}', 'showinvoicemonetary')->name('Invoices.showinvoicemonetary');
                Route::get('/showinvoicemonetarynt/{id}', 'showinvoicemonetarynt')->name('Invoices.showinvoicemonetarynt');
                Route::get('/showinvoicePostpaid/{id}', 'showinvoicePostpaid')->name('Invoices.showinvoicePostpaid');
                Route::get('/showinvoicePostpaidnt/{id}', 'showinvoicePostpaidnt')->name('Invoices.showinvoicePostpaidnt');
                Route::get('/showinvoicebanktransfer/{id}', 'showinvoicebanktransfer')->name('Invoices.showinvoicebanktransfer');
                Route::get('/showinvoicebanktransfernt/{id}', 'showinvoicebanktransfernt')->name('Invoices.showinvoicebanktransfernt');
                Route::get('/showinvoicecard/{id}', 'showinvoicecard')->name('Invoices.showinvoicecard');
                Route::get('/showinvoicecardnt/{id}', 'showinvoicecardnt')->name('Invoices.showinvoicecardnt');
                Route::get('/showinvoicereceiptnt/{id}', 'showinvoicereceiptnt')->name('Invoices.showinvoicereceiptnt');
                Route::get('/showinvoicereceiptPostpaidnt/{id}', 'showinvoicereceiptPostpaidnt')->name('Invoices.showinvoicereceiptPostpaidnt');
                Route::get('receipt/{id}', 'receipt')->name('Invoices.receipt');
                Route::get('receiptpostpaid/{id}', 'receiptpostpaid')->name('Invoices.receiptpostpaid');
                Route::get('printreceipt/{id}', 'printreceipt')->name('Invoices.printreceipt');
                Route::get('printpostpaid/{id}', 'printpostpaid')->name('Invoices.printpostpaid');
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
