<?php 

namespace App\Interfaces;

use Illuminate\Http\Request;

interface MenuInterfaces {
    public function getAllData();
    public function createData(Request $request);
}