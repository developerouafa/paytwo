<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sections\StoreSectionRequest;
use App\Http\Requests\Sections\UpdateSectionRequest;
use App\Interfaces\Sections\SectionRepositoryInterface;
use Illuminate\Http\Request;

class SectionController extends Controller
{

    private $Sections;

    public function __construct(SectionRepositoryInterface $Sections)
    {
        $this->Sections = $Sections;
    }

    public function index()
    {
      return  $this->Sections->index();

    }

    public function show($id)
    {
       return $this->Sections->show($id);
    }

    public function store(StoreSectionRequest $request)
    {
        return $this->Sections->store($request);
    }


    public function update(UpdateSectionRequest $request)
    {
        return $this->Sections->update($request);
    }


    public function destroy(Request $request)
    {
        return $this->Sections->destroy($request);
    }
}
