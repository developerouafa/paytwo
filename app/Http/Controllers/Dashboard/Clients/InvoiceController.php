<?php

namespace App\Http\Controllers\Dashboard\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Clients\Profiles\CompletedRequest;
use App\Interfaces\Clients\Invoices\InvoiceRepositoryInterface;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    private $invoices;

    public function __construct(InvoiceRepositoryInterface $invoices)
    {
        $this->invoices = $invoices;
    }

    public function index(){
        return  $this->invoices->index();
    }

    public function indexmonetary(){
        return  $this->invoices->indexmonetary();
    }

    public function indexPostpaid(){
        return  $this->invoices->indexPostpaid();
    }

    public function indexcard(){
        return  $this->invoices->indexcard();
    }

    public function indexbanktransfer(){
        return  $this->invoices->indexbanktransfer();
    }

    public function Complete(CompletedRequest $request){
        return  $this->invoices->Complete($request);
    }

    public function Continue($id){
        return  $this->invoices->Continue($id);
    }

    public function modifypymethod(Request $request){
        // validations
        $this->validate($request, [
            'type' => 'required',
        ],[
            'type.required' =>__('Dashboard/clients_trans.type'),
        ]);
        return  $this->invoices->modifypymethod($request);
    }

    public function Confirmpayment(Request $request){
        return  $this->invoices->Confirmpayment($request);
    }

    public function Completepayment($id){
        return  $this->invoices->Completepayment($id);
    }

    public function Errorinpayment($id){
        return  $this->invoices->Errorinpayment($id);
    }

    public function showinvoice($id){
        return  $this->invoices->showinvoice($id);
    }

    public function showinvoicent($id){
        return  $this->invoices->showinvoicent($id);
    }

    public function receipt($id){
        return  $this->invoices->receipt($id);
    }

    public function receiptpostpaid($id){
        return  $this->invoices->receiptpostpaid($id);
    }

    public function showinvoicereceiptnt($id){
        return  $this->invoices->showinvoicereceiptnt($id);
    }

    public function showinvoicereceiptPostpaidnt($id){
        return  $this->invoices->showinvoicereceiptPostpaidnt($id);
    }

    public function print($id){
        return  $this->invoices->print($id);
    }

    public function printreceipt($id){
        return  $this->invoices->printreceipt($id);
    }

    public function printpostpaid($id){
        return  $this->invoices->printpostpaid($id);
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
