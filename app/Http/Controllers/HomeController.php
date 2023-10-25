<?php

namespace App\Http\Controllers;

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
        $posts = post::all();

        return view('home', compact('posts'));
    }

    public function buy($post_id)
    {
        $post = post::findOrFail($post_id);

        return view('buy', compact('post'));
    }

    public function confirm(Request $request)
    {
        $post = post::findOrFail($request->input('post_id'));

        // $user = User::firstOrCreate([
        //     'email' => $request->input('email'),
        // ], [
        //     'name' => $request->input('name'),
        //     'password' => Str::random(10),
        //     'address' => $request->input('address'),
        // ]);

        // auth()->login($user);
        $user = User::findOrFail(Auth::user()->id);
        $user->orders()->create([
            'post_id' => $post->id,
            'price' => $post->price
        ]);

        return redirect()->route('checkout');
    }

    public function checkout()
    {
        $order = Order::with('post')
            ->where('user_id', auth()->id())
            ->whereNull('paid_at')
            ->latest()
            ->firstOrFail();

        $paymentIntent = auth()->user()->createSetupIntent();

        return view('checkout', compact('order', 'paymentIntent'));
    }

    public function pay(Request $request)
    {
        $order = Order::where('user_id', auth()->id())->findOrFail($request->input('order_id'));
        $user = auth()->user();
        $paymentMethod = $request->input('payment_method');
        try {
            $user->createOrGetStripeCustomer();
            $user->updateDefaultPaymentMethod($paymentMethod);
            $user->invoiceFor($order->post->name, $order->price);
        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage());
        }

        return redirect()->route('success');
    }
}
