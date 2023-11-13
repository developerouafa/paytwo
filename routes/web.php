<?php

use App\Http\Controllers\BanktransferController;
use App\Http\Controllers\Dashboard\dashboard_users\Clients\ClientController;
use App\Http\Controllers\Dashboard\dashboard_users\childrens\childrenController;
use App\Http\Controllers\Dashboard\dashboard_users\invoices\GroupproductController;
use App\Http\Controllers\Dashboard\dashboard_users\invoices\InvoiceController;
use App\Http\Controllers\Dashboard\dashboard_users\PaymentaccountController;
use App\Http\Controllers\Dashboard\dashboard_users\ReceiptAccountController;
use App\Http\Controllers\Dashboard\dashboard_users\Products\MainimageproductController;
use App\Http\Controllers\Dashboard\dashboard_users\Products\MultipimageController;
use App\Http\Controllers\Dashboard\dashboard_users\profiles\ProfileController;
use App\Http\Controllers\Dashboard\dashboard_users\roles\RolesController;
use App\Http\Controllers\Dashboard\dashboard_users\Sections\SectionController;
use App\Http\Controllers\Dashboard\dashboard_users\Products\ProductController;
use App\Http\Controllers\Dashboard\dashboard_users\users\UserController;
use App\Http\Controllers\Dashboard\dashboard_users\users\ImageuserController;
use App\Http\Controllers\Dashboard\dashboard_users\Products\PromotionController;
use App\Http\Controllers\Dashboard\dashboard_users\Products\StockproductController;
use App\Http\Controllers\PaymentgatewayController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call(' view:clear');
    Artisan::call('route:clear');
    return"Cleared!";
});

//* To access these pages, you must log in first
    Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'auth', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'xss', 'UserStatus']], function(){

        Route::get('/', function () {
            return view('Dashboard/index');
        });

        Route::get('/dashboard', function () {
            return view('Dashboard/index');
        })->name('dashboard');

        //############################# Start Partie User|permissions|roles route ##########################################
            Route::resource('roles', RolesController::class);
            Route::resource('users', UserController::class);

            Route::controller(UserController::class)->group(function() {
                Route::get('editstatusdéactiveuser/{id}', 'editstatusdéactive')->name('editstatusdéactiveuser');
                Route::get('editstatusactiveuser/{id}', 'editstatusactive')->name('editstatusactiveuser');
                Route::get('/clienttouser/{id}', 'clienttouser')->name('clienttouser');
                Route::get('/clienttouserinvoice/{id}', 'clienttouserinvoice')->name('clienttouserinvoice');
                Route::patch('/confirmpayment', 'confirmpayment')->name('Invoice.confirmpayment');
                Route::patch('/refusedpayment', 'refusedpayment')->name('Invoice.refusedpayment');
                Route::get('/Deleted_Users', 'softusers')->name('Users.softdeleteusers');
                Route::get('/deleteallusers', 'deleteallusers')->name('Users.deleteallusers');
                Route::get('restoreusers/{id}', 'restoreusers')->name('Users.restoreusers');
                Route::get('restoreallusers', 'restoreallusers')->name('Users.restoreallusers');
                Route::post('restoreallselectusers', 'restoreallselectusers')->name('Users.restoreallselectusers');
            });
        //############################# end Partie User|permissions|roles route ######################################

        //############################# Start Partie Profile User ##########################################

            Route::group(['prefix' => 'Profile'], function(){
                Route::controller(ProfileController::class)->group(function() {
                    Route::get('/profile', 'edit')->name('profile.edit');
                    Route::patch('/profile', 'updateprofile')->name('profile.update');
                    Route::delete('/profile', 'destroy')->name('profile.destroy');
                });

                Route::controller(ImageuserController::class)->group(function() {
                    Route::post('/imageuser', 'store')->name('imageuser.store');
                    Route::patch('/imageuser', 'update')->name('imageuser.update');
                    Route::get('/imageuser', 'destroy')->name('imageuser.delete');
                });
            });
        //############################# end Partie Profile User ######################################

        //############################# Section & Children Section route ##########################################
            Route::group(['prefix' => 'Sections'], function(){
                Route::controller(SectionController::class)->group(function() {
                    Route::get('/index', 'index')->name('Sections.index');
                    Route::get('/Deleted_Section', 'softdelete')->name('Sections.softdelete');
                    Route::get('/Show_by_Section/{id}', 'showsection')->name('Sections.showsection');
                    Route::post('/create', 'store')->name('Sections.store');
                    Route::patch('/update', 'update')->name('Sections.update');
                    Route::delete('/destroy', 'destroy')->name('Sections.destroy');
                    Route::get('editstatusdéactivesec/{id}', 'editstatusdéactive')->name('editstatusdéactivesec');
                    Route::get('editstatusactivesec/{id}', 'editstatusactive')->name('editstatusactivesec');
                    Route::get('/deleteall', 'deleteall')->name('Sections.deleteall');
                    Route::get('restoresc/{id}', 'restore')->name('restoresc');
                    Route::get('restoreallsections', 'restoreallsections')->name('Sections.restoreallsections');
                    Route::post('restoreallselectsections', 'restoreallselectsections')->name('Sections.restoreallselectsections');
                });

                Route::controller(childrenController::class)->group(function() {
                    Route::get('/child', 'index')->name('Children_index');
                    Route::get('/Deleted_Children', 'softdelete')->name('Children.softdelete');
                    Route::get('/Show_by_Children/{id}', 'showchildren')->name('Children.showchildren');
                    Route::post('/createchild', 'store')->name('Children.create');
                    Route::patch('/updatechild', 'update')->name('Children.update');
                    Route::delete('/deletechild', 'destroy')->name('Children.delete');
                    Route::get('editstatusdéactivech/{id}', 'editstatusdéactive')->name('editstatusdéactivech');
                    Route::get('editstatusactivech/{id}', 'editstatusactive')->name('editstatusactivech');
                    Route::get('/deleteall', 'deleteall')->name('Children.deleteall');
                    Route::get('restorech/{id}', 'restore')->name('restorech');
                    Route::get('restoreallchildrens', 'restoreallchildrens')->name('Children.restoreallchildrens');
                    Route::post('restoreallselectchildrens', 'restoreallselectchildrens')->name('Children.restoreallselectchildrens');
                });
            });
        //############################# end Section & Children Section route ######################################

        //############################# Products route ##########################################
            Route::group(['prefix' => 'Products'], function(){
                Route::controller(ProductController::class)->group(function() {
                    Route::get('/index', 'index')->name('Products.index');
                    Route::get('/Show_Product/{id}', 'show')->name('Product.show');
                    Route::get('/Deleted_Product', 'softdelete')->name('Products.softdelete');
                    Route::get('/create', 'create')->name('product.createprod');
                    Route::post('/store', 'store')->name('product.store');
                    Route::get('editstatusdéactivepr/{id}', 'editstatusdéactive')->name('editstatusdéactivepr');
                    Route::get('editstatusactivepr/{id}', 'editstatusactive')->name('editstatusactivepr');
                    Route::patch('/update', 'update')->name('product.update');
                    Route::delete('/destroy', 'destroy')->name('product.destroy');
                    Route::get('/deleteall', 'deleteall')->name('product.deleteall');
                    Route::get('restorepr/{id}', 'restore')->name('restorepr');
                    Route::get('forcedeletepr/{id}', 'forcedelete')->name('forcedeletepr');
                });

                Route::prefix('promotions')->group(function (){
                    Route::controller(PromotionController::class)->group(function() {
                        Route::get('/promotions/{id}', 'index');
                        Route::post('/createpromotion', 'store')->name('promotions.create');
                        Route::patch('/promotionupdate', 'update')->name('promotions.update');
                        Route::get('editstatusdéactiveprm/{id}', 'editstatusdéactive')->name('editstatusdéactiveprm');
                        Route::get('editstatusactiveprm/{id}', 'editstatusactive')->name('editstatusactiveprm');
                        Route::delete('/deletepromotion', 'destroy')->name('promotion.destroy');
                        Route::get('/deleteall', 'deleteall')->name('promotions.deleteall');
                    });
                });

                Route::get('stock/editstocknoexist/{id}', [StockproductController::class, 'editstocknoexist'])->name('stock.editstocknoexist');
                Route::get('stock/editstockexist/{id}', [StockproductController::class, 'editstockexist'])->name('stock.editstockexist');

                Route::prefix('images')->group(function (){

                    Route::controller(MainimageproductController::class)->group(function() {
                        Route::post('/createmain', 'store')->name('imagemain.create');
                        Route::patch('/editmain', 'edit')->name('imagemain.edit');
                        Route::delete('/destroymain', 'destroy')->name('imagemain.destroy');
                    });

                    Route::controller(MultipimageController::class)->group(function() {
                        Route::get('/images/{id}', 'index')->name('image.index');
                        Route::post('/create', 'store')->name('image.create');
                        Route::patch('/edit', 'edit')->name('image.edit');
                        Route::delete('/destroy', 'destroy')->name('image.destroy');
                        Route::get('/deleteall', 'deleteall')->name('image.deleteall');
                    });
                });
            });
            Route::get('/section/{id}', [ProductController::class, 'getchild']);
        //############################# end Products route ######################################

        //############################# Clients route ##########################################
            Route::prefix('Clients')->group(function (){
                Route::resource('Clients', ClientController::class);
                Route::controller(ClientController::class)->group(function() {
                    Route::get('/createclient', 'createclient')->name('Clients.createclient');
                    Route::get('/Show_Invoice_Client/{id}', 'showinvoice')->name('Clients.showinvoice');
                    Route::get('/clientinvoice/{id}', 'clientinvoice')->name('Clients.clientinvoice');
                    Route::get('/Deleted_Product', 'softdelete')->name('Clients.softdelete');
                    Route::delete('/destroy_invoices_client', 'destroy_invoices_client')->name('Clients.destroy_invoices_client');
                    Route::get('editstatusdéactivecl/{id}', 'editstatusdéactive')->name('editstatusdéactivecl');
                    Route::get('editstatusactivecl/{id}', 'editstatusactive')->name('editstatusactivecl');
                    Route::get('/deleteall', 'deleteall')->name('Clients.deleteall');
                    Route::get('restorecl/{id}', 'restore')->name('restorecl');
                    Route::get('forcedeletecl/{id}', 'forcedelete')->name('forcedeletecl');
                });
            });
        //############################# end Clients route ######################################

        //############################# GroupProducts route ##########################################

            Route::view('Add_GroupProducts','livewire.GroupProducts.include_create')->name('Add_GroupProducts');

        //############################# end GroupProducts route ######################################

        //############################# single_invoices route ##########################################

            Route::view('single_invoices','livewire.single_invoices.index')->name('single_invoices');

            Route::view('Print_single_invoices','livewire.single_invoices.print')->name('Print_single_invoices');

        //############################# end single_invoices route ######################################

        //############################# group_invoices route ##########################################

            Route::view('group_invoices','livewire.Group_invoices.index')->name('group_invoices');

            Route::view('group_Print_single_invoices','livewire.Group_invoices.print')->name('group_Print_single_invoices');

        //############################# end group_invoices route ######################################

        //############################# Receipt route ##########################################

            Route::resource('Receipt', ReceiptAccountController::class);
            Route::get('/createrc/{id}', [ReceiptAccountController::class, 'create'])->name('Receipt.createrc');
            Route::post('/storerc', [ReceiptAccountController::class, 'store'])->name('Receipt.storerc');
            Route::get('/deleteallrc', [ReceiptAccountController::class, 'deleteall'])->name('Receipt.deleteallrc');
            Route::get('/Deleted_Receipt', [ReceiptAccountController::class, 'softdelete'])->name('Receipt.softdelete');
            Route::get('restorerc/{id}', [ReceiptAccountController::class, 'restore'])->name('restorerc');
            Route::get('forcedeleterc/{id}', [ReceiptAccountController::class, 'forcedelete'])->name('forcedeleterc');

        //############################# end Receipt route ######################################

        //############################# Payment route ##########################################

            Route::resource('Payment', PaymentaccountController::class);
            Route::get('/createpy/{id}', [PaymentaccountController::class, 'create'])->name('Payment.createpy');
            Route::post('/storepy', [PaymentaccountController::class, 'store'])->name('Payment.storepy');
            Route::get('/deleteallpy', [PaymentaccountController::class, 'deleteall'])->name('Payment.deleteallpy');
            Route::get('/Deleted_Payment', [PaymentaccountController::class, 'softdelete'])->name('Payment.softdelete');
            Route::get('restorepy/{id}', [PaymentaccountController::class, 'restore'])->name('restorepy');
            Route::get('forcedeletepy/{id}', [PaymentaccountController::class, 'forcedelete'])->name('forcedeletepy');

        //############################# end Payment route ######################################

        //############################# BankTransfer route ##########################################

            Route::resource('Banktransfer', BanktransferController::class);
            Route::get('/deleteallbt', [BanktransferController::class, 'deleteall'])->name('Banktransfer.deleteallbt');
            Route::get('/Deleted_Paymentbt', [BanktransferController::class, 'softdelete'])->name('Banktransfer.softdelete');
            Route::get('restorebt/{id}', [BanktransferController::class, 'restore'])->name('restorebt');
            Route::get('forcedeletebt/{id}', [BanktransferController::class, 'forcedelete'])->name('forcedeletebt');

        //############################# end BankTransfer route ######################################

        //############################# BankCard route ##########################################

            Route::resource('paymentgateway', PaymentgatewayController::class);
            Route::get('/deleteallpg', [PaymentgatewayController::class, 'deleteall'])->name('paymentgateway.deleteallpg');
            Route::get('/Deleted_Paymentpg', [PaymentgatewayController::class, 'softdelete'])->name('paymentgateway.softdelete');
            Route::get('restorepg/{id}', [PaymentgatewayController::class, 'restore'])->name('restorepg');
            Route::get('forcedeletepg/{id}', [PaymentgatewayController::class, 'forcedelete'])->name('forcedeletepg');

        //############################# end BankCard route ######################################

        //############################# SingleInvoices route ##########################################

                Route::group(['prefix' => 'GroupServices'], function(){
                    Route::controller(GroupproductController::class)->group(function() {
                        Route::get('/index', 'index')->name('GroupServices.index');
                        Route::get('/Show_Group_Services/{id}', 'show')->name('GroupServices.show');
                        Route::get('/Deleted_Group_Services', 'softdelete')->name('GroupServices.softdelete');
                        Route::delete('/destroysingleinvoice', 'destroy')->name('GroupServices.destroy');
                        Route::get('/deleteallsingleinvoice', 'deleteall')->name('GroupServices.deleteall');
                        Route::get('restoresingleinvoice/{id}', 'restore')->name('GroupServices.restore');
                    });
                });

        //############################# end SingleInvoices route ######################################

        //############################# SingleInvoices route ##########################################

            Route::group(['prefix' => 'SingleInvoices'], function(){
                Route::controller(InvoiceController::class)->group(function() {
                    Route::get('/indexsingleinvoice', 'indexsingleinvoice')->name('SingleInvoices.indexsingleinvoice');
                    Route::get('/Show_Invoice_Client/{id}', 'showinvoice')->name('SingleInvoices.showinvoice');
                    Route::get('/invoice_status/{id}', 'invoicestatus')->name('invoicestatus');
                    Route::get('/Deleted_Singleinvoice', 'softdeletesingleinvoice')->name('SingleInvoices.softdeletesingleinvoice');
                    Route::delete('/destroysingleinvoice', 'destroy')->name('SingleInvoices.destroy');
                    Route::get('/deleteallsingleinvoice', 'deleteallsingleinvoices')->name('SingleInvoices.deleteallsingleinvoice');
                    Route::get('restoresingleinvoice/{id}', 'restoresingleinvoice')->name('SingleInvoices.restoresingleinvoice');
                    Route::get('restoreallsingleinvoice', 'restoreallsingleinvoices')->name('SingleInvoices.restoreallsingleinvoice');
                    Route::post('restoreallselectsingleinvoice', 'restoreallselectsingleinvoices')->name('SingleInvoices.restoreallselectsingleinvoice');
                });
            });

        //############################# end SingleInvoices route ######################################

        //############################# SingleInvoices route ##########################################

        Route::group(['prefix' => 'GroupInvoices'], function(){
            Route::controller(InvoiceController::class)->group(function() {
                Route::get('/indexgroupInvoices', 'indexgroupInvoices')->name('GroupInvoices.indexgroupInvoices');
                Route::get('/Show_Invoice_Client/{id}', 'showinvoice')->name('GroupInvoices.showinvoice');
                Route::get('/invoice_status/{id}', 'invoicestatus')->name('invoicestatus');
                Route::get('/Deleted_ProductgroupInvoices', 'softdeletegroupInvoices')->name('GroupInvoices.softdeletegroupInvoices');
                Route::delete('/destroygroupInvoices', 'destroy')->name('GroupInvoices.destroy');
                Route::get('/deleteallgroupInvoices', 'deleteallgroupInvoices')->name('GroupInvoices.deleteallgroupInvoices');
                Route::get('restoregroupInvoices/{id}', 'restoregroupInvoice')->name('GroupInvoices.restoregroupInvoices');
                Route::get('restoreallgroupInvoices', 'restoreallgroupInvoices')->name('GroupInvoices.restoreallgroupInvoices');
                Route::post('restoreallselectgroupInvoices', 'restoreallselectgroupInvoices')->name('GroupInvoices.restoreallselectgroupInvoices');
            });
        });

    //############################# end SingleInvoices route ######################################

        // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        // Route::get('buy/{product_id}', [App\Http\Controllers\HomeController::class, 'buy'])->name('buy');
        // Route::post('confirm', [App\Http\Controllers\HomeController::class, 'confirm'])->name('confirm');
        // Route::get('checkout', [App\Http\Controllers\HomeController::class, 'checkout'])->name('checkout');
        // Route::post('pay', [App\Http\Controllers\HomeController::class, 'pay'])->name('pay');
        // Route::view('success', 'success')->name('success');

        // Route::stripeWebhooks('webhook');

    });
    require __DIR__.'/auth.php';
