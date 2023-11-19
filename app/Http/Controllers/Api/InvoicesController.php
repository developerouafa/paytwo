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

    public function InvoicesSent(){
        $invoices = invoice::latest()->where('type', '0')->whereNot('invoice_status', '1')->where('client_id', Auth::user()->id)->get();
        $invoicesmonetary = invoice::latest()->where('type', '1')->whereNot('invoice_status', '1')->where('client_id', Auth::user()->id)->get();
        $fund_accountreceipt = fund_account::whereNotNull('receipt_id')->with('invoice')->with('receiptaccount')->first();
        $invoicespostpaid = invoice::latest()->where('type', '2')->whereNot('invoice_status', '1')->where('client_id', Auth::user()->id)->get();
        $fund_accountpostpaid = fund_account::whereNotNull('Payment_id')->with('invoice')->with('paymentaccount')->first();
        $invoicesbanktransfer = invoice::latest()->where('type', '3')->whereNot('invoice_status', '1')->where('client_id', Auth::user()->id)->get();
        $invoicescard = invoice::latest()->where('type', '4')->whereNot('invoice_status', '1')->where('client_id', Auth::user()->id)->get();

        return $this->returnMultipData('invoices', $invoices, 'invoicesmonetary', $invoicesmonetary, 'fund_accountreceipt', $fund_accountreceipt, 'invoicespostpaid', $invoicespostpaid, 'fund_accountpostpaid', $fund_accountpostpaid, 'invoicesbanktransfer', $invoicesbanktransfer, 'invoicescard', $invoicescard);

    }

    public function showinvoicereceipt($id){
        $fund_accounts = fund_account::whereNotNull('receipt_id')->where('invoice_id', $id)->with('invoice')->with('receiptaccount')->get();
        return $this->returnData('fund_accounts', $fund_accounts);
    }

    public function showinvoicereceiptPostpaid($id){
        $fund_accounts = fund_account::whereNotNull('Payment_id')->where('invoice_id', $id)->with('invoice')->with('paymentaccount')->get();
        return $this->returnData('fund_accounts', $fund_accounts);
    }

    public function showinvoice($id)
    {
        $invoice = invoice::where('id', $id)->where('client_id', Auth::user()->id)->first();
        return $this->returnData('invoice', $invoice);
    }
}
