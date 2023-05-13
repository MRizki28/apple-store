<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailModel extends Model
{
    use HasFactory;
    protected $table ='tb_detail';
    protected $fillable = [
        'id' ,'uuid', 'image_phone','ram' ,'storage','os','cpu','baterry','camera','created_at','update_at'
    ];
}
