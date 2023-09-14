<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BannerModel extends Model
{
    use HasFactory,HasUuids;

    protected $table = 'tb_banner';
    protected $fillable = [
        'id' , 'gambar_banner' , 'created_at' , 'updated_at'
    ];
}
