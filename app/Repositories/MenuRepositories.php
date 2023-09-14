<?php

namespace App\Repositories;

use App\Interfaces\MenuInterfaces;
use App\Models\MenuModel;

class MenuRepositories implements MenuInterfaces
{
    protected $menuModel;

    public function __construct(MenuModel $menuModel)
    {
        $this->menuModel = $menuModel;        
    }

    public function getAllData()
    {
        $data = $this->menuModel::with('JenisProduct')->get();
        return response()->json([
            'message' => 'success',
            'data' => $data
        ], 200);
    }
}