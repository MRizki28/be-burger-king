<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

Interface JenisProductInterfaces {
    public function getAllData();
    public function createData(Request $request);
    public function generateProductCode();
    public function getDataById($id);
    public function updateData(Request $request , $id);
    public function deleteData($id);
}