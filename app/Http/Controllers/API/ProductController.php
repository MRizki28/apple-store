<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class ProductController extends Controller
{
    public function getAllData()
    {
        $data = ProductModel::with('detail')->get();
        return response()->json([
            'code' => 200,
            'message' => 'success',
            'data' => $data
        ]);
    }

    public function createData(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'product_name' => 'required',
            'product_model' => 'required',
            'price' => 'required',
            'stock' => 'required'
        ]);

        if ($validation->fails()) {
            return response()->json([
                'code' => 401,
                'message' => 'check your validation',
                'errors' => $validation->errors()
            ]);
        }

        try {
            $data = new ProductModel();
            $data->uuid = Uuid::uuid4()->toString();
            $data->product_name = $request->input('product_name');
            $data->product_model = $request->input('product_model');
            $data->price = $request->input('price');
            $data->stock = $request->input('stock');
            $data->detail_id = $request->input('detail_id');
            $data->save();
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 402,
                'message' => 'failed input data phone',
                'errors' => $th->getMessage()
            ]);
        }

        return response()->json([
            'code' => 200,
            'message' => 'success create data',
            'data' => $data
        ]);
    }

    public function getDataByUuid($uuid)
    {

        if (!Uuid::isValid($uuid)) {
            return response()->json([
                'code' => 400,
                'message' => 'UUID Invalid'
            ]);
        }

        $data = ProductModel::where('uuid', $uuid)->with('detail')->first();
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

    public function deleteData($uuid)
    {
        if (!Uuid::isValid($uuid)) {
            return response()->json([
                'code' => 400,
                'message' => 'UUID Invalid'
            ]);
        }

        $data = ProductModel::where('uuid', $uuid)->first();
        $data->delete();
        return response()->json([
            'code' => 200,
            'message' => 'success delete data',
        ]);
    }
}
