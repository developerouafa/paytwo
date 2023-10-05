<?php

namespace App\Http\Controllers\Dashboard\childrens;

use App\Http\Controllers\Controller;
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
}
