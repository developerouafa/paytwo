<?php

namespace App\Http\Controllers\Dashboard\Clients;

use App\Http\Controllers\Controller;
use App\Interfaces\Clients\Invoices\InvoiceRepositoryInterface;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    private $invoices;

    public function __construct(InvoiceRepositoryInterface $invoices)
    {
        $this->invoices = $invoices;
    }

    public function indexmonetary(){
        return  $this->invoices->indexmonetary();
    }

    public function indexPostpaid(){
        return  $this->invoices->indexPostpaid();
    }

    public function indexBanktransfer(){
        return  $this->invoices->indexBanktransfer();
    }

    public function showinvoicemonetary($id){
        return  $this->invoices->showinvoicemonetary($id);
    }

    public function showinvoicePostpaid($id){
        return  $this->invoices->showinvoicePostpaid($id);
    }

    public function showinvoiceBanktransfer($id){
        return  $this->invoices->showinvoiceBanktransfer($id);
    }

    public function confirm(Request $request)
    {
        return  $this->invoices->confirm($request);
    }

    public function checkout()
    {
        return  $this->invoices->checkout();
    }

    public function pay(Request $request)
    {
        return  $this->invoices->pay($request);
    }
}
