<?php

namespace App\Repositories;

use App\Interfaces\JenisProductInterfaces;
use App\Models\JenisProductModel;
use App\Traits\ValidationTrait;
use Illuminate\Http\Request;

class JenisProductRepositories implements JenisProductInterfaces
{
    use ValidationTrait;

    protected $jenisProductModel;
    public function __construct(JenisProductModel $jenisProductModel)
    {
        $this->jenisProductModel = $jenisProductModel;
    }

    public function getAllData()
    {
        $data = $this->jenisProductModel::all();
        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'Data not found'
            ], 404);
        } else {
            return response()->json([
                'message' => 'success get all data',
                'data' => $data
            ], 200);
        }
    }

    public function createData(Request $request)
    {
        $data = $request->all();

        $validation = [
            'kode_product' => 'required|unique:tb_jenis_product,kode_product',
            'nama_jenis_product' => 'required'
        ];

        $messageCustom = [
            'kode_product.required' => 'Kode product wajib diisi',
            'nama_jenis_product' => 'Jenis product wajib diisi',
            'kode_product.unique' => 'Kode product sudah ada sebelumnya'
        ];

        $this->dataValidation($data, $validation, $messageCustom);

        try {
            $data = new $this->jenisProductModel;
            $data->kode_product = $request->input('kode_product');
            $data->nama_jenis_product = $request->input('nama_jenis_product');
            $data->save();
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage()
            ], 400);
        }

        return response()->json([
            'message' => 'success create data',
            'data' => $data
        ], 200);
    }

    public function generateProductCode()
    {
        $nextCOde = $this->getNextAvailableCode();

        return response()->json([
            'generateCode' => $nextCOde
        ], 200);
    }

    private function getNextAvailableCode()
    {
        $lastProduct = $this->jenisProductModel::orderBy('kode_product', 'desc')->first();
        $kodeAwal = 'JP00001';

        if ($lastProduct) {
            $lastCode = $lastProduct->kode_product;

            $parts = explode('JP', $lastCode);

            $lastNumber = (int)$parts[1];
            $nextNumber = $lastNumber + 1;

            $nextNumberFormat = str_pad($nextNumber, 5, '0', STR_PAD_LEFT);

            $kodeAwal = 'JP' . $nextNumberFormat;
        }

        return $kodeAwal;
    }

    public function getDataById($id)
    {
        try {
            $data = $this->jenisProductModel::where('id', $id)->first();
            if (!$data) {
                return response()->json([
                    'message' => 'Data or id not found'
                ], 404);
            } else {
                return response()->json([
                    'message' => 'success get data by id',
                    'data' => $data
                ], 200);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage()
            ], 400);
        }
    }

    public function updateData(Request $request, $id)
    {
        $data = $request->all();

        $validation = [
            'kode_product' => 'required',
            'nama_jenis_product' => 'required'
        ];

        $messageCustom = [
            'kode_product.required' => 'Kode product wajib diisi',
            'nama_jenis_product' => 'Jenis product wajib diisi',
            'kode_product.unique' => 'Kode product sudah ada sebelumnya'
        ];


        $this->dataValidation($data, $validation, $messageCustom);

        try {
            $data = $this->jenisProductModel::where('id', $id)->first();
            $data->kode_product = $request->input('kode_product');
            $data->nama_jenis_product  = $request->input('nama_jenis_product');
            $data->save();
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage()
            ], 400);
        }

        return response()->json([
            'message' => 'succes update data',
            'data' => $data
        ], 200);
    }

    public function deleteData($id)
    {
        $data = $this->jenisProductModel::where('id', $id)->first();
        if (!$data) {
            return response()->json([
                'message' => ' Dataor id not found'
            ], 404);
        } else {
            $data->delete();
            return response()->json([
                'message' => 'success delete data'
            ], 200);
        }
    }
}
