<?php

namespace App\Http\Livewire;

use App\Mail\banktransferMailMarkdown;
use App\Mail\mailclient;
use App\Models\banktransfer;
use App\Models\Client;
use App\Models\client_account;
use App\Models\fund_account;
use App\Models\groupprodcut;
use App\Models\invoice;
use App\Models\paymentgateway;
use App\Notifications\banktransferntf;
use App\Notifications\montaryinvoice;
use App\Notifications\invoicent;
use App\Notifications\paymentgateways;
use App\Notifications\postpaidbillinvoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class GroupInvoices extends Component
{
    public $InvoiceSaved = false;
    public $InvoiceUpdated = false;
    public $show_table = true;
    public $updateMode = false;
    public $user_id;
    public $group_invoice_id;
    public $groupprodcut_id;
    public $catchError;
    public $price = 0;
    public $client_id,$type;
    public $discount_value = 0;
    public $tax_rate = 0;
    public $tax_value = 0;

    public function mount(){
        $this->user_id = auth()->user()->id;
    }

    public function render()
    {
        return view('livewire.group_invoices.group-invoices',[
            'group_invoices'=>invoice::latest()->where('invoice_classify',2)->get(),
            'Clients'=> Client::all(),
            'Groups'=> groupprodcut::all(),
            'subtotal' => $Total_after_discount = ((is_numeric($this->price) ? $this->price : 0)) - ((is_numeric($this->discount_value) ? $this->discount_value : 0)),
            'tax_value'=> $Total_after_discount * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100)
        ]);
    }

    public function show_form_add(){
        $this->show_table = false;
    }

    public function get_price()
    {
        $this->price = groupprodcut::where('id', $this->groupprodcut_id)->first()->Total_before_discount;
        $this->discount_value = groupprodcut::where('id', $this->groupprodcut_id)->first()->discount_value;
        $this->tax_rate = groupprodcut::where('id', $this->groupprodcut_id)->first()->tax_rate;
    }

    public function edit($id){
        $this->show_table = false;
        $this->updateMode = true;
        $group_invoice = Invoice::findorfail($id);
        $this->group_invoice_id = $group_invoice->id;
        $this->client_id = $group_invoice->client_id;
        $this->groupprodcut_id = $group_invoice->groupprodcut_id;
        $this->price = $group_invoice->price;
        $this->discount_value = $group_invoice->discount_value;
        $this->tax_rate = $group_invoice->tax_rate;
        $this->tax_value = $group_invoice->tax_value;
        $this->type = $group_invoice->type;
    }

    public function store()
    {
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

                    $client = Client::where('id', '=', $this->client_id)->get();
                    $user_create_id = $this->user_id;
                    $invoice_id = $single_invoices->id;
                    $message = __('Dashboard/main-header_trans.nicaseup');
                    Notification::send($client, new montaryinvoice($user_create_id, $invoice_id, $message));

                    $mailclient = Client::findorFail($this->client_id);
                    $nameclient = $mailclient->name;
                    $url = url('en/Invoices/showinvoicemonetary/'.$invoice_id);
                    Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
                }
                // في حالة الاضافة
                else{
                    $number = random_int('100000', '2000000000');
                    $single_invoices = new invoice();
                    $single_invoices->invoice_number = $number;
                    $single_invoices->invoice_classify = 2;
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

                    $client = Client::where('id', '=', $this->client_id)->get();
                    $user_create_id = $this->user_id;
                    $invoice_id = $single_invoices->id;
                    $message = __('Dashboard/main-header_trans.nicase');
                    Notification::send($client, new invoicent($user_create_id, $invoice_id, $message));

                    $mailclient = Client::findorFail($this->client_id);
                    $nameclient = $mailclient->name;
                    $url = url('en/Invoices/showinvoice/'.$invoice_id);
                    Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));

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

                    $group_invoices = Invoice::findorfail($this->group_invoice_id);
                    $group_invoices->invoice_date = date('Y-m-d');
                    $group_invoices->client_id = $this->client_id;
                    $group_invoices->groupprodcut_id = $this->groupprodcut_id;
                    $group_invoices->price = $this->price;
                    $group_invoices->discount_value = $this->discount_value;
                    $group_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $group_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $group_invoices->total_with_tax = $group_invoices->price -  $group_invoices->discount_value + $group_invoices->tax_value;
                    $group_invoices->type = $this->type;
                    $group_invoices->save();

                    $fund_accounts = fund_account::where('invoice_id',$this->group_invoice_id)->first();
                    $fund_accounts->date = date('Y-m-d');
                    $fund_accounts->invoice_id = $group_invoices->id;
                    $fund_accounts->Debit = $group_invoices->total_with_tax;
                    $fund_accounts->credit = 0.00;
                    $fund_accounts->save();
                    $this->InvoiceUpdated =true;
                    $this->show_table =true;

                    $client = Client::where('id', '=', $this->client_id)->get();
                    $user_create_id = $this->user_id;
                    $invoice_id = $group_invoices->id;
                    $message = __('Dashboard/main-header_trans.nicasemontaryup');
                    Notification::send($client, new montaryinvoice($user_create_id, $invoice_id, $message));

                    $mailclient = Client::findorFail($this->client_id);
                    $nameclient = $mailclient->name;
                    $url = url('en/Invoices/showinvoicemonetary/'.$invoice_id);
                    Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));

                }
                // في حالة الاضافة
                else{
                    $number = random_int('100000', '2000000000');
                    $group_invoices = new invoice();
                    $group_invoices->invoice_number = $number;
                    $group_invoices->invoice_classify = 2;
                    $group_invoices->invoice_date = date('Y-m-d');
                    $group_invoices->client_id = $this->client_id;
                    $group_invoices->groupprodcut_id = $this->groupprodcut_id;
                    $group_invoices->price = $this->price;
                    $group_invoices->discount_value = $this->discount_value;
                    $group_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $group_invoices->tax_value = ($this->price - $this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $group_invoices->total_with_tax = $group_invoices->price -  $group_invoices->discount_value + $group_invoices->tax_value;
                    $group_invoices->type = $this->type;
                    $group_invoices->user_id = auth()->user()->id;
                    $group_invoices->save();

                    $fund_accounts = new fund_account();
                    $fund_accounts->date = date('Y-m-d');
                    $fund_accounts->invoice_id = $group_invoices->id;
                    $fund_accounts->Debit = $group_invoices->total_with_tax;
                    $fund_accounts->credit = 0.00;
                    $fund_accounts->user_id = auth()->user()->id;
                    $fund_accounts->save();
                    $this->InvoiceSaved =true;
                    $this->show_table =true;

                    $client = Client::where('id', '=', $this->client_id)->get();
                    $user_create_id = $this->user_id;
                    $invoice_id = $group_invoices->id;
                    $message = __('Dashboard/main-header_trans.nicasemontary');
                    Notification::send($client, new montaryinvoice($user_create_id, $invoice_id, $message));

                    $mailclient = Client::findorFail($this->client_id);
                    $nameclient = $mailclient->name;
                    $url = url('en/Invoices/showinvoicemonetary/'.$invoice_id);
                    Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
                }
                DB::commit();
            }
            catch (\Exception $e) {
                $this->catchError = $e->getMessage();
            }
        }
        //----------------------------------------------------------------------------------------------------
        // في حالة الفاتورة اجل
        elseif($this->type == 2){
            DB::beginTransaction();
            try {
                // في حالة التعديل
                if($this->updateMode){
                    $group_invoices = invoice::findorfail($this->group_invoice_id);
                    $group_invoices->invoice_date = date('Y-m-d');
                    $group_invoices->client_id = $this->client_id;
                    $group_invoices->groupprodcut_id = $this->groupprodcut_id;
                    $group_invoices->price = $this->price;
                    $group_invoices->discount_value = $this->discount_value;
                    $group_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $group_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $group_invoices->total_with_tax = $group_invoices->price -  $group_invoices->discount_value + $group_invoices->tax_value;
                    $group_invoices->type = $this->type;
                    $group_invoices->save();

                    $client_accounts = client_account::where('invoice_id',$this->group_invoice_id)->first();
                    $client_accounts->date = date('Y-m-d');
                    $client_accounts->invoice_id = $group_invoices->id;
                    $client_accounts->patient_id = $group_invoices->patient_id;
                    $client_accounts->Debit = $group_invoices->total_with_tax;
                    $client_accounts->credit = 0.00;
                    $client_accounts->save();
                    $this->InvoiceUpdated =true;
                    $this->show_table =true;

                    $client = Client::where('id', '=', $this->client_id)->get();
                    $user_create_id = $this->user_id;
                    $invoice_id = $group_invoices->id;
                    $message = __('Dashboard/main-header_trans.nicasepostpaidup');
                    Notification::send($client, new postpaidbillinvoice($user_create_id, $invoice_id, $message));

                    $mailclient = Client::findorFail($this->client_id);
                    $nameclient = $mailclient->name;
                    $url = url('en/Invoices/showinvoicePostpaid/'.$invoice_id);
                    Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
                }

                // في حالة الاضافة
                else{

                    $number = random_int('100000', '2000000000');
                    $group_invoices = new invoice();
                    $group_invoices->invoice_number = $number;
                    $group_invoices->invoice_classify = 2;
                    $group_invoices->invoice_date = date('Y-m-d');
                    $group_invoices->client_id = $this->client_id;
                    $group_invoices->groupprodcut_id = $this->groupprodcut_id;
                    $group_invoices->price = $this->price;
                    $group_invoices->discount_value = $this->discount_value;
                    $group_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $group_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $group_invoices->total_with_tax = $group_invoices->price -  $group_invoices->discount_value + $group_invoices->tax_value;
                    $group_invoices->type = $this->type;
                    $group_invoices->user_id = auth()->user()->id;
                    $group_invoices->save();

                    $client_accounts = new client_account();
                    $client_accounts->date = date('Y-m-d');
                    $client_accounts->invoice_id = $group_invoices->id;
                    $client_accounts->client_id = $group_invoices->client_id;
                    $client_accounts->Debit = $group_invoices->total_with_tax;
                    $client_accounts->credit = 0.00;
                    $client_accounts->user_id = auth()->user()->id;
                    $client_accounts->save();
                    $this->InvoiceSaved =true;
                    $this->show_table =true;

                    $client = Client::where('id', '=', $this->client_id)->get();
                    $user_create_id = $this->user_id;
                    $invoice_id = $group_invoices->id;
                    $message = __('Dashboard/main-header_trans.nicasepostpaid');
                    Notification::send($client, new postpaidbillinvoice($user_create_id, $invoice_id, $message));

                    $mailclient = Client::findorFail($this->client_id);
                    $nameclient = $mailclient->name;
                    $url = url('en/Invoices/showinvoicePostpaid/'.$invoice_id);
                    Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
                }
                DB::commit();
            }
            catch (\Exception $e) {
                $this->catchError = $e->getMessage();
            }
        }
        //------------------------------------------------------------------------
        // في حالة كانت الفاتورة حوالة بنكية
        elseif($this->type == 3){
            DB::beginTransaction();
            try {
                // في حالة التعديل
                if($this->updateMode){
                    $group_invoices = invoice::findorfail($this->group_invoice_id);
                    $group_invoices->invoice_date = date('Y-m-d');
                    $group_invoices->client_id = $this->client_id;
                    $group_invoices->groupprodcut_id = $this->groupprodcut_id;
                    $group_invoices->price = $this->price;
                    $group_invoices->discount_value = $this->discount_value;
                    $group_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $group_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $group_invoices->total_with_tax = $group_invoices->price -  $group_invoices->discount_value + $group_invoices->tax_value;
                    $group_invoices->type = $this->type;
                    $group_invoices->save();

                    $paymentgateways = paymentgateway::where('invoice_id',$this->group_invoice_id)->first();
                    $paymentgateways->date = date('Y-m-d');
                    $paymentgateways->invoice_id = $group_invoices->id;
                    $paymentgateways->patient_id = $group_invoices->patient_id;
                    $paymentgateways->Debit = $group_invoices->total_with_tax;
                    $paymentgateways->credit = 0.00;
                    $paymentgateways->save();
                    $this->InvoiceUpdated =true;
                    $this->show_table =true;

                    $client = Client::where('id', '=', $this->client_id)->get();
                    $user_create_id = $this->user_id;
                    $invoice_id = $group_invoices->id;
                    $message = __('Dashboard/main-header_trans.nicasebanktransferup');
                    Notification::send($client, new paymentgateways($user_create_id, $invoice_id, $message));

                    $mailclient = Client::findorFail($this->client_id);
                    $nameclient = $mailclient->name;
                    $url = url('en/Invoices/showinvoicebanktransfer/'.$invoice_id);
                    Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
                }
                // في حالة الاضافة
                else{
                    $number = random_int('100000', '2000000000');
                    $group_invoices = new invoice();
                    $group_invoices->invoice_number = $number;
                    $group_invoices->invoice_classify = 2;
                    $group_invoices->invoice_date = date('Y-m-d');
                    $group_invoices->client_id = $this->client_id;
                    $group_invoices->groupprodcut_id = $this->groupprodcut_id;
                    $group_invoices->price = $this->price;
                    $group_invoices->discount_value = $this->discount_value;
                    $group_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $group_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $group_invoices->total_with_tax = $group_invoices->price -  $group_invoices->discount_value + $group_invoices->tax_value;
                    $group_invoices->type = $this->type;
                    $group_invoices->user_id = auth()->user()->id;
                    $group_invoices->save();

                    $paymentgateways = new paymentgateway();
                    $paymentgateways->date = date('Y-m-d');
                    $paymentgateways->invoice_id = $group_invoices->id;
                    $paymentgateways->client_id = $group_invoices->client_id;
                    $paymentgateways->Debit = $group_invoices->total_with_tax;
                    $paymentgateways->credit = 0.00;
                    $paymentgateways->user_id = auth()->user()->id;
                    $paymentgateways->save();
                    $this->InvoiceSaved =true;
                    $this->show_table =true;

                    $client = Client::where('id', '=', $this->client_id)->get();
                    $user_create_id = $this->user_id;
                    $invoice_id = $group_invoices->id;
                    $message = __('Dashboard/main-header_trans.nicasebanktransfer');
                    Notification::send($client, new paymentgateways($user_create_id, $invoice_id, $message));

                    $mailclient = Client::findorFail($this->client_id);
                    $nameclient = $mailclient->name;
                    $url = url('en/Invoices/showinvoicebanktransfer/'.$invoice_id);
                    Mail::to($mailclient->email)->send(new mailclient($message, $nameclient, $url));
                }
                DB::commit();
            }
            catch (\Exception $e) {
                $this->catchError = $e->getMessage();
            }
        }
        // في حالة كانت الفاتورة بطاقة
        elseif($this->type == 4){
            DB::beginTransaction();
            try {
                // في حالة التعديل
                if($this->updateMode){
                    $group_invoices = invoice::findorfail($this->group_invoice_id);
                    $group_invoices->invoice_date = date('Y-m-d');
                    $group_invoices->client_id = $this->client_id;
                    $group_invoices->product_id = $this->product_id;
                    $group_invoices->price = $this->price;
                    $group_invoices->discount_value = $this->discount_value;
                    $group_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $group_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $group_invoices->total_with_tax = $group_invoices->price -  $group_invoices->discount_value + $group_invoices->tax_value;
                    $group_invoices->type = $this->type;
                    $group_invoices->save();

                    $paymentgateways = banktransfer::where('invoice_id',$this->group_invoice_id)->first();
                    $paymentgateways->date = date('Y-m-d');
                    $paymentgateways->invoice_id = $group_invoices->id;
                    $paymentgateways->client_id = $group_invoices->client_id;
                    $paymentgateways->Debit = $group_invoices->total_with_tax;
                    $paymentgateways->credit = 0.00;
                    $paymentgateways->save();
                    $this->InvoiceUpdated =true;
                    $this->show_table =true;

                    $client = Client::where('id', '=', $this->client_id)->get();
                    $user_create_id = $this->user_id;
                    $invoice_id = $group_invoices->id;
                    $message = __('Dashboard/main-header_trans.nicasepymgtwup');
                    Notification::send($client, new banktransferntf($user_create_id, $invoice_id, $message));

                    $mailclient = Client::findorFail($this->client_id);
                    $nameclient = $mailclient->name;
                    $url = url('en/Invoices/showinvoicecard/'.$invoice_id);
                    Mail::to($mailclient->email)->send(new banktransferMailMarkdown($message, $nameclient, $url));

                }
                // في حالة الاضافة
                else{
                    $number = random_int('100000', '2000000000');
                    $group_invoices = new invoice();
                    $group_invoices->invoice_number = $number;
                    $group_invoices->invoice_classify = 2;
                    $group_invoices->invoice_date = date('Y-m-d');
                    $group_invoices->client_id = $this->client_id;
                    $group_invoices->product_id = $this->product_id;
                    $group_invoices->price = $this->price;
                    $group_invoices->discount_value = $this->discount_value;
                    $group_invoices->tax_rate = $this->tax_rate;
                    // قيمة الضريبة = السعر - الخصم * نسبة الضريبة /100
                    $group_invoices->tax_value = ($this->price -$this->discount_value) * ((is_numeric($this->tax_rate) ? $this->tax_rate : 0) / 100);
                    // الاجمالي شامل الضريبة  = السعر - الخصم + قيمة الضريبة
                    $group_invoices->total_with_tax = $group_invoices->price -  $group_invoices->discount_value + $group_invoices->tax_value;
                    $group_invoices->type = $this->type;
                    $group_invoices->invoice_status = 1;
                    $group_invoices->user_id = auth()->user()->id;
                    $group_invoices->save();

                    $paymentgateways = new banktransfer();
                    $paymentgateways->date = date('Y-m-d');
                    $paymentgateways->invoice_id = $group_invoices->id;
                    $paymentgateways->client_id = $group_invoices->client_id;
                    $paymentgateways->Debit = $group_invoices->total_with_tax;
                    $paymentgateways->credit = 0.00;
                    $paymentgateways->user_id = auth()->user()->id;
                    $paymentgateways->save();

                    $this->InvoiceSaved =true;
                    $this->show_table =true;

                    $client = Client::where('id', '=', $this->client_id)->get();
                    $user_create_id = $this->user_id;
                    $invoice_id = $group_invoices->id;
                    $message = __('Dashboard/main-header_trans.nicasepymgtw');
                    Notification::send($client, new banktransferntf($user_create_id, $invoice_id, $message));

                    $mailclient = Client::findorFail($this->client_id);
                    $nameclient = $mailclient->name;
                    $url = url('en/Invoices/showinvoicecard/'.$invoice_id);
                    Mail::to($mailclient->email)->send(new banktransferMailMarkdown($message, $nameclient, $url));

                }
                DB::commit();
            }
            catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        }
    }

    public function delete($id){
        $this->group_invoice_id = $id;
    }

    public function destroy(){
        Invoice::destroy($this->group_invoice_id);
        return redirect()->to('/group_invoices');
    }

    public function print($id)
    {
        $single_invoice = invoice::findorfail($id);
        return Redirect::route('group_Print_group_invoices',[
            'invoice_date' => $single_invoice->invoice_date,
            'Clientname' => $single_invoice->Client->name,
            'Clientphone' => $single_invoice->Client->phone,
            'Group_id' => $single_invoice->Group->name,
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
}
