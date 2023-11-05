<?php
namespace App\Repository\Clients\Invoices;

use App\Interfaces\Clients\Invoices\InvoiceRepositoryInterface;
use App\Mail\clienttouserinvoiceMailMarkdown;
use App\Mail\clienttouserMailMarkdown;
use App\Models\banktransfer;
use App\Models\Client;
use App\Models\client_account;
use App\Models\fund_account;
use App\Models\invoice;
use App\Models\order;
use App\Models\paymentaccount;
use App\Models\profileclient;
use App\Models\receipt_account;
use App\Models\receiptdocument;
use App\Models\User;
use App\Notifications\clienttouser;
use App\Notifications\clienttouserinvoice;
use App\Traits\UploadImageTraitt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class InvoicesRepository implements InvoiceRepositoryInterface
{
    use UploadImageTraitt;

    public function index(){
        $invoices = invoice::latest()->where('type', '0')->where('client_id', Auth::user()->id)->get();
        return view('Dashboard.dashboard_client.invoices.invoices', ['invoices' => $invoices]);
    }

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

    public function Complete($request){
        try{
            $id = $request->profileclientid;
            $client_id = $request->client_id;
            $client = Client::findOrFail($client_id);
            $profileclient = profileclient::findOrFail($id);
                DB::beginTransaction();
                    $client->update([
                        'name' =>  $request->name,
                        'email' => $request->email,
                        'phone' => '0582201021'
                    ]);
                    if($request->clienType == '1'){
                        if($request->nothavetax == '0'){
                            $profileclient->update([
                                'adderss' => $request->address,
                                'city' => $request->city,
                                'postalcode' => $request->postalcode,
                                'clienType' => $request->clienType,
                                'commercialRegistrationNumber' => Null,
                                'nationalIdNumber' => $request->nationalIdNumber,
                                'taxNumber' => Null,
                            ]);
                        }
                        else{
                            $profileclient->update([
                                'adderss' => $request->address,
                                'city' => $request->city,
                                'postalcode' => $request->postalcode,
                                'clienType' => $request->clienType,
                                'commercialRegistrationNumber' => Null,
                                'nationalIdNumber' => $request->nationalIdNumber,
                                'taxNumber' => $request->taxNumber,
                            ]);
                        }
                    }
                    if($request->clienType == '0'){
                        if($request->nothavetax == '0'){
                            $profileclient->update([
                                'adderss' => $request->address,
                                'city' => $request->city,
                                'postalcode' => $request->postalcode,
                                'clienType' => $request->clienType,
                                'commercialRegistrationNumber' => $request->commercialRegistrationNumber,
                                'nationalIdNumber' => $request->nationalIdNumber,
                                'taxNumber' => Null,
                            ]);
                        }
                        else{
                            $profileclient->update([
                                'adderss' => $request->address,
                                'city' => $request->city,
                                'postalcode' => $request->postalcode,
                                'clienType' => $request->clienType,
                                'nationalIdNumber' => $request->nationalIdNumber,
                                'commercialRegistrationNumber' => $request->commercialRegistrationNumber,
                                'taxNumber' => $request->taxNumber,
                            ]);
                        }
                    }
                DB::commit();
                toastr()->success(trans('Dashboard/messages.edit'));
                return redirect()->route('Invoice.Continue', $request->invoice_id);
        }catch(\Exception $execption){
            DB::rollBack();
            toastr()->error(trans('Dashboard/messages.error'));
            return redirect()->back();
        }
    }

    public function Continue($id)
    {
        $fund_accountreceipt = fund_account::whereNotNull('receipt_id')->where('invoice_id', $id)->with('invoice')->with('receiptaccount')->first();
        $fund_accountpostpaid = fund_account::whereNotNull('Payment_id')->where('invoice_id', $id)->with('invoice')->with('paymentaccount')->first();
        $invoice = invoice::where('id', $id)->where('client_id', Auth::user()->id)->first();
        return view('Dashboard.dashboard_client.invoices.continue', ['invoice' => $invoice, 'fund_accountreceipt' => $fund_accountreceipt, 'fund_accountpostpaid' => $fund_accountpostpaid]);
    }

    public function modifypymethod($request){
        try{
            $modifypymethodinvoice = invoice::findorFail($request->invoice_id);
            DB::beginTransaction();
                $modifypymethodinvoice->update([
                    'type' => $request->type,
                ]);

                //* Payment method update notification Database & email
                    $user = User::where('id', '=', $modifypymethodinvoice->user_id)->first();
                    $invoice_id = $request->invoice_id;
                    $message = __('Dashboard/users.pyupdatent');
                    Notification::send($user, new clienttouser($invoice_id, $message));

                    $mailuser = User::findorFail($modifypymethodinvoice->user_id);
                    $nameuser = $mailuser->name;
                    $url = url('en/showpinvoicent/'.$invoice_id);
                    Mail::to($mailuser->email)->send(new clienttouserMailMarkdown($message, $nameuser, $url));

            DB::commit();
            toastr()->success(trans('Dashboard/messages.edit'));
            return redirect()->back();
        }catch(\Exception $exception){
            DB::rollBack();
            toastr()->error(trans('messages.error'));
            return redirect()->back();
        }
    }

    public function Confirmpayment($request)
    {
        $completepyinvoice = invoice::findorFail($request->invoice_id);
            // try{
                if($request->has('invoice')){
                    // DB::beginTransaction();

                    $image = $this->uploaddocument($request, 'invoice');
                        receiptdocument::create([
                            'invoice_id' => $request->invoice_id,
                            'invoice' => $image,
                            'client_id' => auth()->user()->id,
                        ]);

                        $completepyinvoice->update([
                            'invoice_status' => '3'
                        ]);

                        if($completepyinvoice->type == 3){
                            // store banktransfer_accounts
                            $banktransfers = new banktransfer();
                            $banktransfers->date =date('y-m-d');
                            $banktransfers->client_id = $completepyinvoice->client_id;
                            $banktransfers->amount = $completepyinvoice->total_with_tax;
                            $banktransfers->description = 'description';
                            $banktransfers->user_id = $completepyinvoice->user_id;
                            $banktransfers->save();

                            // store fund_accounts
                            $fund_accounts = new fund_account();
                            $fund_accounts->date =date('y-m-d');
                            $fund_accounts->bank_id = $banktransfers->id;
                            $fund_accounts->invoice_id = $completepyinvoice->invoice_id;
                            $fund_accounts->Debit = $completepyinvoice->total_with_tax;
                            $fund_accounts->user_id = $completepyinvoice->user_id;
                            $fund_accounts->credit = 0.00;
                            $fund_accounts->save();

                            // store client_accounts
                            $client_accounts = new client_account();
                            $client_accounts->date =date('y-m-d');
                            $client_accounts->client_id = $completepyinvoice->client_id;
                            $client_accounts->bank_id = $banktransfers->id;
                            $client_accounts->invoice_id = $completepyinvoice->invoice_id;
                            $client_accounts->user_id = $completepyinvoice->user_id;
                            $client_accounts->Debit = 0.00;
                            $client_accounts->credit =$completepyinvoice->Debit;
                            $client_accounts->save();
                        }

                        //* Payment Completed notification Database & email
                            $user = User::where('id', '=', $completepyinvoice->user_id)->first();
                            $invoice_id = $request->invoice_id;
                            $message = __('Dashboard/users.billpaid');
                            Notification::send($user, new clienttouserinvoice($invoice_id, $message));

                            $mailuser = User::findorFail($completepyinvoice->user_id);
                            $nameuser = $mailuser->name;
                            $url = url('en/showpinvoicent/'.$invoice_id);
                            Mail::to($mailuser->email)->send(new clienttouserinvoiceMailMarkdown($message, $nameuser, $url));

                        DB::commit();
                        toastr()->success(trans('Dashboard/messages.add'));
                        return redirect()->route('Invoice.Completepayment', $request->invoice_id);
                }
                // No Add photo
            //     else{
            //         toastr()->error(trans('Dashboard/messages.imagerequired'));
            //         return redirect()->route('Invoice.Errorinpayment', $request->invoice_id);
            //     }
            // }
            // catch(\Exception $exception){
            //     DB::rollBack();
            //     toastr()->error(trans('Dashboard/messages.error'));
            //     return redirect()->route('Invoice.Errorinpayment', $request->invoice_id);
            // }
    }

    public function Completepayment($id)
    {
        $invoice = invoice::latest()->where('id', $id)->where('client_id', Auth::user()->id)->first();
        return view('Dashboard.dashboard_client.invoices.completepayment', ['invoice' => $invoice]);
    }

    public function Errorinpayment($id)
    {
        $invoice = invoice::latest()->where('id', $id)->where('client_id', Auth::user()->id)->first();
        return view('Dashboard.dashboard_client.invoices.errorinpayment', ['invoice' => $invoice]);
    }

    public function receipt($id){
        $fund_accounts = fund_account::whereNotNull('receipt_id')->where('invoice_id', $id)->with('invoice')->with('receiptaccount')->get();
        return view('Dashboard.dashboard_client.invoices.invoicesreceipt',compact('fund_accounts'));
    }

    public function receiptpostpaid($id){
        $fund_accounts = fund_account::whereNotNull('Payment_id')->where('invoice_id', $id)->with('invoice')->with('paymentaccount')->get();
        return view('Dashboard.dashboard_client.invoices.invoicesreceiptPostpaid',compact('fund_accounts'));
    }

    public function showinvoicent($id)
    {
        $invoice = invoice::where('id', $id)->where('client_id', Auth::user()->id)->first();
        if($invoice->type == '0'){
            $getID = DB::table('notifications')->where('data->invoice_id', $id)->where('type', 'App\Notifications\invoicent')->pluck('id');
            DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
            return view('Dashboard.dashboard_client.invoices.print',compact('invoice'));
        }
        if($invoice->type == '1'){
            $getID = DB::table('notifications')->where('data->invoice_id', $id)->where('type', 'App\Notifications\montaryinvoice')->pluck('id');
            DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
            return view('Dashboard.dashboard_client.invoices.print',compact('invoice'));
        }
        if($invoice->type == '2'){
            $getID = DB::table('notifications')->where('data->invoice_id', $id)->where('type', 'App\Notifications\postpaidbillinvoice')->pluck('id');
            DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
            return view('Dashboard.dashboard_client.invoices.print',compact('invoice'));
        }
        if($invoice->type == '3'){
            $getID = DB::table('notifications')->where('data->invoice_id', $id)->where('type', 'App\Notifications\paymentgateways')->pluck('id');
            DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
            return view('Dashboard.dashboard_client.invoices.print',compact('invoice'));
        }
        if($invoice->type == '4'){
            $getID = DB::table('notifications')->where('data->invoice_id', $id)->where('type', 'App\Notifications\banktransferntf')->pluck('id');
            DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
            return view('Dashboard.dashboard_client.invoices.print',compact('invoice'));
        }
    }

    public function showinvoice($id)
    {
        $invoice = invoice::where('id', $id)->where('client_id', Auth::user()->id)->first();
        return view('Dashboard.dashboard_client.invoices.showinvoice', ['invoice' => $invoice]);
    }

    public function print($id){
        $invoice = invoice::where('id', $id)->where('client_id', Auth::user()->id)->first();
        return view('Dashboard.dashboard_client.invoices.print',compact('invoice'));
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
            'nameincard' => 'nameincard',
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
        DB::table('orders')->where('id', $request->order_id)->update(['nameincard'=>$request->nameincard]);
        $client = auth()->user();
        $paymentMethod = $request->input('payment_method');
        try {
            $client->createOrGetStripeCustomer();
            $client->updateDefaultPaymentMethod($paymentMethod);
            $client->invoiceFor($order->invoice->invoice_number, $order->price);
        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage());
        }
        return redirect()->route('Invoice.Completepayment', $order->invoice->id);

    }
}
