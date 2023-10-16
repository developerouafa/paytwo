<?php

namespace App\Http\Controllers\Dashboard\dashboard_users\Products;

use App\Http\Controllers\Controller;
use App\Http\Requests\dashboard_user\Products\StorePromotionRequest;
use App\Interfaces\dashboard_user\Products\promotionRepositoryInterface;
use Illuminate\Http\Request;

class PromotionController extends Controller
{
    private $Promotion;

    public function __construct(promotionRepositoryInterface $Promotion)
    {
        $this->Promotion = $Promotion;
    }

    public function index($id)
    {
      return  $this->Promotion->index($id);
    }

    public function store(StorePromotionRequest $request)
    {
        return $this->Promotion->store($request);
    }

    public function update(Request $request)
    {
        return $this->Promotion->update($request);
    }

    public function editstatusdéactive($id)
    {
        return $this->Promotion->editstatusdéactive($id);
    }

    public function editstatusactive($id)
    {
        return $this->Promotion->editstatusactive($id);
    }

    public function destroy(Request $request)
    {
        return $this->Promotion->destroy($request);
    }
}
