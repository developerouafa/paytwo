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

    public function checkout($request)
    {
        $invoice = invoice::where('client_id', auth()->id())->where('id', $request->invoice_id)->latest()->firstOrFail();

        $paymentIntent = auth()->user()->createSetupIntent();

        return view('Dashboard.dashboard_client/invoices/checkout', compact('invoice', 'paymentIntent'));
    }

    public function pay($request)
    {
        $invoice = invoice::where('client_id', auth()->id())->findOrFail($request->input('invoice_id'));
        // return $invoice;
        $user = auth()->user();

        $paymentMethod = $request->input('payment_method');
        try {
            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);
            $user->invoiceFor($invoice->invoice_number, $invoice->price);
        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage());
        }

        return redirect()->route('success');
    }
}
