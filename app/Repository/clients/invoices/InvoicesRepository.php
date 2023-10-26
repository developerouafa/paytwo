<?php
namespace App\Repository\Clients\Profiles;

use App\Interfaces\Clients\Invoices\InvoiceRepositoryInterface;
use App\Models\invoice;
use Illuminate\Support\Facades\Auth;

class InvoicesRepository implements InvoiceRepositoryInterface
{
    public function index(){
        $invoices = invoice::latest()->where('client_id', Auth::user()->id)->get();
        return view('Dashboard.dashboard_client.invoices.invoices', ['invoices' => $invoices]);
    }
}
