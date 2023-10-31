<?php
namespace App\Repository\Clients\Invoices;

use App\Interfaces\Clients\Invoices\InvoiceRepositoryInterface;
use App\Models\Client;
use App\Models\fund_account;
use App\Models\invoice;
use App\Models\order;
use App\Models\paymentaccount;
use App\Models\receipt_account;
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

    public function indexcard(){
        $invoices = invoice::latest()->where('type', '3')->where('client_id', Auth::user()->id)->get();
        return view('Dashboard.dashboard_client.invoices.invoicescard', ['invoices' => $invoices]);
    }

    public function indexbanktransfer(){
        $invoices = invoice::latest()->where('type', '4')->where('client_id', Auth::user()->id)->get();
        return view('Dashboard.dashboard_client.invoices.invoicebanktransfer', ['invoices' => $invoices]);
    }

    public function showinvoicemonetarynt($id)
    {
        $invoice = invoice::latest()->where('type', '1')->where('id', $id)->where('client_id', Auth::user()->id)->first();
        $getID = DB::table('notifications')->where('data->invoice_id', $id)->pluck('id');
        DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
        return view('Dashboard.dashboard_client.invoices.showinvoicemonetary', ['invoice' => $invoice]);
    }

    public function showinvoicebanktransfernt($id)
    {
        $invoice = invoice::latest()->where('type', '4')->where('id', $id)->where('client_id', Auth::user()->id)->first();
        $getID = DB::table('notifications')->where('data->invoice_id', $id)->pluck('id');
        DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
        return view('Dashboard.dashboard_client.invoices.showinvoicebanktransfer', ['invoice' => $invoice]);
    }

    public function showinvoicePostpaidnt($id)
    {
        $invoice = invoice::latest()->where('type', '2')->where('id', $id)->where('client_id', Auth::user()->id)->first();
        $getID = DB::table('notifications')->where('data->invoice_id', $id)->pluck('id');
        DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
        return view('Dashboard.dashboard_client.invoices.showinvoicePostpaid', ['invoice' => $invoice]);
    }

    public function showinvoicecardnt($id)
    {
        $invoice = invoice::latest()->where('type', '3')->where('id', $id)->where('client_id', Auth::user()->id)->first();
        $getID = DB::table('notifications')->where('data->invoice_id', $id)->pluck('id');
        DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
        return view('Dashboard.dashboard_client.invoices.showinvoicecard', ['invoice' => $invoice]);
    }

    public function showinvoicereceiptnt($id){
        $fund_accounts = fund_account::whereNotNull('receipt_id')->where('invoice_id', $id)->with('invoice')->with('receiptaccount')->get();
        $getID = DB::table('notifications')->where('data->invoice_id', $id)->pluck('id');
        DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
        return view('Dashboard.dashboard_client.invoices.invoicesreceipt', compact('fund_accounts'));
    }

    public function showinvoicereceiptPostpaidnt($id){
        $fund_accounts = fund_account::whereNotNull('Payment_id')->where('invoice_id', $id)->with('invoice')->with('paymentaccount')->get();
        $getID = DB::table('notifications')->where('data->invoice_id', $id)->pluck('id');
        DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
        return view('Dashboard.dashboard_client.invoices.invoicesreceiptPostpaid', compact('fund_accounts'));
    }

    public function showinvoicemonetary($id)
    {
        $invoice = invoice::latest()->where('type', '1')->where('id', $id)->where('client_id', Auth::user()->id)->first();
        return view('Dashboard.dashboard_client.invoices.showinvoicemonetary', ['invoice' => $invoice]);
    }

    public function showinvoicePostpaid($id)
    {
        $invoice = invoice::latest()->where('type', '2')->where('id', $id)->where('client_id', Auth::user()->id)->first();
        return view('Dashboard.dashboard_client.invoices.showinvoicePostpaid', ['invoice' => $invoice]);
    }

    public function showinvoicecard($id)
    {
        $invoice = invoice::latest()->where('type', '3')->where('id', $id)->where('client_id', Auth::user()->id)->first();
        return view('Dashboard.dashboard_client.invoices.showinvoicecard', ['invoice' => $invoice]);
    }

    public function showinvoicebanktransfer($id)
    {
        $invoice = invoice::latest()->where('type', '1')->where('id', $id)->where('client_id', Auth::user()->id)->first();
        return view('Dashboard.dashboard_client.invoices.showinvoicemonetary', ['invoice' => $invoice]);
    }

    public function receipt($id){
        $fund_accounts = fund_account::whereNotNull('receipt_id')->where('invoice_id', $id)->with('invoice')->with('receiptaccount')->get();
        return view('Dashboard.dashboard_client.invoices.invoicesreceipt',compact('fund_accounts'));
    }

    public function receiptpostpaid($id){
        $fund_accounts = fund_account::whereNotNull('Payment_id')->where('invoice_id', $id)->with('invoice')->with('paymentaccount')->get();
        return view('Dashboard.dashboard_client.invoices.invoicesreceiptPostpaid',compact('fund_accounts'));
    }

    public function printreceipt($id){
        $receipt = receipt_account::findorfail($id);
        $fund_account = fund_account::where('receipt_id', $id)->with('invoice')->first();
        $invoice_number = $fund_account->invoice->invoice_number;
        return view('Dashboard.dashboard_client.invoices.printreceipt',compact('receipt', 'invoice_number'));
    }

    public function printpostpaid($id){
        $postpaid = paymentaccount::findorfail($id);
        $fund_account = fund_account::where('Payment_id', $id)->with('invoice')->first();
        $invoice_number = $fund_account->invoice->invoice_number;
        return view('Dashboard.dashboard_client.invoices.printpostpaid',compact('postpaid', 'invoice_number'));
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
