<?php

use App\Http\Controllers\Dashboard\roles\RolesController;
use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\Dashboard\users\UserController;
use App\Http\Controllers\ProfileController;
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
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'auth', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'xss', 'UserStatus']], function(){

    Route::get('/', function () {
        return view('Dashboard/index');
    });

    Route::get('/dashboard', function () {
        return view('Dashboard/index');
    })->name('dashboard');

    Route::resource('roles', RolesController::class);
    Route::resource('users', UserController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('Sections', SectionController::class);

});
require __DIR__.'/auth.php';
