<?php

use App\Events\MyEvent;
use App\Http\Controllers\Dashboard\dashboard_users\Clients\ClientController;
use App\Http\Controllers\Dashboard\dashboard_users\childrens\childrenController;
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
            // event(new MyEvent('hello world'));
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
                    Route::get('forcedeletesc/{id}', 'forcedelete')->name('forcedeletesc');
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
                    Route::get('restorech/{id}', 'restore')->name('restorech');
                    Route::get('forcedeletech/{id}', 'forcedelete')->name('forcedeletech');
                });
            });
        //############################# end Section & Children Section route ######################################

        //############################# Products route ##########################################
            Route::group(['prefix' => 'Products'], function(){
                Route::controller(ProductController::class)->group(function() {
                    Route::get('/index', 'index')->name('Products.index');
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
                    Route::get('editstatusdéactivecl/{id}', 'editstatusdéactive')->name('editstatusdéactivecl');
                    Route::get('editstatusactivecl/{id}', 'editstatusactive')->name('editstatusactivecl');
                    Route::get('/deleteall', 'deleteall')->name('Clients.deleteall');
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
            Route::get('/deleteallrc', [ReceiptAccountController::class, 'deleteall'])->name('Receipt.deleteallrc');

        //############################# end Receipt route ######################################

        //############################# Payment route ##########################################

            Route::resource('Payment', PaymentaccountController::class);
            Route::get('/deleteallpy', [PaymentaccountController::class, 'deleteall'])->name('Payment.deleteallpy');

        //############################# end Payment route ######################################

    });
    require __DIR__.'/auth.php';
