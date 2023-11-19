<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\banktransfer;
use App\Models\Client;
use App\Models\client_account;
use App\Models\fund_account;
use App\Models\invoice;
use App\Models\order;
use App\Models\paymentgateway;
use App\Models\profileclient;
use App\Models\receiptdocument;
use App\Models\User;
use App\Notifications\clienttouserinvoice;
use App\Traits\GeneralTraitt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

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

    public function Complete(Request $request){
        // validation
        try{
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', Rule::unique(Client::class)->ignore($this->user()->id)],
                'clienType' => ['required'],
                'nationalIdNumber' => ['required'],
                'address' => ['required'],
                'city' => ['required', 'string', 'max:255'],
                'postalcode' => ['required'],
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
        }catch(\Exception $ex){
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

        try{
            $id = $request -> header('profileclientid');
            $client_id = $request -> header('client_id');
            $client = Client::findOrFail($client_id);
            $profileclient = profileclient::findOrFail($id);
                DB::beginTransaction();
                    $client->update([
                        'name' =>  $request -> header('name'),
                        'email' => $request -> header('email'),
                        'phone' => $client->phone
                    ]);
                    if($request -> header('clienType') == '1'){
                        if($request -> header('nothavetax') == '0'){
                            $profileclient->update([
                                'adderss' => $request -> header('address'),
                                'city' => $request -> header('city'),
                                'postalcode' => $request -> header('postalcode'),
                                'clienType' => $request -> header('clienType'),
                                'commercialRegistrationNumber' => Null,
                                'nationalIdNumber' => $request -> header('nationalIdNumber'),
                                'taxNumber' => Null,
                            ]);
                        }
                        else{
                            $profileclient->update([
                                'adderss' => $request -> header('address'),
                                'city' => $request -> header('city'),
                                'postalcode' => $request -> header('postalcode'),
                                'clienType' => $request -> header('clienType'),
                                'commercialRegistrationNumber' => Null,
                                'nationalIdNumber' => $request -> header('nationalIdNumber'),
                                'taxNumber' => $request -> header('taxNumber'),
                            ]);
                        }
                    }
                    if($request -> header('clienType') == '0'){
                        if($request -> header('nothavetax') == '0'){
                            $profileclient->update([
                                'adderss' => $request -> header('address'),
                                'city' => $request -> header('city'),
                                'postalcode' => $request -> header('postalcode'),
                                'clienType' => $request -> header('clienType'),
                                'commercialRegistrationNumber' => $request -> header('commercialRegistrationNumber'),
                                'nationalIdNumber' => $request -> header('nationalIdNumber'),
                                'taxNumber' => Null,
                            ]);
                        }
                        else{
                            $profileclient->update([
                                'adderss' => $request -> header('address'),
                                'city' => $request -> header('city'),
                                'postalcode' => $request -> header('postalcode'),
                                'clienType' => $request -> header('clienType'),
                                'nationalIdNumber' => $request -> header('nationalIdNumber'),
                                'commercialRegistrationNumber' => $request -> header('commercialRegistrationNumber'),
                                'taxNumber' => $request -> header('taxNumber'),
                            ]);
                        }
                    }
                DB::commit();
                return redirect()->route('Continue', $request -> header('invoice_id'));
                // return $this->returnSuccessMessage('Logged out successfully');
        }catch(\Exception $execption){
            DB::rollBack();
            return  $this -> returnError('',trans('Dashboard/messages.error'));
        }
    }

    public function Continue($id)
    {
        $fund_accountreceipt = fund_account::whereNotNull('receipt_id')->where('invoice_id', $id)->with('invoice')->with('receiptaccount')->first();
        $fund_accountpostpaid = fund_account::whereNotNull('Payment_id')->where('invoice_id', $id)->with('invoice')->with('paymentaccount')->first();
        $invoice = invoice::where('id', $id)->where('client_id', Auth::user()->id)->first();
        return $this->returnTreeData('invoice' , $invoice, 'fund_accountreceipt' , $fund_accountreceipt, 'fund_accountpostpaid' , $fund_accountpostpaid);
    }


    public function Confirmpayment(Request $request)
    {
        $completepyinvoice = invoice::findorFail($request -> header('invoice_id'));
            try{
                if($request -> header('invoice')){
                    DB::beginTransaction();

                    $image = $this->uploaddocument($request, 'invoice');
                        receiptdocument::create([
                            'invoice_id' => $request -> header('invoice_id'),
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
                            $invoice_id = $request -> header('invoice_id');
                            $message = __('Dashboard/users.billpaid');
                            Notification::send($user, new clienttouserinvoice($invoice_id, $message));

                            // $mailuser = User::findorFail($completepyinvoice->user_id);
                            // $nameuser = $mailuser->name;
                            // $url = url('en/showpinvoicent/'.$invoice_id);
                            // Mail::to($mailuser->email)->send(new clienttouserinvoiceMailMarkdown($message, $nameuser, $url));

                        DB::commit();
                        return  $this -> returnError('',trans('Dashboard/messages.add'));
                        return redirect()->route('Completepayment', $request -> header('invoice_id'));
                }
                // No Add photo
                else{
                    return  $this -> returnError('',trans('Dashboard/messages.imagerequired'));
                    return redirect()->route('Errorinpayment', $request -> header('invoice_id'));
                }
            }
            catch(\Exception $exception){
                DB::rollBack();
                return  $this -> returnError('',trans('Dashboard/messages.error'));
                return redirect()->route('Errorinpayment', $request -> header('invoice_id'));
            }
    }

    public function Completepayment($id)
    {
        $invoice = invoice::latest()->where('id', $id)->where('client_id', Auth::user()->id)->first();
        return $this->returnData('invoice', $invoice);
    }

    public function Errorinpayment($id)
    {
        $invoice = invoice::latest()->where('id', $id)->where('client_id', Auth::user()->id)->first();
        return $this->returnData('invoice', $invoice);
    }

    // Card
    public function confirm(Request $request)
    {
        $invoice = invoice::findOrFail($request-> header('invoice_id'));

        $client = Client::findOrFail(Auth::user()->id);
        $client->orders()->create([
            'invoice_id' => $invoice->id,
            'nameincard' => 'nameincard',
            'price' => $invoice->total_with_tax
        ]);
        return redirect()->route('checkout');
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

    public function pay(Request $request)
    {
        $order = order::where('client_id', auth()->id())->findOrFail($request -> header('order_id'));
        DB::table('orders')->where('id', $request -> header('order_id'))->update(['nameincard'=>$request-> header('nameincard')]);
        $client = auth()->user();
        $paymentMethod = $request-> header('payment_method');
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

                // $mailuser = User::findorFail($order->invoice->user_id);
                // $nameuser = $mailuser->name;
                // $url = url('en/showpinvoicent/'.$invoice_id);
                // Mail::to($mailuser->email)->send(new clienttouserinvoiceMailMarkdown($message, $nameuser, $url));

        } catch (\Exception $ex) {
            return back()->with('error', $ex->getMessage());
        }
        return redirect()->route('Completepayment', $order->invoice->id);

    }
}
