<?php

namespace App\Repositories;

use App\Interfaces\BannerInterfaces;
use App\Models\BannerModel;
use App\Traits\ValidationTrait;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerRepositories implements BannerInterfaces
{
    use ValidationTrait;

    protected $bannerModel;

    public function __construct(BannerModel $bannerModel)
    {
        $this->bannerModel = $bannerModel;
    }

    public function createData(Request $request)
    {
        $data = $request->all();

        $validation = [
            'gambar_banner' => 'required|image'
        ];

        $customMessage = [
            'gambar_banner.required' => 'Gambar wajib diisi',
            'gambar_banner.image' => 'Format tidak valid'
        ];

        $this->dataValidation($data, $validation, $customMessage);

        try {
            $data =  new $this->bannerModel;
            if ($request->hasFile('gambar_banner')) {
                $file = $request->file('gambar_banner');
                $extention = $file->getClientOriginalExtension();
                $filename = 'BANNER-' . Str::random(15) . '.' . $extention;
                Storage::makeDirectory('uploads/banner/');
                $file->move(public_path('uploads/banner/'), $filename);
                $data->gambar_banner = $filename;
            }
            $data->save();
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage()
            ], 400);
        }

        return response()->json([
            'message' => 'success upload banner',
            'data' => $data
        ], 200);
    }

    public function getAllGambar()
    {
        $path = public_path('uploads/banner/');

        if (is_dir($path)) {
            $files = File::files($path);
            $gambarData = [];

            foreach ($files as $file) {
                $tipeKonten = mime_content_type($file->getPathname());
                $gambarData[] = [
                    'nama' => $file->getFilename(),
                    'tipeKonten' => $tipeKonten,
                    'url' => url('uploads/banner/' . $file->getFilename()),
                ];
            }

            return response()->json([
                'message' => 'success',
                'data' => $gambarData
            ], 200);
        } else {
            return response()->json([
                'message' => 'Directory not found'
            ], 404);
        }
    }
    public function getAllData()
    {
        $data = $this->bannerModel::all();
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

    public function getDataById($id)
    {
        $data = $this->bannerModel::where('id', $id)->first();
        if (!$data) {
            return response()->json([
                'message' => 'ID or data not found'
            ], 404);
        } else {
            return response()->json([
                'message' => 'success get data by id',
                'data' => $data
            ], 200);
        }
    }

    public function updateData(Request $request, $id)
    {
        $data = $request->all();

        $validation = [
            'gambar_banner' => 'image'
        ];

        $customMessage = [
            'gambar_banner.image' => 'Format tidak valid'
        ];

        $this->dataValidation($data, $validation, $customMessage);
        try {
            $data = $this->bannerModel::where('id', $id)->first();
            if ($request->hasFile('gambar_banner')) {
                $file = $request->file('gambar_banner');
                $extention = $file->getClientOriginalExtension();
                $filename = 'BANNER-' . Str::random(15) . '.' . $extention;
                Storage::makeDirectory('uploads/banner/');
                $file->move(public_path('uploads/banner/'), $filename);
                $old_file =  public_path('uploads/banner/') . $data->gambar_banner;
                if (file_exists($old_file)) {
                    unlink($old_file);
                }
                $data->gambar_banner = $filename;
            }
            $data->save();
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage()
            ], 400);
        }

        return response()->json([
            'message' => 'success update data',
            'data' => $data
        ], 200);
    }

    public function deleteData($id)
    {
        try {
            $data = $this->bannerModel::where('id', $id)->first();
            if (!$data) {
                return response()->json([
                    'message' => 'data not found'
                ], 404);
            }
            $filePath = 'uploads/banner/' . $data->gambar_banner;
            if (File::exists($filePath)) {
                File::delete($filePath);
            }
            $data->delete();
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage()
            ]);
        }

        return response()->json([
            'message' => 'success delete data'
        ], 200);
    }
}
