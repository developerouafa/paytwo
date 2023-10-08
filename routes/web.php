<?php

use App\Http\Controllers\Dashboard\childrens\childrenController;
use App\Http\Controllers\Dashboard\Products\MainimageproductController;
use App\Http\Controllers\Dashboard\Products\MultipimageController;
use App\Http\Controllers\Dashboard\profiles\ProfileController;
use App\Http\Controllers\Dashboard\roles\RolesController;
use App\Http\Controllers\Dashboard\Sections\SectionController;
use App\Http\Controllers\Dashboard\Products\ProductController;
use App\Http\Controllers\Dashboard\users\UserController;
use App\Http\Controllers\ImageuserController;
use App\Http\Controllers\Dashboard\Products\PromotionController;
use App\Http\Controllers\Dashboard\Products\StockproductController;
use App\Models\multipimage;
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

        Route::resource('roles', RolesController::class);
        Route::resource('users', UserController::class);

        Route::group(['prefix' => 'Profile'], function(){
            Route::controller(ProfileController::class)->group(function() {
                Route::get('/profile', 'edit')->name('profile.edit');
                Route::patch('/profile', 'updateprofile')->name('profile.update');
            });
            Route::controller(ImageuserController::class)->group(function() {
                Route::post('/imageuser', 'store')->name('imageuser.store');
                Route::patch('/imageuser', 'update')->name('imageuser.update');
                Route::get('/imageuser', 'destroy')->name('imageuser.delete');
            });
        });

        Route::group(['prefix' => 'Sections'], function(){
            Route::controller(SectionController::class)->group(function() {
                Route::get('/index', 'index')->name('Sections.index');
                Route::post('/create', 'store')->name('Sections.store');
                Route::patch('/update', 'update')->name('Sections.update');
                Route::delete('/destroy', 'destroy')->name('Sections.destroy');
                Route::get('editstatusdéactive/{id}', 'editstatusdéactive')->name('editstatusdéactive');
                Route::get('editstatusactive/{id}', 'editstatusactive')->name('editstatusactive');
            });

            Route::controller(childrenController::class)->group(function() {
                Route::get('/child', 'index')->name('childcat_index');
                Route::post('/createchild', 'store')->name('childcat.create');
                Route::patch('/updatechild', 'update')->name('childcat.update');
                Route::delete('/deletechild', 'destroy')->name('childcat.delete');
            });
        });

        Route::group(['prefix' => 'Products'], function(){

            Route::controller(ProductController::class)->group(function() {
                Route::get('/index', 'index')->name('Products.index');
                Route::get('/create', 'create')->name('product.createprod');
                Route::post('/store', 'store')->name('product.store');
                Route::get('editstatusdéactive/{id}', 'editstatusdéactive')->name('editstatusdéactive');
                Route::get('editstatusactive/{id}', 'editstatusactive')->name('editstatusactive');
                Route::patch('/update', 'update')->name('product.update');
                Route::delete('/destroy', 'destroy')->name('product.destroy');
            });

            Route::prefix('promotions')->group(function (){
                Route::controller(PromotionController::class)->group(function() {
                    Route::get('/promotions/{id}', 'index');
                    Route::post('/createpromotion', 'store')->name('promotions.create');
                    Route::patch('/promotionupdate', 'update')->name('promotions.update');
                    Route::get('/promotions/editstatusdéactive/{id}', 'editstatusdéactive')->name('promotions.editstatusdéactive');
                    Route::get('/promotions/editstatusactive/{id}', 'editstatusactive')->name('promotions.editstatusactive');
                    Route::delete('/deletepromotion', 'destroy')->name('promotion.destroy');
                });
            });

            Route::get('stock/editstocknoexist/{id}', [StockproductController::class, 'editstocknoexist'])->name('stock.editstocknoexist');
            Route::get('stock/editstockexist/{id}', [StockproductController::class, 'editstockexist'])->name('stock.editstockexist');

            Route::prefix('images')->group(function (){
                Route::controller(MainimageproductController::class)->group(function() {
                    // Route::get('/images/{id}','index');
                    // Route::post('/createimage','store')->name('image.create');
                    // Route::patch('/imageuser','edit')->name('image.edit');
                    // Route::delete('/deleteimage','delete')->name('image.delete');
                });

                Route::controller(MultipimageController::class)->group(function() {
                    Route::get('/images/{id}','index');
                    Route::post('/createimage','store')->name('image.create');
                    Route::patch('/imageuser','edit')->name('image.edit');
                    Route::delete('/deleteimage','delete')->name('image.delete');
                });
            });

        });
        Route::get('/section/{id}', [ProductController::class, 'getchild']);

    });
    require __DIR__.'/auth.php';
