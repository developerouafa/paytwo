<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentgatewayController extends Controller
{
    private $Bankcard;

    public function __construct(BanktransferRepositoryInterface $Bankcard)
    {
        $this->Bankcard = $Bankcard;
    }

    public function index()
    {
        return $this->Bankcard->index();
    }

    public function softdelete()
    {
      return  $this->Bankcard->softdelete();
    }

    public function show($id)
    {
        return $this->Bankcard->show($id);
    }

    public function destroy(Request $request)
    {
        return $this->Bankcard->destroy($request);
    }

    public function deleteall()
    {
        return $this->Bankcard->deleteall();
    }

    public function restore($id)
    {
        return $this->Bankcard->restore($id);
    }

    public function forcedelete($id)
    {
        return $this->Bankcard->forcedelete($id);
    }
}
