<?php

namespace App\Http\Controllers\Dashboard\childrens;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sections\StorechildrenRequest;
use App\Http\Requests\Sections\UpdatechildrenRequest;
use App\Interfaces\Sections\childrenRepositoryInterface;
use Illuminate\Http\Request;

class childrenController extends Controller
{
    private $Sections;

    public function __construct(childrenRepositoryInterface $Sections)
    {
        $this->Sections = $Sections;
    }

    public function index()
    {
      return  $this->Sections->index();

    }

    public function store(StorechildrenRequest $request)
    {
        return $this->Sections->store($request);
    }

    public function update(UpdatechildrenRequest $request)
    {
        return $this->Sections->update($request);
    }

    public function destroy(Request $request)
    {
        return $this->Sections->destroy($request);
    }
}
