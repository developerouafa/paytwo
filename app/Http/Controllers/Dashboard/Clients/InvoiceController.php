<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Interfaces\Clients\Invoices\InvoiceRepositoryInterface;

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
}
