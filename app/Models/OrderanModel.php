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
        'id' , 'uuid_product', 'firstname' , 'lastname' , 'phone_number' , 'post_code' , 'city' , 'detail_site'
    ];

    public function product()
    {
        return $this->belongsTo(ProductModel::class, 'product_id');
    }

    public function kuitansi()
    {
        return $this->hasMany(KuitansiModel::class, 'id_orderan', 'id');
    }
}
