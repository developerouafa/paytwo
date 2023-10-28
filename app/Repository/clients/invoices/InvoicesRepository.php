<?php
namespace App\Repository\Clients\Invoices;

use App\Interfaces\Clients\Invoices\InvoiceRepositoryInterface;
use App\Models\invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoicesRepository implements InvoiceRepositoryInterface
{
    public function indexmonetary(){
        $invoices = invoice::latest()->where('type', '1')->where('client_id', Auth::user()->id)->get();
        return view('Dashboard.dashboard_client.invoices.invoicesmonetary', ['invoices' => $invoices]);
    }

    public function indexPostpaid(){
        $invoices = invoice::latest()->where('type', '2')->where('client_id', Auth::user()->id)->get();
        return view('Dashboard.dashboard_client.invoices.invoicesPostpaid', ['invoices' => $invoices]);
    }

    public function indexBanktransfer(){
        $invoices = invoice::latest()->where('type', '3')->where('client_id', Auth::user()->id)->get();
        return view('Dashboard.dashboard_client.invoices.invoicesBanktransfer', ['invoices' => $invoices]);
    }

    public function showinvoicemonetary($id)
    {
        $invoice = invoice::latest()->where('type', '1')->where('id', $id)->where('client_id', Auth::user()->id)->first();
        $getID = DB::table('notifications')->where('data->invoice_id', $id)->pluck('id');
        DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
        return view('Dashboard.dashboard_client.invoices.showinvoicemonetary', ['invoice' => $invoice]);
    }

    public function showinvoicePostpaid($id)
    {
        $invoice = invoice::latest()->where('type', '2')->where('id', $id)->where('client_id', Auth::user()->id)->first();
        $getID = DB::table('notifications')->where('data->invoice_id', $id)->pluck('id');
        DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
        return view('Dashboard.dashboard_client.invoices.showinvoicePostpaid', ['invoice' => $invoice]);
    }

    public function showinvoiceBanktransfer($id)
    {
        $invoice = invoice::latest()->where('type', '3')->where('id', $id)->where('client_id', Auth::user()->id)->first();
        $getID = DB::table('notifications')->where('data->invoice_id', $id)->pluck('id');
        DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
        return view('Dashboard.dashboard_client.invoices.showinvoiceBanktransfer', ['invoice' => $invoice]);
    }
}
