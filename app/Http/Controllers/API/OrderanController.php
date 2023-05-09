<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OrderanModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderanController extends Controller
{

    public function getAllData()
    {
        $data = OrderanModel::all();
        return response()->json([
            'message'=>'success get all data',
            'data' => $data
        ]);
    }

    public function createOrderan(Request $request)
    {
        try {
            // Ambil data produk dari database berdasarkan uuid
            $product = ProductModel::where('uuid', $request->product_id)->first();
            $orderan = new OrderanModel();
            $orderan->product_id = $product->id;
            $orderan->firstname = $request->firstname;
            $orderan->lastname = $request->lastname;
            $orderan->phone_number = $request->phone_number;
            $orderan->post_code = $request->post_code;
            $orderan->city = $request->city;
            $orderan->detail_state = $request->detail_state;
            $orderan->save();
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed',
                'errors' => $th->getMessage()
            ]);
        }
        // Kirimkan response berisi data orderan yang baru saja dibuat
        return response()->json([
            'status' => 'success',
            'message' => 'Order created successfully',
            'data' => $orderan
        ], 201);
    }

    public function getDataById($id)
    {
        $data = OrderanModel::findOrFail($id);
        if ($data == null) {
            return response()->json([
                'message' => 'data not found'
            ]);
        } else {
            return response()->json([
                'message' => 'success get data ',
                'data' => $data,
            ]);
        }
    }
}
