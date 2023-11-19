<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\fund_account;
use App\Models\invoice;
use App\Traits\GeneralTraitt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoicesController extends Controller
{
    use GeneralTraitt;

    public function index(){
        // $invoices = invoice::latest()->where('type', '0')->whereNot('invoice_status', '1')->where('client_id', Auth::user()->id)->get();
        // $invoicesmonetary = invoice::latest()->where('type', '1')->whereNot('invoice_status', '1')->where('client_id', Auth::user()->id)->get();
        // $fund_accountreceipt = fund_account::whereNotNull('receipt_id')->with('invoice')->with('receiptaccount')->first();
        // return view('Dashboard.dashboard_client.invoices.invoices', ['invoices' => $invoices, 'invoicesmonetary' => $invoicesmonetary, 'fund_accountreceipt' => $fund_accountreceipt]);
    }

}
