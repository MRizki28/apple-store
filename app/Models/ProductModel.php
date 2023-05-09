<?php

namespace App\Models;

use App\Models\DetailModel;
use App\Models\OrderanModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductModel extends Model
{
    use HasFactory;

    protected $table = 'tb_product';
    protected $fillable = [
        'id', 'uuid', 'product_name', 'product_model', 'price', 'stock', 'detail_id', 'created_at', 'updated_at'
    ];

    public function orderan()
    {
        return $this->hasMany(OrderanModel::class, 'product_id', 'id');
    }


    public function detail()
    {
        return $this->belongsTo(DetailModel::class);
    }

    public function getProductDetail($detail_id)
    {
        $data = $this->join('tb_detail', 'tb_product.detail_id', '=', 'tb_detail.id')
            ->select('tb_detail.uuid', 'tb_detail.image_phone', 'tb_detail.ram', 'tb_detail.storage', 'tb_detail.os', 'tb_detail.cpu', 'tb_detail.baterry', 'tb_detail.camera')
            ->where('tb_product.detail_id', '=', $detail_id)
            ->first();

        return $data;
    }
}
