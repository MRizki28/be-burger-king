<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface BannerInterfaces 
{
    public function createData(Request $request);
    public function getAllGambar();
}