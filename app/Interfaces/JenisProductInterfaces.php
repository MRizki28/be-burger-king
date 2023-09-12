<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

Interface JenisProductInterfaces {
    public function getAllData();
    public function createData(Request $request);
    public function generateProductCode();
    public function getDataById($id);
}