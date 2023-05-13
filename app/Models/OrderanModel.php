<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\KuitansiModel;

class OrderanModel extends Model
{
    use HasFactory;

    protected $table = 'tb_orderan';
    protected $fillable = [
        'id' , 'product_id','uuid', 'firstname' , 'lastname' , 'phone_number' , 'post_code' , 'city' , 'detail_site' , 'qty' , 'total_price', 'snapToken'
    ];

    public function product()
    {
        return $this->belongsTo(ProductModel::class);
    }

    public function getProduct($product_id)
    {
        $data = $this->join('tb_orderan', 'tb_orderan.product_id', '=', 'tb_product.id')
            ->select('tb_product.detail_id', 'tb_product.uuid', 'tb_product.product_name', 'tb_product.product_model', 'tb_product.price', 'tb_product.stock', 'tb_product.image_phone')
            ->where('tb_product.uuid', '=', $product_id)
            ->first();
    
        return $data;
    }
    

    public function kuitansi()
    {
        return $this->hasMany(KuitansiModel::class, 'id_orderan', 'id');
    }
}
