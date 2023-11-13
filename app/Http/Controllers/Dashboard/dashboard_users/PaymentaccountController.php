<?php

namespace App\Http\Controllers\Dashboard\dashboard_users;

use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard_user\PaymentRequest;
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

    public function softdelete()
    {
      return  $this->Payment->softdelete();
    }

    public function create($id)
    {
        return $this->Payment->create($id);
    }

    public function store(PaymentRequest $request)
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

    public function update(PaymentRequest $request)
    {
        return $this->Payment->update($request);
    }

    public function destroy(Request $request)
    {
        return $this->Payment->destroy($request);
    }

    public function deleteall()
    {
        return $this->Payment->deleteall();
    }

    public function restore($id)
    {
        return $this->Payment->restore($id);
    }

    public function restoreallPaymentaccount(){
        return $this->Payment->restoreallPaymentaccount();
    }

    public function restoreallselectPaymentaccount(Request $request){
        return $this->Payment->restoreallselectPaymentaccount($request);
    }
}
