<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuitansiModel extends Model
{
    use HasFactory;

    protected $table ='tb_kuitansi';
    protected $fillable = [
        'id' ,'id_orderan' , 'number_resi' , 'total_price' , 'created_at' , 'updated_at'
    ];

    public function kuitansi()
    {
        $this->belongsTo(OrderanModel::class, 'id_orderan');
    }
}
