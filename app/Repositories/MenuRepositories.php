<?php

namespace App\Repositories;

use App\Interfaces\MenuInterfaces;
use App\Models\MenuModel;
use App\Traits\ValidationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class MenuRepositories implements MenuInterfaces
{
    protected $menuModel;

    use ValidationTrait;

    public function __construct(MenuModel $menuModel)
    {
        $this->menuModel = $menuModel;
    }

    public function getAllData()
    {
        $data = $this->menuModel::with('JenisProduct')->get();
        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'data not found',
            ], 404);
        } else {
            return response()->json([
                'message' => 'success',
                'data' => $data
            ], 200);
        }
    }

    public function createData(Request $request)
    {
        $data = $request->all();

        $validation = [
            'id_jenis_product' => 'required',
            'nama_menu' => 'required',
            'stok' => 'required|numeric',
            'harga' => 'required|numeric',
            'gambar_menu' => 'required|image',
            'description' => 'required'
        ];

        $customMessage = [
            'id_jenis_product.required' => 'Jenis produk wajib diisi',
            'nama_menu.required' => 'Nama menu wajib diisi',
            'stok.required' => 'stok wajib diisi',
            'stok.numeric' => 'Format harus numeric',
            'harga.required' => 'harga wajib diisi',
            'harga.numeric' => 'Format harus numeric',
            'gambar_menu.required' => 'gambar wajib diisi',
            'gambar_menu.image' => 'Format tidak tidak sesuai',
            'description.required' => 'deskripsi wajib diisi'
        ];

        $this->dataValidation($data, $validation , $customMessage);

        try {
            $data = new $this->menuModel;
            $data-> id_jenis_product = $request->input('id_jenis_product');
            $data->nama_menu = $request->input('nama_menu');
            $data->stok = $request->input('stok');
            $data->harga = $request->input('harga');
            if ($request->hasFile('gambar_menu')) {
                $file = $request->file('gambar_menu');
                $extention = $file->getClientOriginalExtension();
                $filename = 'MENU-' . Str::random(15) . '.' . $extention;
                Storage::makeDirectory('uploads/menu/');
                $file->move(public_path('uploads/menu/'), $filename) ;
                $data->gambar_menu = $filename;
            }
            $data->description = $request->input('description');
            $data->save();
        } catch (\Throwable $th) {
           return response()->json([
            'message' => 'failed',
            'errors' => $th->getMessage()
           ],400);
        }

        return response()->json([
            'message' => 'success create data',
            'data' => $data
        ],200);
    }
}
