<?php
namespace App\Repository\clients\invoices;

use App\Interfaces\clients\invoices\InvoiceRepositoryInterface;
use App\Mail\clienttouserinvoiceMailMarkdown;
use App\Mail\clienttouserMailMarkdown;
use App\Models\banktransfer;
use App\Models\Client;
use App\Models\client_account;
use App\Models\fund_account;
use App\Models\invoice;
use App\Models\mainimageproduct;
use App\Models\multipimage;
use App\Models\order;
use App\Models\paymentaccount;
use App\Models\paymentgateway;
use App\Models\pivot_product_group;
use App\Models\product;
use App\Models\profileclient;
use App\Models\promotion;
use App\Models\receipt_account;
use App\Models\receiptdocument;
use App\Models\section;
use App\Models\stockproduct;
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
        $invoices = invoice::latest()->where('type', '0')->whereNot('invoice_status', '1')->where('client_id', Auth::user()->id)->get();
        return view('Dashboard.dashboard_client.invoices.invoices', ['invoices' => $invoices]);
    }

    public function indexmonetary(){
        $invoices = invoice::latest()->where('type', '1')->whereNot('invoice_status', '1')->where('client_id', Auth::user()->id)->get();
        $fund_accountreceipt = fund_account::whereNotNull('receipt_id')->with('invoice')->with('receiptaccount')->first();
        return view('Dashboard.dashboard_client.invoices.invoicesmonetary', ['invoices' => $invoices, 'fund_accountreceipt' => $fund_accountreceipt]);
    }

    public function indexPostpaid(){
        $invoices = invoice::latest()->where('type', '2')->whereNot('invoice_status', '1')->where('client_id', Auth::user()->id)->get();
        $fund_accountpostpaid = fund_account::whereNotNull('Payment_id')->with('invoice')->with('paymentaccount')->first();
        return view('Dashboard.dashboard_client.invoices.invoicesPostpaid', ['invoices' => $invoices, 'fund_accountpostpaid' => $fund_accountpostpaid]);
    }

    public function indexbanktransfer(){
        $invoices = invoice::latest()->where('type', '3')->whereNot('invoice_status', '1')->where('client_id', Auth::user()->id)->get();
        return view('Dashboard.dashboard_client.invoices.invoicescard', ['invoices' => $invoices]);
    }

    public function indexcard(){
        $invoices = invoice::latest()->where('type', '4')->whereNot('invoice_status', '1')->where('client_id', Auth::user()->id)->get();
        return view('Dashboard.dashboard_client.invoices.invoicebanktransfer', ['invoices' => $invoices]);
    }

    public function showinvoicereceiptnt($id){
        $fund_accounts = fund_account::whereNotNull('receipt_id')->where('invoice_id', $id)->with('invoice')->with('receiptaccount')->get();
        $getID = DB::table('notifications')->where('data->invoice_id', $id)->where('type', 'App\Notifications\catchreceipt')->pluck('id');
        DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
        return view('Dashboard.dashboard_client.invoices.invoicesreceipt', compact('fund_accounts'));
    }

    public function showinvoicereceipt($id){
        $fund_accounts = fund_account::whereNotNull('receipt_id')->where('invoice_id', $id)->with('invoice')->with('receiptaccount')->get();
        return view('Dashboard.dashboard_client.invoices.invoicesreceipt', compact('fund_accounts'));
    }

    public function print($id){
        $invoice = invoice::where('id', $id)->where('client_id', Auth::user()->id)->first();
        return view('Dashboard.dashboard_client.invoices.print',compact('invoice'));
    }

    public function showinvoice($id)
    {
        $invoice = invoice::where('id', $id)->where('client_id', Auth::user()->id)->first();
        return view('Dashboard.dashboard_client.invoices.showinvoice', ['invoice' => $invoice]);
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
                        'phone' => $client->phone
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

    public function Confirmpayment($request)
    {
        $completepyinvoice = invoice::findorFail($request->invoice_id);
            try{
                if($request->has('invoice')){
                    DB::beginTransaction();

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
                            $banktransfers->user_id = $completepyinvoice->user_id;
                            $banktransfers->save();

                            // store fund_accounts
                            $fund_accounts = new fund_account();
                            $fund_accounts->date =date('y-m-d');
                            $fund_accounts->bank_id = $banktransfers->id;
                            $fund_accounts->invoice_id = $completepyinvoice->id;
                            $fund_accounts->Debit = $completepyinvoice->total_with_tax;
                            $fund_accounts->user_id = $completepyinvoice->user_id;
                            $fund_accounts->credit = 0.00;
                            $fund_accounts->save();

                            // store client_accounts
                            $client_accounts = new client_account();
                            $client_accounts->date =date('y-m-d');
                            $client_accounts->client_id = $completepyinvoice->client_id;
                            $client_accounts->bank_id = $banktransfers->id;
                            $client_accounts->invoice_id = $completepyinvoice->id;
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
                else{
                    toastr()->error(trans('Dashboard/messages.imagerequired'));
                    return redirect()->route('Invoice.Errorinpayment', $request->invoice_id);
                }
            }
            catch(\Exception $exception){
                DB::rollBack();
                toastr()->error(trans('Dashboard/messages.error'));
                return redirect()->route('Invoice.Errorinpayment', $request->invoice_id);
            }
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

    public function showService($id){
        $product = product::findOrFail($id);
        $childrens = section::latest()->selectchildrens()->withchildrens()->child()->get();
        $sections = section::latest()->selectsections()->withsections()->parent()->get();
        $stockproduct = stockproduct::selectstock()->get();
        return view('Dashboard/dashboard_client/invoices.showService',compact('product', 'childrens', 'sections', 'stockproduct'));
    }

    public function promotion($id)
    {
        $promotion = promotion::latest()->where('product_id', $id)->withPromotion()->get();
        $product = product::where('id', $id)->first();
        return view('Dashboard/dashboard_client/invoices.promotions', compact('promotion', 'product'));
    }

    public function image($id)
    {
        $Product = product::where('id',$id)->firstOrFail();
        $mainimage  = mainimageproduct::selectmainimage()->where('product_id',$id)->get();
        $multimg  = multipimage::selectmultipimage()->where('product_id',$id)->get();
        return view('Dashboard/dashboard_client/invoices.images',compact('Product', 'mainimage','multimg'));
    }

    public function showServices($id){
        $product_group = pivot_product_group::where('groupprodcut_id', $id)->with('product')->with('groupprodcut')->get();
        return view('Dashboard/dashboard_client/invoices.showServices',compact('product_group'));
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
            $getID = DB::table('notifications')->where('data->invoice_id', $id)->where('type', 'App\Notifications\App\Notifications\banktransferntf')->pluck('id');
            DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
            return view('Dashboard.dashboard_client.invoices.print',compact('invoice'));
        }
        if($invoice->type == '4'){
            $getID = DB::table('notifications')->where('data->invoice_id', $id)->where('type', 'App\Notifications\paymentgateways')->pluck('id');
            DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
            return view('Dashboard.dashboard_client.invoices.print',compact('invoice'));
        }
    }

    public function confirmpyinvoice($id)
    {
        $invoice = invoice::where('id', $id)->where('client_id', Auth::user()->id)->first();
        $fund_accountrcaccount = fund_account::whereNotNull('receipt_id')->where('invoice_id', $id)->with('invoice')->with('receiptaccount')->first();
        $fund_accountpyaccount = fund_account::whereNotNull('Payment_id')->where('invoice_id', $id)->with('invoice')->with('paymentaccount')->first();
        $fund_accountbanktransfer = fund_account::whereNotNull('bank_id')->where('invoice_id', $id)->with('invoice')->with('banktransfer')->first();
        $fund_accountpaymentgateway = fund_account::whereNotNull('Gateway_id')->where('invoice_id', $id)->with('invoice')->with('paymentgateway')->first();

        $getID = DB::table('notifications')->where('data->invoice_id', $id)->where('type', 'App\Notifications\confirmpyinvoice')->pluck('id');
        DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
        return view('Dashboard.dashboard_client.invoices.print',compact('invoice', 'fund_accountrcaccount', 'fund_accountpyaccount', 'fund_accountbanktransfer', 'fund_accountpaymentgateway'));
    }

    public function showinvoicereceiptPostpaidnt($id){
        $fund_accounts = fund_account::whereNotNull('Payment_id')->where('invoice_id', $id)->with('invoice')->with('paymentaccount')->get();
        $getID = DB::table('notifications')->where('data->invoice_id', $id)->where('type', 'App\Notifications\catchpayment')->pluck('id');
        DB::table('notifications')->where('id', $getID)->update(['read_at'=>now()]);
        return view('Dashboard.dashboard_client.invoices.invoicesreceiptPostpaid', compact('fund_accounts'));
    }

    public function showinvoicereceiptPostpaid($id){
        $fund_accounts = fund_account::whereNotNull('Payment_id')->where('invoice_id', $id)->with('invoice')->with('paymentaccount')->get();
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
            'price' => $invoice->total_with_tax
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

                $completepyinvoice = invoice::findorFail($order->invoice->id);
                $completepyinvoice->update([
                    'invoice_status' => '3',
                    'invoice_type' => '1',
                ]);

                // store paymentgateway_accounts
                $paymentgateways = new paymentgateway();
                $paymentgateways->date =date('y-m-d');
                $paymentgateways->client_id = $order->invoice->client_id;
                $paymentgateways->amount = $order->invoice->total_with_tax;
                $paymentgateways->user_id = $order->invoice->user_id;
                $paymentgateways->save();

                // store fund_accounts
                $fund_accounts = new fund_account();
                $fund_accounts->date =date('y-m-d');
                $fund_accounts->Gateway_id = $paymentgateways->id;
                $fund_accounts->invoice_id = $order->invoice->id;
                $fund_accounts->Debit = $order->invoice->total_with_tax;
                $fund_accounts->user_id = $order->invoice->user_id;
                $fund_accounts->credit = 0.00;
                $fund_accounts->save();

                // store client_accounts
                $client_accounts = new client_account();
                $client_accounts->date =date('y-m-d');
                $client_accounts->client_id = $order->invoice->client_id;
                $client_accounts->Gateway_id = $paymentgateways->id;
                $client_accounts->invoice_id = $order->invoice->id;
                $client_accounts->user_id = $order->invoice->user_id;
                $client_accounts->Debit = 0.00;
                $client_accounts->credit = $order->invoice->Debit;
                $client_accounts->save();

            //* Payment Completed notification Database & email
                $user = User::where('id', '=', $order->invoice->user_id)->first();
                $invoice_id = $order->invoice->id;
                $message = __('Dashboard/users.billpaid');
                Notification::send($user, new clienttouserinvoice($invoice_id, $message));

                $mailuser = User::findorFail($order->invoice->user_id);
                $nameuser = $mailuser->name;
                $url = url('en/showpinvoicent/'.$invoice_id);
                Mail::to($mailuser->email)->send(new clienttouserinvoiceMailMarkdown($message, $nameuser, $url));

        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage());
        }
        return redirect()->route('Invoice.Completepayment', $order->invoice->id);

    }
}
