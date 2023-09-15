<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Repositories\MenuRepositories;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $menuRepositories;

    public function __construct(MenuRepositories $menuRepositories)
    {
        $this->menuRepositories = $menuRepositories;
    }

    public function getAllData()
    {
        return $this->menuRepositories->getAllData();
    }
    public function createData(Request $request)
    {
        return $this->menuRepositories->createData($request);
    }
}
