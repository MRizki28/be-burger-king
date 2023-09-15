<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface BannerInterfaces 
{
    public function createData(Request $request);
    public function getAllGambar();
    public function getAllData();
    public function getDataById($id);
    public function updateData(Request $request,$id);
    public function deleteData($id);
}