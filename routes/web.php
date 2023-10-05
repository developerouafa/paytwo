<?php

use App\Http\Controllers\Dashboard\childrens\childrenController;
use App\Http\Controllers\Dashboard\profiles\ProfileController;
use App\Http\Controllers\Dashboard\roles\RolesController;
use App\Http\Controllers\Dashboard\Sections\SectionController;
use App\Http\Controllers\Dashboard\users\UserController;
use App\Http\Controllers\ImageuserController;
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
                Route::delete('/deletechild', 'delete')->name('childcat.delete');
            });
        });

    });
    require __DIR__.'/auth.php';
