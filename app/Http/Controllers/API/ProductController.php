<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $data = ProductModel::with('detail')->get();
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $data
        ]);
    }
    


}
