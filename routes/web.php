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
use App\Models\client_account;
use App\Models\invoice;
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
    // Clear Code
    Route::get('/clear', function() {
        Artisan::call('cache:clear');
        Artisan::call('config:clear');
        Artisan::call('config:cache');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        return redirect()->back();
    });

//* To access these pages, you must log in first
    Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'auth', 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath', 'xss', 'UserStatus']], function(){

        Route::get('/', function () {
            //* Start line chart
                $linechart = app()->chartjs
                ->name('linechart')
                ->type('line')
                ->size(['width' => 1000, 'height' => 400])
                ->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'])
                ->datasets([
                    [
                        "label" => "A",
                        'borderColor' => "#f7557a",
                        "borderWidth" => "1",
                        "fill"=> false,
                        'data' => [12, 15, 18, 40, 35, 38, 32, 20, 25, 15, 25, 30],
                    ],
                    [
                        "label" => "B",
                        'borderColor' => "#007bff",
                        "borderWidth" => "1",
                        "fill"=> false,
                        'data' => [10, 20, 25, 55, 50, 45, 35, 30, 45, 35, 55, 40],
                    ]
                ])
                ->options([
                    'maintainAspectRatio' => false,
                    'scales' => [
                        'yAxes' => [[
                            'ticks' => [
                                'beginAtZero' => true,
                                'fontSize' => 10,
                                'max' => 80,
                                'fontColor' => "rgb(171, 167, 167,0.9)",
                            ],
                            'gridLines' => [
                                'display' => true,
                                'color' => 'rgba(171, 167, 167,0.2)',
                                'drawBorder' => false
                            ],
                        ]],
                        'xAxes' => [[
                            'ticks' => [
                                'beginAtZero' => true,
                                'fontSize' => 11,
                                'fontColor' => "rgb(171, 167, 167,0.9)",
                            ],
                            'gridLines' => [
                                'display' => true,
                                'color' => 'rgba(171, 167, 167,0.2)',
                                'drawBorder' => false
                            ],
                        ]]
                    ]
                ]);
            //* End line chart

            //* Start chartBar1

            // start type 1
                    $sum11 = 0;
                    $sum12 = 0;
                    $sum13 = 0;
                    $sum14 = 0;
                    $sum15 = 0;
                    $sum16 = 0;
                    $sum17 = 0;
                    $sum18 = 0;
                    $sum19 = 0;
                    $sum110 = 0;
                    $sum111 = 0;
                    $sum112 = 0;
                $invoices1 = invoice::where('type', 1)->get();
                foreach($invoices1 as $invoice){
                    $clients_account1 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '1')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account1 as $client_account){
                        $sum11 += $client_account->credit;
                    }
                }
                $invoices2 = invoice::where('type', 1)->get();
                foreach($invoices2 as $invoice){
                    $clients_account2 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '2')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account2 as $client_account){
                        $sum12 += $client_account->credit;
                    }
                }
                $invoices3 = invoice::where('type', 1)->get();
                foreach($invoices3 as $invoice){
                    $clients_account3 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '3')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account3 as $client_account){
                        $sum13 += $client_account->credit;
                    }
                }
                $invoices4 = invoice::where('type', 1)->get();
                foreach($invoices4 as $invoice){
                    $clients_account4 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '4')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account4 as $client_account){
                        $sum14 += $client_account->credit;
                    }
                }
                $invoices5 = invoice::where('type', 1)->get();
                foreach($invoices5 as $invoice){
                    $clients_account5 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '5')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account5 as $client_account){
                        $sum15 += $client_account->credit;
                    }
                }
                $invoices6 = invoice::where('type', 1)->get();
                foreach($invoices6 as $invoice){
                    $clients_account6 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '6')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account6 as $client_account){
                        $sum16 += $client_account->credit;
                    }
                }
                $invoices7 = invoice::where('type', 1)->get();
                foreach($invoices7 as $invoice){
                    $clients_account7 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '7')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account7 as $client_account){
                        $sum17 += $client_account->credit;
                    }
                }
                $invoices8 = invoice::where('type', 1)->get();
                foreach($invoices8 as $invoice){
                    $clients_account8 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '8')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account8 as $client_account){
                        $sum18 += $client_account->credit;
                    }
                }
                $invoices9 = invoice::where('type', 1)->get();
                foreach($invoices9 as $invoice){
                    $clients_account9 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '9')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account9 as $client_account){
                        $sum19 += $client_account->credit;
                    }
                }
                $invoices10 = invoice::where('type', 1)->get();
                foreach($invoices10 as $invoice){
                    $clients_account10 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '10')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account10 as $client_account){
                        $sum110 += $client_account->credit;
                    }
                }
                $invoices11 = invoice::where('type', 1)->get();
                foreach($invoices11 as $invoice){
                    $clients_account11 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '11')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account11 as $client_account){
                        $sum111 += $client_account->credit;
                    }
                }
                $invoices12 = invoice::where('type', 1)->get();
                foreach($invoices12 as $invoice){
                    $clients_account12 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '12')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account12 as $client_account){
                        $sum112 += $client_account->credit;
                    }
                }
            // End type 1

            // start type 2
                $sum21 = 0;
                $sum22 = 0;
                $sum23 = 0;
                $sum24 = 0;
                $sum25 = 0;
                $sum26 = 0;
                $sum27 = 0;
                $sum28 = 0;
                $sum29 = 0;
                $sum210 = 0;
                $sum211 = 0;
                $sum212 = 0;

                $invoices1 = invoice::where('type', 2)->get();
                foreach($invoices1 as $invoice){
                    $clients_account1 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '1')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account1 as $client_account){
                        $sum21 += $client_account->credit;
                    }
                }
                $invoices2 = invoice::where('type', 2)->get();
                foreach($invoices2 as $invoice){
                    $clients_account2 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '2')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account2 as $client_account){
                        $sum22 += $client_account->credit;
                    }
                }
                $invoices3 = invoice::where('type', 2)->get();
                foreach($invoices3 as $invoice){
                    $clients_account3 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '3')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account3 as $client_account){
                        $sum23 += $client_account->credit;
                    }
                }
                $invoices4 = invoice::where('type', 2)->get();
                foreach($invoices4 as $invoice){
                    $clients_account4 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '4')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account4 as $client_account){
                        $sum24 += $client_account->credit;
                    }
                }
                $invoices5 = invoice::where('type', 2)->get();
                foreach($invoices5 as $invoice){
                    $clients_account5 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '5')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account5 as $client_account){
                        $sum25 += $client_account->credit;
                    }
                }
                $invoices6 = invoice::where('type', 2)->get();
                foreach($invoices6 as $invoice){
                    $clients_account6 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '6')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account6 as $client_account){
                        $sum26 += $client_account->credit;
                    }
                }
                $invoices7 = invoice::where('type', 2)->get();
                foreach($invoices7 as $invoice){
                    $clients_account7 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '7')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account7 as $client_account){
                        $sum27 += $client_account->credit;
                    }
                }
                $invoices8 = invoice::where('type', 2)->get();
                foreach($invoices8 as $invoice){
                    $clients_account8 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '8')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account8 as $client_account){
                        $sum28 += $client_account->credit;
                    }
                }
                $invoices9 = invoice::where('type', 2)->get();
                foreach($invoices9 as $invoice){
                    $clients_account9 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '9')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account9 as $client_account){
                        $sum29 += $client_account->credit;
                    }
                }
                $invoices210 = invoice::where('type', 2)->get();
                foreach($invoices210 as $invoice){
                    $clients_account210 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '10')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account210 as $client_account){
                        $sum210 += $client_account->credit;
                    }
                }
                $invoices211 = invoice::where('type', 2)->get();
                foreach($invoices211 as $invoice){
                    $clients_account211 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '11')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account211 as $client_account){
                        $sum211 += $client_account->credit;
                    }
                }
                $invoices212 = invoice::where('type', 2)->get();
                foreach($invoices212 as $invoice){
                    $clients_account212 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '12')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account212 as $client_account){
                        $sum212 += $client_account->credit;
                    }
                }
            // end type 2

            // start type 3
                $sum31 = 0;
                $sum32 = 0;
                $sum33 = 0;
                $sum34 = 0;
                $sum35 = 0;
                $sum36 = 0;
                $sum37 = 0;
                $sum38 = 0;
                $sum39 = 0;
                $sum310 = 0;
                $sum311 = 0;
                $sum312 = 0;

                $invoices31 = invoice::where('type', 3)->get();
                foreach($invoices31 as $invoice){
                    $clients_account31 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '1')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account31 as $client_account){
                        $sum31 += $client_account->credit;
                    }
                }
                $invoices32 = invoice::where('type', 3)->get();
                foreach($invoices32 as $invoice){
                    $clients_account2 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '2')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account32 as $client_account){
                        $sum32 += $client_account->credit;
                    }
                }
                $invoices33 = invoice::where('type', 3)->get();
                foreach($invoices33 as $invoice){
                    $clients_account33 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '3')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account33 as $client_account){
                        $sum33 += $client_account->credit;
                    }
                }
                $invoices34 = invoice::where('type', 3)->get();
                foreach($invoices34 as $invoice){
                    $clients_account34 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '4')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account34 as $client_account){
                        $sum34 += $client_account->credit;
                    }
                }
                $invoices35 = invoice::where('type', 3)->get();
                foreach($invoices35 as $invoice){
                    $clients_account35 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '5')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account35 as $client_account){
                        $sum35 += $client_account->credit;
                    }
                }
                $invoices36 = invoice::where('type', 3)->get();
                foreach($invoices36 as $invoice){
                    $clients_account36 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '6')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account36 as $client_account){
                        $sum36 += $client_account->credit;
                    }
                }
                $invoices37 = invoice::where('type', 3)->get();
                foreach($invoices37 as $invoice){
                    $clients_account37 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '7')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account37 as $client_account){
                        $sum37 += $client_account->credit;
                    }
                }
                $invoices38 = invoice::where('type', 3)->get();
                foreach($invoices38 as $invoice){
                    $clients_account38 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '8')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account38 as $client_account){
                        $sum38 += $client_account->credit;
                    }
                }
                $invoices39 = invoice::where('type', 3)->get();
                foreach($invoices39 as $invoice){
                    $clients_account39 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '9')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account39 as $client_account){
                        $sum39 += $client_account->credit;
                    }
                }
                $invoices310 = invoice::where('type', 3)->get();
                foreach($invoices310 as $invoice){
                    $clients_account310 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '10')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account310 as $client_account){
                        $sum310 += $client_account->credit;
                    }
                }
                $invoices311 = invoice::where('type', 3)->get();
                foreach($invoices311 as $invoice){
                    $clients_account311 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '11')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account311 as $client_account){
                        $sum311 += $client_account->credit;
                    }
                }
                $invoices312 = invoice::where('type', 3)->get();
                foreach($invoices312 as $invoice){
                    $clients_account312 = client_account::whereYear('created_at', now()->format('Y'))->whereMonth('created_at', '=', '12')->where('invoice_id', $invoice->id)->get();
                    foreach($clients_account312 as $client_account){
                        $sum312 += $client_account->credit;
                    }
                }
            // end type 2

                $chartBar1 = app()->chartjs
                ->name('chartBar1')
                ->type('bar')
                ->size(['width' => 1000, 'height' => 400])
                ->labels(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'])
                ->datasets([
                    'backgroundColor' => "#285cf7",
                    'data' => [

                    ],
                ])
                ->options([
                    'maintainAspectRatio' => false,
                    'legend' => [
                        'display' => false,
                        'labels' => [
                            'display' => false
                        ]
                    ],
                    'responsive' => true,
                    'scales' => [
                        'yAxes' => [[
                            'ticks' => [
                                'beginAtZero' => true,
                                'fontSize' => 10,
                                'fontColor' => "rgb(171, 167, 167,0.9)",
                            ],
                            'gridLines' => [
                                'display' => true,
                                'color' => 'rgba(171, 167, 167,0.2)',
                                'drawBorder' => false
                            ],
                        ]],
                        'xAxes' => [[
					        'barPercentage' => 0.6,
                            'ticks' => [
                                'beginAtZero' => true,
                                'fontSize' => 11,
                                'fontColor' => "rgb(171, 167, 167,0.9)",
                            ],
                            'gridLines' => [
                                'display' => true,
                                'color' => 'rgba(171, 167, 167,0.2)',
                                'drawBorder' => false
                            ],
                        ]]
                    ]
                ]);
            //* End chartBar1

            return view('Dashboard/index', ['linechart' => $linechart, 'chartBar1' => $chartBar1]);
        })->name('dashboard');

        //############################# Start Partie User|permissions|Roles route ##########################################
            Route::resource('users', UserController::class);
            Route::resource('roles', RolesController::class);
            Route::controller(UserController::class)->group(function() {
                Route::get('editstatusdéactiveuser/{id}', 'editstatusdéactive')->name('editstatusdéactiveuser');
                Route::get('editstatusactiveuser/{id}', 'editstatusactive')->name('editstatusactiveuser');
                Route::get('/clienttouser/{id}', 'clienttouser')->name('clienttouser');
                Route::get('/clienttouserinvoice/{id}', 'clienttouserinvoice')->name('clienttouserinvoice');
                Route::patch('/confirmpayment', 'confirmpayment')->name('Invoice.confirmpayment');
                Route::patch('/refusedpayment', 'refusedpayment')->name('Invoice.refusedpayment');
                Route::get('/Deleted_Users', 'softusers')->name('Users.softdeleteusers');
                Route::get('/deleteallusers', 'deleteallusers')->name('Users.deleteallusers');
                Route::get('/deleteallusers_softdelete', 'deletealluserssoftdelete')->name('Users.deletealluserssoftdelete');
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
                    Route::get('/deleteallSections', 'deleteall')->name('Sections.deleteallSections');
                    Route::get('/deleteall_softdelete', 'deleteallsoftdelete')->name('Sections.deleteallsoftdelete');
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
                    Route::get('/deleteallChildrens', 'deleteall')->name('Children.deleteallChildrens');
                    Route::get('/deleteallsoftdelete', 'deleteallsoftdelete')->name('Children.deleteallsoftdelete');
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
                    Route::get('/deleteallproducts', 'deleteall')->name('product.deleteallproducts');
                    Route::get('/deleteallsoftdelete', 'deleteallsoftdelete')->name('product.deleteallsoftdelete');
                    Route::get('restorepr/{id}', 'restore')->name('restorepr');
                    Route::get('restoreallproducts', 'restoreallproducts')->name('product.restoreallproducts');
                    Route::post('restoreallselectproducts', 'restoreallselectproducts')->name('product.restoreallselectproducts');
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
                    Route::delete('/destroy', 'destroy')->name('Clients.destroy');
                    Route::get('editstatusdéactivecl/{id}', 'editstatusdéactive')->name('editstatusdéactivecl');
                    Route::get('editstatusactivecl/{id}', 'editstatusactive')->name('editstatusactivecl');
                    Route::get('/deleteallclients', 'deleteall')->name('Clients.deleteallclients');
                    Route::get('/deleteallsoftdelete', 'deleteallsoftdelete')->name('Clients.deleteallsoftdelete');
                    Route::get('restorecl/{id}', 'restore')->name('restorecl');
                    Route::get('restoreallclients', 'restoreallclients')->name('Clients.restoreallclients');
                    Route::post('restoreallselectclients', 'restoreallselectclients')->name('Clients.restoreallselectclients');
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
            Route::delete('/destroy', [ReceiptAccountController::class, 'destroy'])->name('Receipt.destroy');
            Route::get('/Deleted_Receipt', [ReceiptAccountController::class, 'softdelete'])->name('Receipt.softdelete');
            Route::get('/deleteallrc', [ReceiptAccountController::class, 'deleteall'])->name('Receipt.deleteallrc');
            Route::get('/deleteallsoftdelete', [ReceiptAccountController::class, 'deleteallsoftdelete'])->name('Receipt.deleteallsoftdelete');
            Route::get('restorerc/{id}', [ReceiptAccountController::class, 'restore'])->name('restorerc');
            Route::get('restoreallReceiptAccount', [ReceiptAccountController::class, 'restoreallReceiptAccount'])->name('Receipt.restoreallReceiptAccount');
            Route::post('restoreallselectReceiptAccount', [ReceiptAccountController::class, 'restoreallselectReceiptAccount'])->name('Receipt.restoreallselectReceiptAccount');

        //############################# end Receipt route ######################################

        //############################# Payment route ##########################################

            Route::resource('Payment', PaymentaccountController::class);
            Route::get('/createpy/{id}', [PaymentaccountController::class, 'create'])->name('Payment.createpy');
            Route::post('/storepy', [PaymentaccountController::class, 'store'])->name('Payment.storepy');
            Route::delete('/destroy', [PaymentaccountController::class, 'destroy'])->name('Payment.destroy');
            Route::get('/Deleted_Payment', [PaymentaccountController::class, 'softdelete'])->name('Payment.softdelete');
            Route::get('/deleteallpy', [PaymentaccountController::class, 'deleteall'])->name('Payment.deleteallpy');
            Route::get('/deleteallsoftdelete', [PaymentaccountController::class, 'deleteallsoftdelete'])->name('Payment.deleteallsoftdelete');
            Route::get('restorepy/{id}', [PaymentaccountController::class, 'restore'])->name('restorepy');
            Route::get('restoreallPaymentaccount', [PaymentaccountController::class, 'restoreallPaymentaccount'])->name('Payment.restoreallPaymentaccount');
            Route::post('restoreallselectPaymentaccount', [PaymentaccountController::class, 'restoreallselectPaymentaccount'])->name('Payment.restoreallselectPaymentaccount');

        //############################# end Payment route ######################################

        //############################# BankTransfer route ##########################################

            Route::resource('Banktransfer', BanktransferController::class);
            Route::delete('/destroy', [BanktransferController::class, 'destroy'])->name('Banktransfer.destroybt');
            Route::get('/Deleted_Paymentbt', [BanktransferController::class, 'softdelete'])->name('Banktransfer.softdelete');
            Route::get('/deleteallbt', [BanktransferController::class, 'deleteall'])->name('Banktransfer.deleteallbt');
            Route::get('/deleteallsoftdelete', [BanktransferController::class, 'deleteallsoftdelete'])->name('Banktransfer.deleteallsoftdelete');
            Route::get('restorebt/{id}', [BanktransferController::class, 'restore'])->name('restorebt');
            Route::get('restoreallBanktransfer', [BanktransferController::class, 'restoreallBanktransfer'])->name('Banktransfer.restoreallBanktransfer');
            Route::post('restoreallselectBanktransfer', [BanktransferController::class, 'restoreallselectBanktransfer'])->name('Banktransfer.restoreallselectBanktransfer');

        //############################# end BankTransfer route ######################################

        //############################# BankCard route ##########################################

            Route::resource('paymentgateway', PaymentgatewayController::class);
            Route::delete('/destroy', [PaymentgatewayController::class, 'destroy'])->name('paymentgateway.destroypg');
            Route::get('/Deleted_Paymentpg', [PaymentgatewayController::class, 'softdelete'])->name('paymentgateway.softdelete');
            Route::get('/deleteallpg', [PaymentgatewayController::class, 'deleteall'])->name('paymentgateway.deleteallpg');
            Route::get('/deleteallsoftdelete', [PaymentgatewayController::class, 'deleteallsoftdelete'])->name('paymentgateway.deleteallsoftdelete');
            Route::get('restorepg/{id}', [PaymentgatewayController::class, 'restore'])->name('restorepg');
            Route::get('restoreallPaymentgateway', [PaymentgatewayController::class, 'restoreallPaymentgateway'])->name('paymentgateway.restoreallPaymentgateway');
            Route::post('restoreallselectPaymentgateway', [PaymentgatewayController::class, 'restoreallselectPaymentgateway'])->name('paymentgateway.restoreallselectPaymentgateway');

        //############################# end BankCard route ######################################

        //############################# GroupServices route ##########################################

            Route::group(['prefix' => 'GroupServices'], function(){
                Route::controller(GroupproductController::class)->group(function() {
                    Route::get('/index', 'index')->name('GroupServices.index');
                    Route::get('/Show_Group_Services/{id}', 'show')->name('GroupServices.show');
                    Route::get('/Deleted_Group_Services', 'softdelete')->name('GroupServices.softdelete');
                    Route::delete('/destroyGroupServices', 'destroy')->name('GroupServices.destroy');
                    Route::get('/deleteallGroupServices', 'deleteall')->name('GroupServices.deleteall');
                    Route::get('/deleteallsoftdelete', 'deleteallsoftdelete')->name('Children.deleteallsoftdelete');
                    Route::get('restoreGroupServices/{id}', 'restore')->name('GroupServices.restore');
                    Route::get('restoreallGroupServices', 'restoreallGroupServices')->name('GroupServices.restoreallGroupServices');
                    Route::post('restoreallselectGroupServices', 'restoreallselectGroupServices')->name('GroupServices.restoreallselectGroupServices');
                });
            });

        //############################# end GroupServices route ######################################

        //############################# SingleInvoices route ##########################################

            Route::group(['prefix' => 'SingleInvoices'], function(){
                Route::controller(InvoiceController::class)->group(function() {
                    Route::get('/indexsingleinvoice', 'indexsingleinvoice')->name('SingleInvoices.indexsingleinvoice');
                    Route::get('/Show_Invoice_Client/{id}', 'showinvoice')->name('SingleInvoices.showinvoice');
                    Route::get('/invoice_status/{id}', 'invoicestatus')->name('invoicestatus');
                    Route::get('/Deleted_Singleinvoice', 'softdeletesingleinvoice')->name('SingleInvoices.softdeletesingleinvoice');
                    Route::delete('/destroysingleinvoice', 'destroy')->name('SingleInvoices.destroy');
                    Route::get('/deleteallsingleinvoice', 'deleteallsingleinvoices')->name('SingleInvoices.deleteallsingleinvoice');
                    Route::get('/deleteallsoftdelete', 'deleteallsoftdelete')->name('SingleInvoices.deleteallsoftdelete');
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
                    Route::get('/deleteallsoftdeletegr', 'deleteallsoftdeletegr')->name('GroupInvoices.deleteallsoftdeletegr');
                    Route::get('restoregroupInvoices/{id}', 'restoregroupInvoice')->name('GroupInvoices.restoregroupInvoices');
                    Route::get('restoreallgroupInvoices', 'restoreallgroupInvoices')->name('GroupInvoices.restoreallgroupInvoices');
                    Route::post('restoreallselectgroupInvoices', 'restoreallselectgroupInvoices')->name('GroupInvoices.restoreallselectgroupInvoices');
                });
            });
        //############################# end SingleInvoices route ######################################

    });
    require __DIR__.'/auth.php';
