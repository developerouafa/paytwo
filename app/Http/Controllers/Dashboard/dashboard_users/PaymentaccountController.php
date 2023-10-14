<?php

namespace App\Http\Controllers;

use App\Interfaces\dashboard_user\Finances\PaymentRepositoryInterface;
use Illuminate\Http\Request;

class PaymentaccountController extends Controller
{
    private $Payment;

    public function __construct(PaymentRepositoryInterface $Payment)
    {
        $this->Payment = $Payment;
    }
    public function index()
    {
        return $this->Payment->index();
    }


    public function create()
    {
        return $this->Payment->create();
    }


    public function store(Request $request)
    {
        return $this->Payment->store($request);
    }


    public function show($id)
    {
        return $this->Payment->show($id);
    }


    public function edit($id)
    {
        return $this->Payment->edit($id);
    }


    public function update(Request $request)
    {
        return $this->Payment->update($request);
    }


    public function destroy(Request $request)
    {
        return $this->Payment->destroy($request);
    }
}
