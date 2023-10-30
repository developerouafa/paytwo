<?php
namespace App\Repository\Clients\Invoices;

use App\Interfaces\Clients\Invoices\InvoiceRepositoryInterface;
use App\Models\Client;
use App\Models\invoice;
use App\Models\order;
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

    public function confirm($request)
    {
        $invoice = invoice::findOrFail($request->input('invoice_id'));

        $client = Client::findOrFail(Auth::user()->id);
        $client->orders()->create([
            'invoice_id' => $invoice->id,
            'price' => $invoice->price
        ]);
        return redirect()->route('Invoices.checkout');
    }

    public function checkout()
    {
        $order = order::with('invoice')
        ->where('client_id', auth()->id())
        ->whereNull('paid_at')
        ->latest()
        ->firstOrFail();

        $paymentIntent = auth()->user()->createSetupIntent();

        return view('Dashboard.dashboard_client/invoices/checkout', compact('order', 'paymentIntent'));
    }

    public function pay($request)
    {
        $order = Order::where('client_id', auth()->id())->findOrFail($request->input('order_id'));
        $client = auth()->user();
        $paymentMethod = $request->input('payment_method');
        try {
            $client->createOrGetStripeCustomer();
            $client->updateDefaultPaymentMethod($paymentMethod);
            $client->invoiceFor($order->invoice->invoice_number, $order->price);
        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage());
        }
        return redirect()->route('Invoices.success');
    }
}
