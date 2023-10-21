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
        // validations
        $this->validate($request, [
            'price' => 'required|between:1,99999999999999',
            'start_time' => 'required',
            'end_time' => 'required',
        ],[
            'price.required' =>__('Dashboard/products.priceisrequired'),
            'price.between' =>__('Dashboard/products.priceislow'),
            'start_time.required' =>__('Dashboard/products.start_timerequired'),
            'end_time.required' =>__('Dashboard/products.end_timerequired'),
        ]);
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

    public function deleteall()
    {
      return  $this->Promotion->deleteall();
    }

}
