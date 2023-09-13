<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Repositories\JenisProductRepositories;
use Illuminate\Http\Request;

class JenisProductController extends Controller
{
    protected $jenisProductRepositories;
    public function __construct(JenisProductRepositories $jenisProductRepositories)
    {
        $this->jenisProductRepositories = $jenisProductRepositories;
    }

    public function getAllData()
    {
        return $this->jenisProductRepositories->getAllData();
    }

    public function createData(Request $request)
    {
        return $this->jenisProductRepositories->createData($request);
    }

    public function generateProductCode()
    {
        return $this->jenisProductRepositories->generateProductCode();
    }
    public function getDataById($id)
    {
        return $this->jenisProductRepositories->getDataById($id);
    }
    public function updateData(Request $request, $id)
    {
        return $this->jenisProductRepositories->updateData($request, $id);
    }
    public function deleteData($id)
    {
        return $this->jenisProductRepositories->deleteData($id);
    }
}
