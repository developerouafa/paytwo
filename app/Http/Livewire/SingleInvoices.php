<?php

namespace App\Http\Livewire;

use App\Events\createinvoice;
use App\Mail\mailclient;
use App\Models\banktransfer;
use App\Models\Client;
use App\Models\client_account;
use App\Models\fund_account;
use App\Models\invoice;
use App\Models\NotificationPusher;
use App\Models\paymentgateway;
use App\Models\product;
use App\Models\User;
use App\Notifications\montaryinvoice;
use App\Notifications\invoicent;
use App\Notifications\banktransferntf;
use App\Notifications\notificationMail;
use App\Notifications\paymentgateways;
use App\Notifications\postpaidbillinvoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class SingleInvoices extends Component
{
    public $InvoiceSaved,$InvoiceUpdated;
    public $user_id;
    public $show_table = true;
    public $tax_rate = 17;
    public $updateMode = false;
    public $price,$discount_value = 0 ,$client_id,$type,$product_id,$single_invoice_id,$catchError;

    public function mount(){
        $this->user_id = auth()->user()->id;
    }

    public function render()
    {
        $fund_accountreceipt = fund_account::whereNotNull('receipt_id')->with('invoice')->with('receiptaccount')->first();
        $fund_accountpostpaid = fund_account::whereNotNull('Payment_id')->with('invoice')->with('paymentaccount')->first();

        return view('livewire.single_invoices.single-invoices', [
            'single_invoices'=>invoice::latest()->where('invoice_classify',1)->get(),
            'Clients'=> Client::all(),
            'Products'=> product::all(),
            'subtotal' => $Total_after_discount = ((is_numeric($this->price) ? $this->price : 0)) - ((is_numeric($this->discount_value) ? $this->discount_value : 0)),
            'tax_value'=> $Total_after_discount * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100),
            'fund_accountreceipt'=> $fund_accountreceipt,
            'fund_accountpostpaid'=> $fund_accountpostpaid,
        ]);
    }

    public function show_form_add(){
        $this->show_table = false;
    }

    public function get_price()
    {
        $this->price = product::where('id', $this->product_id)->first()->price;
    }

    public function edit($id){
        $this->show_table = false;
        $this->updateMode = true;
        $single_invoice = invoice::findorfail($id);
        $this->single_invoice_id = $single_invoice->id;
        $this->client_id = $single_invoice->client_id;
        $this->product_id = $single_invoice->product_id;
        $this->price = $single_invoice->price;
        $this->discount_value = $single_invoice->discount_value;
        $this->type = $single_invoice->type;
    }

    public function store(){
        // في حالة كانت الفاتورة لم يتم الاختيار بعد
        if($this->type == 0){
            DB::beginTransaction();
            try {
                // في حالة التعديل
                if($this->updateMode){

                    $single_invoices = invoice::findorfail($this->single_invoice_id);
                    $single_invoices->invoice_date = date('Y-m-d');
                    $single_invoices->client_id = $this->client_id;
                    $single_invoices->product_id = $this->product_id;
                    $single_invoices->price = $this->price;
                    $single_invoices->discount_value = $this->discount_value;
                    $single_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $single_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $single_invoices->total_with_tax = $single_invoices->price -  $single_invoices->discount_value + $single_invoices->tax_value;
                    $single_invoices->type = $this->type;
                    $single_invoices->save();

                    $fund_accounts = fund_account::where('invoice_id',$this->single_invoice_id)->first();
                    $fund_accounts->date = date('Y-m-d');
                    $fund_accounts->invoice_id = $single_invoices->id;
                    $fund_accounts->Debit = $single_invoices->total_with_tax;
                    $fund_accounts->credit = 0.00;
                    $fund_accounts->save();
                    $this->InvoiceUpdated =true;
                    $this->show_table =true;

                    if($single_invoices->invoice_status == 2){
                        $client = Client::where('id', '=', $this->client_id)->get();
                        $user_create_id = $this->user_id;
                        $invoice_id = $single_invoices->id;
                        $message = __('Dashboard/main-header_trans.nicaseup');
                        Notification::send($client, new montaryinvoice($user_create_id, $invoice_id, $message));

                        $mailclient = Client::findorFail($this->client_id);
                        $nameclient = $mailclient->name;
                        $url = url('en/Invoices/print/'.$invoice_id);
                        Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
                    }

                }
                // في حالة الاضافة
                else{
                    $number = random_int('100000', '2000000000');
                    $single_invoices = new invoice();
                    $single_invoices->invoice_number = $number;
                    $single_invoices->invoice_classify = 1;
                    $single_invoices->invoice_date = date('Y-m-d');
                    $single_invoices->client_id = $this->client_id;
                    $single_invoices->product_id = $this->product_id;
                    $single_invoices->price = $this->price;
                    $single_invoices->discount_value = $this->discount_value;
                    $single_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $single_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $single_invoices->total_with_tax = $single_invoices->price -  $single_invoices->discount_value + $single_invoices->tax_value;
                    $single_invoices->type = $this->type;
                    $single_invoices->invoice_status = 1;
                    $single_invoices->user_id = auth()->user()->id;
                    $single_invoices->save();

                    $fund_accounts = new fund_account();
                    $fund_accounts->date = date('Y-m-d');
                    $fund_accounts->invoice_id = $single_invoices->id;
                    $fund_accounts->Debit = $single_invoices->total_with_tax;
                    $fund_accounts->credit = 0.00;
                    $fund_accounts->user_id = auth()->user()->id;
                    $fund_accounts->save();

                    $this->InvoiceSaved =true;
                    $this->show_table =true;

                }
                DB::commit();
            }
            catch (\Exception $e) {
                DB::rollback();
                $this->catchError = $e->getMessage();
            }
        }
        // في حالة كانت الفاتورة نقدي
        if($this->type == 1){
            DB::beginTransaction();
            try {
                // في حالة التعديل
                if($this->updateMode){

                    $single_invoices = invoice::findorfail($this->single_invoice_id);
                    $single_invoices->invoice_date = date('Y-m-d');
                    $single_invoices->client_id = $this->client_id;
                    $single_invoices->product_id = $this->product_id;
                    $single_invoices->price = $this->price;
                    $single_invoices->discount_value = $this->discount_value;
                    $single_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $single_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $single_invoices->total_with_tax = $single_invoices->price -  $single_invoices->discount_value + $single_invoices->tax_value;
                    $single_invoices->type = $this->type;
                    $single_invoices->save();

                    $fund_accounts = fund_account::where('invoice_id',$this->single_invoice_id)->first();
                    $fund_accounts->date = date('Y-m-d');
                    $fund_accounts->invoice_id = $single_invoices->id;
                    $fund_accounts->Debit = $single_invoices->total_with_tax;
                    $fund_accounts->credit = 0.00;
                    $fund_accounts->save();
                    $this->InvoiceUpdated =true;
                    $this->show_table =true;

                    if($single_invoices->invoice_status == 2){
                        $client = Client::where('id', '=', $this->client_id)->get();
                        $user_create_id = $this->user_id;
                        $invoice_id = $single_invoices->id;
                        $message = __('Dashboard/main-header_trans.nicasemontaryup');
                        Notification::send($client, new montaryinvoice($user_create_id, $invoice_id, $message));

                        $mailclient = Client::findorFail($this->client_id);
                        $nameclient = $mailclient->name;
                        $url = url('en/Invoices/print/'.$invoice_id);
                        Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
                    }

                }
                // في حالة الاضافة
                else{
                    $number = random_int('100000', '2000000000');
                    $single_invoices = new invoice();
                    $single_invoices->invoice_number = $number;
                    $single_invoices->invoice_classify = 1;
                    $single_invoices->invoice_date = date('Y-m-d');
                    $single_invoices->client_id = $this->client_id;
                    $single_invoices->product_id = $this->product_id;
                    $single_invoices->price = $this->price;
                    $single_invoices->discount_value = $this->discount_value;
                    $single_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $single_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $single_invoices->total_with_tax = $single_invoices->price -  $single_invoices->discount_value + $single_invoices->tax_value;
                    $single_invoices->type = $this->type;
                    $single_invoices->invoice_status = 1;
                    $single_invoices->user_id = auth()->user()->id;
                    $single_invoices->save();

                    $fund_accounts = new fund_account();
                    $fund_accounts->date = date('Y-m-d');
                    $fund_accounts->invoice_id = $single_invoices->id;
                    $fund_accounts->Debit = $single_invoices->total_with_tax;
                    $fund_accounts->credit = 0.00;
                    $fund_accounts->user_id = auth()->user()->id;
                    $fund_accounts->save();
                    $this->InvoiceSaved =true;
                    $this->show_table =true;

                }
                DB::commit();
            }
            catch (\Exception $e) {
                DB::rollback();
                $this->catchError = $e->getMessage();
            }
        }
        //------------------------------------------------------------------------
        // في حالة كانت الفاتورة اجل
        elseif($this->type == 2){
            DB::beginTransaction();
            try {
                // في حالة التعديل
                if($this->updateMode){
                    $single_invoices = invoice::findorfail($this->single_invoice_id);
                    $single_invoices->invoice_date = date('Y-m-d');
                    $single_invoices->client_id = $this->client_id;
                    $single_invoices->product_id = $this->product_id;
                    $single_invoices->price = $this->price;
                    $single_invoices->discount_value = $this->discount_value;
                    $single_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $single_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $single_invoices->total_with_tax = $single_invoices->price -  $single_invoices->discount_value + $single_invoices->tax_value;
                    $single_invoices->type = $this->type;
                    $single_invoices->save();

                    $client_accounts = client_account::where('invoice_id',$this->single_invoice_id)->first();
                    $client_accounts->date = date('Y-m-d');
                    $client_accounts->invoice_id = $single_invoices->id;
                    $client_accounts->client_id = $single_invoices->client_id;
                    $client_accounts->Debit = $single_invoices->total_with_tax;
                    $client_accounts->credit = 0.00;
                    $client_accounts->save();
                    $this->InvoiceUpdated =true;
                    $this->show_table =true;

                    if($single_invoices->invoice_status == 2){
                        $client = Client::where('id', '=', $this->client_id)->get();
                        $user_create_id = $this->user_id;
                        $invoice_id = $single_invoices->id;
                        $message = __('Dashboard/main-header_trans.nicasepostpaidup');
                        Notification::send($client, new postpaidbillinvoice($user_create_id, $invoice_id, $message));

                        $mailclient = Client::findorFail($this->client_id);
                        $nameclient = $mailclient->name;
                        $url = url('en/Invoices/print/'.$invoice_id);
                        Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
                    }

                }
                // في حالة الاضافة
                else{
                    $number = random_int('100000', '2000000000');
                    $single_invoices = new invoice();
                    $single_invoices->invoice_number = $number;
                    $single_invoices->invoice_classify = 1;
                    $single_invoices->invoice_date = date('Y-m-d');
                    $single_invoices->client_id = $this->client_id;
                    $single_invoices->product_id = $this->product_id;
                    $single_invoices->price = $this->price;
                    $single_invoices->discount_value = $this->discount_value;
                    $single_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $single_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $single_invoices->total_with_tax = $single_invoices->price -  $single_invoices->discount_value + $single_invoices->tax_value;
                    $single_invoices->type = $this->type;
                    $single_invoices->invoice_status = 1;
                    $single_invoices->user_id = auth()->user()->id;
                    $single_invoices->save();

                    $client_accounts = new client_account();
                    $client_accounts->date = date('Y-m-d');
                    $client_accounts->invoice_id = $single_invoices->id;
                    $client_accounts->client_id = $single_invoices->client_id;
                    $client_accounts->Debit = $single_invoices->total_with_tax;
                    $client_accounts->credit = 0.00;
                    $client_accounts->user_id = auth()->user()->id;
                    $client_accounts->save();
                    $this->InvoiceSaved =true;
                    $this->show_table =true;

                }
                DB::commit();
            }
            catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        }
        //------------------------------------------------------------------------
        // في حالة كانت الفاتورة حوالة بنكية
        elseif($this->type == 3){
            DB::beginTransaction();
            try {
                // في حالة التعديل
                if($this->updateMode){
                    $single_invoices = invoice::findorfail($this->single_invoice_id);
                    $single_invoices->invoice_date = date('Y-m-d');
                    $single_invoices->client_id = $this->client_id;
                    $single_invoices->product_id = $this->product_id;
                    $single_invoices->price = $this->price;
                    $single_invoices->discount_value = $this->discount_value;
                    $single_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $single_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $single_invoices->total_with_tax = $single_invoices->price -  $single_invoices->discount_value + $single_invoices->tax_value;
                    $single_invoices->type = $this->type;
                    $single_invoices->save();

                    $fund_accounts = fund_account::where('invoice_id',$this->single_invoice_id)->first();
                    $fund_accounts->date = date('Y-m-d');
                    $fund_accounts->invoice_id = $single_invoices->id;
                    $fund_accounts->Debit = $single_invoices->total_with_tax;
                    $fund_accounts->credit = 0.00;
                    $fund_accounts->save();
                    $this->InvoiceUpdated =true;
                    $this->show_table =true;

                    if($single_invoices->invoice_status == 2){
                        $client = Client::where('id', '=', $this->client_id)->get();
                        $user_create_id = $this->user_id;
                        $invoice_id = $single_invoices->id;
                        $message = __('Dashboard/main-header_trans.nicasebanktransferup');
                        Notification::send($client, new paymentgateways($user_create_id, $invoice_id, $message));

                        $mailclient = Client::findorFail($this->client_id);
                        $nameclient = $mailclient->name;
                        $url = url('en/Invoices/print/'.$invoice_id);
                        Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
                    }

                }
                // في حالة الاضافة
                else{
                    $number = random_int('100000', '2000000000');
                    $single_invoices = new invoice();
                    $single_invoices->invoice_number = $number;
                    $single_invoices->invoice_classify = 1;
                    $single_invoices->invoice_date = date('Y-m-d');
                    $single_invoices->client_id = $this->client_id;
                    $single_invoices->product_id = $this->product_id;
                    $single_invoices->price = $this->price;
                    $single_invoices->discount_value = $this->discount_value;
                    $single_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $single_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $single_invoices->total_with_tax = $single_invoices->price -  $single_invoices->discount_value + $single_invoices->tax_value;
                    $single_invoices->type = $this->type;
                    $single_invoices->invoice_status = 1;
                    $single_invoices->user_id = auth()->user()->id;
                    $single_invoices->save();

                    $fund_accounts = new fund_account();
                    $fund_accounts->date = date('Y-m-d');
                    $fund_accounts->invoice_id = $single_invoices->id;
                    $fund_accounts->Debit = $single_invoices->total_with_tax;
                    $fund_accounts->credit = 0.00;
                    $fund_accounts->user_id = auth()->user()->id;
                    $fund_accounts->save();

                    $this->InvoiceSaved =true;
                    $this->show_table =true;

                }
                DB::commit();
            }
            catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        }
        // في حالة كانت الفاتورة بطاقة
        elseif($this->type == 4){
            DB::beginTransaction();
            try {
                // في حالة التعديل
                if($this->updateMode){
                    $single_invoices = invoice::findorfail($this->single_invoice_id);
                    $single_invoices->invoice_date = date('Y-m-d');
                    $single_invoices->client_id = $this->client_id;
                    $single_invoices->product_id = $this->product_id;
                    $single_invoices->price = $this->price;
                    $single_invoices->discount_value = $this->discount_value;
                    $single_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $single_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $single_invoices->total_with_tax = $single_invoices->price -  $single_invoices->discount_value + $single_invoices->tax_value;
                    $single_invoices->type = $this->type;
                    $single_invoices->save();

                    $fund_accounts = fund_account::where('invoice_id',$this->single_invoice_id)->first();
                    $fund_accounts->date = date('Y-m-d');
                    $fund_accounts->invoice_id = $single_invoices->id;
                    $fund_accounts->Debit = $single_invoices->total_with_tax;
                    $fund_accounts->credit = 0.00;
                    $fund_accounts->save();
                    $this->InvoiceUpdated =true;
                    $this->show_table =true;

                    if($single_invoices->invoice_status == 2){
                        $client = Client::where('id', '=', $this->client_id)->get();
                        $user_create_id = $this->user_id;
                        $invoice_id = $single_invoices->id;
                        $message = __('Dashboard/main-header_trans.nicasepymgtwup');
                        Notification::send($client, new banktransferntf($user_create_id, $invoice_id, $message));

                        $mailclient = Client::findorFail($this->client_id);
                        $nameclient = $mailclient->name;
                        $url = url('en/Invoices/print/'.$invoice_id);
                        Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
                    }
                }
                // في حالة الاضافة
                else{
                    $number = random_int('100000', '2000000000');
                    $single_invoices = new invoice();
                    $single_invoices->invoice_number = $number;
                    $single_invoices->invoice_classify = 1;
                    $single_invoices->invoice_date = date('Y-m-d');
                    $single_invoices->client_id = $this->client_id;
                    $single_invoices->product_id = $this->product_id;
                    $single_invoices->price = $this->price;
                    $single_invoices->discount_value = $this->discount_value;
                    $single_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $single_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $single_invoices->total_with_tax = $single_invoices->price -  $single_invoices->discount_value + $single_invoices->tax_value;
                    $single_invoices->type = $this->type;
                    $single_invoices->invoice_status = 1;
                    $single_invoices->user_id = auth()->user()->id;
                    $single_invoices->save();

                    $fund_accounts = new fund_account();
                    $fund_accounts->date = date('Y-m-d');
                    $fund_accounts->invoice_id = $single_invoices->id;
                    $fund_accounts->Debit = $single_invoices->total_with_tax;
                    $fund_accounts->credit = 0.00;
                    $fund_accounts->user_id = auth()->user()->id;
                    $fund_accounts->save();

                    $this->InvoiceSaved =true;
                    $this->show_table =true;

                }
                DB::commit();
            }
            catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        }
    }

    public function print($id)
    {
        $single_invoice = invoice::findorfail($id);
        return Redirect::route('Print_single_invoices',[
            'invoice_number' => $single_invoice->invoice_number,
            'invoice_date' => $single_invoice->invoice_date,
            'Clientname' => $single_invoice->Client->name,
            'Clientphone' => $single_invoice->Client->phone,
            'Service_id' => $single_invoice->Service->name,
            'type' => $single_invoice->type,
            'price' => $single_invoice->price,
            'discount_value' => $single_invoice->discount_value,
            'tax_rate' => $single_invoice->tax_rate,
            'total_with_tax' => $single_invoice->total_with_tax,
            'nameUserCreateinvoice' => $single_invoice->user->name,
            'phoneUserCreateinvoice' => $single_invoice->user->phone,
            'emailUserCreateinvoice' => $single_invoice->user->email
        ]);
    }

    public function invoicestatus($id)
    {
        $single_invoice = invoice::findorfail($id);

        if($single_invoice->invoice_status != '2')
        {
            try {
                DB::beginTransaction();

                // في حالة كانت الفاتورة لم يتم الاختيار بعد
                if($single_invoice->type == 0){
                    $single_invoice->invoice_status = '2';
                    $single_invoice->save();

                    $client = Client::where('id', '=', $single_invoice->client_id)->get();
                    $user_create_id = $single_invoice->user_id;
                    $invoice_id = $single_invoice->id;
                    $message = __('Dashboard/main-header_trans.nicase');
                    Notification::send($client, new invoicent($user_create_id, $invoice_id, $message));

                    $mailclient = Client::findorFail($single_invoice->client_id);
                    $nameclient = $mailclient->name;
                    $url = url('en/Invoices/print/'.$invoice_id);
                    Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
                    DB::commit();
                    toastr()->success(trans('Dashboard/messages.beensent'));
                }

                // في حالة كانت الفاتورة نقدي
                if($single_invoice->type == 1){
                    $single_invoice->invoice_status = '2';
                    $single_invoice->save();

                    $client = Client::where('id', '=', $single_invoice->client_id)->get();
                    $user_create_id = $single_invoice->user_id;
                    $invoice_id = $single_invoice->id;
                    $message = __('Dashboard/main-header_trans.nicasemontary');
                    Notification::send($client, new montaryinvoice($user_create_id, $invoice_id, $message));

                    $mailclient = Client::findorFail($single_invoice->client_id);
                    $nameclient = $mailclient->name;
                    $url = url('en/Invoices/print/'.$invoice_id);
                    Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
                    DB::commit();
                    toastr()->success(trans('Dashboard/messages.beensent'));
                }

                // في حالة كانت الفاتورة اجل
                if($single_invoice->type == 2){
                    $single_invoice->invoice_status = '2';
                    $single_invoice->save();

                    $client = Client::where('id', '=', $single_invoice->client_id)->get();
                    $user_create_id = $single_invoice->user_id;
                    $invoice_id = $single_invoice->id;
                    $message = __('Dashboard/main-header_trans.nicasepostpaid');
                    Notification::send($client, new postpaidbillinvoice($user_create_id, $invoice_id, $message));

                    $mailclient = Client::findorFail($single_invoice->client_id);
                    $nameclient = $mailclient->name;
                    $url = url('en/Invoices/print/'.$invoice_id);
                    Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
                    DB::commit();
                    toastr()->success(trans('Dashboard/messages.beensent'));
                }

                // في حالة كانت الفاتورة حوالة بنكية
                if($single_invoice->type == 3){
                    $single_invoice->invoice_status = '2';
                    $single_invoice->save();

                    $client = Client::where('id', '=', $single_invoice->client_id)->get();
                    $user_create_id = $single_invoice->user_id;
                    $invoice_id = $single_invoice->id;
                    $message = __('Dashboard/main-header_trans.nicasepymgtw');
                    Notification::send($client, new banktransferntf($user_create_id, $invoice_id, $message));

                    $mailclient = Client::findorFail($single_invoice->client_id);
                    $nameclient = $mailclient->name;
                    $url = url('en/Invoices/print/'.$invoice_id);
                    Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
                    DB::commit();
                    toastr()->success(trans('Dashboard/messages.beensent'));
                }

                // في حالة كانت الفاتورة بطاقة
                if($single_invoice->type == 4){
                    $single_invoice->invoice_status = '2';
                    $single_invoice->save();

                    $client = Client::where('id', '=', $single_invoice->client_id)->get();
                    $user_create_id = $single_invoice->user_id;
                    $invoice_id = $single_invoice->id;
                    $message = __('Dashboard/main-header_trans.nicasebanktransfer');
                    Notification::send($client, new paymentgateways($user_create_id, $invoice_id, $message));

                    $mailclient = Client::findorFail($single_invoice->client_id);
                    $nameclient = $mailclient->name;
                    $url = url('en/Invoices/print/'.$invoice_id);
                    Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
                    DB::commit();
                    toastr()->success(trans('Dashboard/messages.beensent'));
                }
            }
            catch (\Exception $e) {
                DB::rollback();
                toastr()->error(trans('Dashboard/messages.error'));
            }
        }
        else{
            toastr()->error(trans('Dashboard/messages.beensent'));
        }
    }

    public function delete($id){
        $this->single_invoice_id = $id;
    }

    public function destroy(){
        invoice::destroy($this->single_invoice_id);
        return redirect()->to('/single_invoices');
    }
}
