<?php

namespace App\Http\Livewire;

use App\Models\Client;
use App\Models\client_account;
use App\Models\fund_account;
use App\Models\groupprodcut;
use App\Models\invoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class GroupInvoices extends Component
{
    public $InvoiceSaved = false;
    public $InvoiceUpdated = false;
    public $show_table = true;
    public $updateMode = false;
    public $group_invoice_id;
    public $groupprodcut_id;
    public $catchError;
    public $price = 0;
    public $client_id,$type;
    public $discount_value = 0;
    public $tax_rate = 0;
    public $tax_value = 0;

    public function render()
    {
        return view('livewire.group_invoices.group-invoices',[
            'group_invoices'=>invoice::where('invoice_number',2)->get(),
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
        $group_invoices = Invoice::findorfail($id);
        $this->group_invoice_id = $group_invoices->id;
        $this->client_id = $group_invoices->client_id;
        $this->groupprodcut_id = $group_invoices->groupprodcut_id;
        $this->price = $group_invoices->price;
        $this->discount_value = $group_invoices->discount_value;
        $this->tax_rate = $group_invoices->tax_rate;
        $this->tax_value = $group_invoices->tax_value;
        $this->type = $group_invoices->type;
    }

    public function store()
    {

        // في حالة كانت الفاتورة نقدي
        if($this->type == 1){

            DB::beginTransaction();

            try {
                // في حالة التعديل
                if($this->updateMode){



                }

                // في حالة الاضافة
                else{

                    $group_invoices = new invoice();
                    $group_invoices->invoice_number = 2;
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
                    $group_invoices->save();

                    $fund_accounts = new fund_account();
                    $fund_accounts->date = date('Y-m-d');
                    $fund_accounts->invoice_id = $group_invoices->id;
                    $fund_accounts->Debit = $group_invoices->total_with_tax;
                    $fund_accounts->credit = 0.00;
                    $fund_accounts->save();
                    $this->InvoiceSaved =true;
                    $this->show_table =true;
                }
                DB::commit();
            }
            catch (\Exception $e) {
                $this->catchError = $e->getMessage();
            }

        }

        //----------------------------------------------------------------------------------------------------

        // في حالة الفاتورة اجل

        else{

            DB::beginTransaction();
            try {
                // في حالة التعديل
                if($this->updateMode){


                }

                // في حالة الاضافة
                else{


                    $group_invoices = new invoice();
                    $group_invoices->invoice_number = 2;
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

                    $client_accounts = new client_account();
                    $client_accounts->date = date('Y-m-d');
                    $client_accounts->invoice_id = $group_invoices->id;
                    $client_accounts->client_id = $group_invoices->client_id;
                    $client_accounts->Debit = $group_invoices->total_with_tax;
                    $client_accounts->credit = 0.00;
                    $client_accounts->save();
                    $this->InvoiceSaved =true;
                    $this->show_table =true;
                }
                DB::commit();
            }
            catch (\Exception $e) {
                $this->catchError = $e->getMessage();
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
}