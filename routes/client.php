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

    //################################ dashboard Client ########################################

        Route::get('/dashboard/clients', function () {
            return view('Dashboard.dashboard_client.dashboard');
        })->name('dashboard.client');

    //################################ end dashboard Client #####################################

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
                Route::get('/index', 'index')->name('Invoices.index');
                Route::get('/indexmonetary', 'indexmonetary')->name('Invoices.indexmonetary');
                Route::get('/indexPostpaid', 'indexPostpaid')->name('Invoices.indexPostpaid');
                Route::get('/indexcard', 'indexcard')->name('Invoices.indexcard');
                Route::get('/indexbanktransfer', 'indexbanktransfer')->name('Invoices.indexbanktransfer');

                Route::get('/showinvoicereceiptnt/{id}', 'showinvoicereceiptnt')->name('Invoices.showinvoicereceiptnt');
                Route::get('/showinvoicereceipt/{id}', 'showinvoicereceipt')->name('Invoices.showinvoicereceipt');
                Route::get('/showinvoicereceiptPostpaidnt/{id}', 'showinvoicereceiptPostpaidnt')->name('Invoices.showinvoicereceiptPostpaidnt');
                Route::get('/showinvoicereceiptPostpaid/{id}', 'showinvoicereceiptPostpaid')->name('Invoices.showinvoicereceiptPostpaid');

                Route::get('/showinvoice/{id}', 'showinvoice')->name('Invoices.showinvoice');
                Route::get('/showinvoicent/{id}', 'showinvoicent')->name('Invoices.showinvoicent');

                Route::patch('/Complete', 'Complete')->name('Invoice.Complete');
                Route::get('/Continue/{id}', 'Continue')->name('Invoice.Continue');
                Route::patch('/Confirmpayment', 'Confirmpayment')->name('Invoice.Confirmpayment');
                Route::get('/Completepayment/{id}', 'Completepayment')->name('Invoice.Completepayment');
                Route::get('/Errorinpayment/{id}', 'Errorinpayment')->name('Invoice.Errorinpayment');

                Route::post('/confirm', 'confirm')->name('Invoices.confirm');
                Route::get('/checkout', 'checkout')->name('Invoices.checkout');
                Route::post('/pay', 'pay')->name('Invoices.pay');
                Route::view('success', 'success')->name('Invoices.success');

                Route::get('/confirmpyinvoice/{id}', 'confirmpyinvoice')->name('Invoices.confirmpyinvoice');

                Route::get('/Show_Service/{id}', 'showService')->name('Invoices.showService');
                Route::get('/Show_Group_Services/{id}', 'showServices')->name('Invoices.showServices');

                Route::get('/promotions/{id}', 'promotion')->name('promotion.promotion');
                Route::get('/images/{id}', 'image')->name('image.image');

                Route::get('receipt/{id}', 'receipt')->name('Invoices.receipt');
                Route::get('receiptpostpaid/{id}', 'receiptpostpaid')->name('Invoices.receiptpostpaid');

                Route::post('modifypymethod', 'modifypymethod')->name('Invoices.modifypymethod');

                Route::get('print/{id}', 'print')->name('Invoices.print');

                Route::get('printreceipt/{id}', 'printreceipt')->name('Invoices.printreceipt');
                Route::get('printpostpaid/{id}', 'printpostpaid')->name('Invoices.printpostpaid');

                Route::stripeWebhooks('webhook');
            });
        });

    //############################# end Clients route ######################################

});
require __DIR__ . '/auth.php';
