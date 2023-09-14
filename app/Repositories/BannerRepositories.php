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
}
