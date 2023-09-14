<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuModel extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'tb_menu';
    protected $fillable = [
        'id', 'id_jenis_product', 'nama_menu', 'stock', 'harga', 'gambar_menu', 'created_at', 'updated_at'
    ];

    public function JenisProduct()
    {
        return $this->belongsTo(JenisProductModel::class, 'id_jenis_product');
    }

    public function getJenisProduct($id_jenis_product)
    {
        $data = $this->join('tb_jenis_product', 'tb_jenis_product.id_jenis_product', '=', 'tb_jenis_product.id')
            ->select('tb_jenis_product.kode_product', 'tb_jenis_product.nama_jenis_product')
            ->where('tb_jenis_product.id_jenis_product', '=', $id_jenis_product)
            ->first();
        return $data;
    }
}
