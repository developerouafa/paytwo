<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\invoice;
use App\Models\Order;
use App\Models\post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $invoices = invoice::all();

        return view('home', compact('invoices'));
    }

    public function buy($invoice_id)
    {
        $invoice = invoice::findOrFail($invoice_id);

        return view('buy', compact('invoice'));
    }

    public function confirm(Request $request)
    {
        $invoice = invoice::findOrFail($request->input('invoice_id'));

        $client = Client::findOrFail(Auth::user()->id);
        $client->orders()->create([
            'invoice_id' => $invoice->id,
            'price' => $invoice->price
        ]);
        return redirect()->route('checkout');
    }

    public function checkout()
    {
        $order = Order::with('invoice')
            ->where('client_id', auth()->id())
            ->whereNull('paid_at')
            ->latest()
            ->firstOrFail();

        $paymentIntent = auth()->user()->createSetupIntent();

        return view('checkout', compact('order', 'paymentIntent'));
    }

    public function pay(Request $request)
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

        return redirect()->route('success');
    }
}
