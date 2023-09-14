<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Repositories\BannerRepositories;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    protected $bannerRepositories;

    public function __construct(BannerRepositories $bannerRepositories)
    {
        $this->bannerRepositories = $bannerRepositories;
    }

    public function createData(Request $request)
    {
        return $this->bannerRepositories->createData($request);
    }
    public function getAllGambar()
    {
        return $this->bannerRepositories->getAllGambar();
    }
}
