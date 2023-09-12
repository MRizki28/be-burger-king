<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisProductModel extends Model
{
    use HasFactory , HasUuids;
    protected $table = 'tb_jenis_product';
    protected $fillable = [
        'id' , 'kode_product' , 'nama_product' , 'created_at' , 'updated_at'
    ];
}
