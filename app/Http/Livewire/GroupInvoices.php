<?php

namespace App\Http\Livewire;

use App\Models\Doctor;
use App\Models\FundAccount;
use App\Models\Group;
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
    public $Group_id;
    public $catchError;
    public $price = 0;
    public $patient_id,$doctor_id,$section_id,$type;
    public $discount_value = 0;
    public $tax_rate = 0;



    public function render()
    {
        return view('livewire.group_invoices.group-invoices');
    }

}
