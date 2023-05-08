<?php

namespace App\Http\Controllers\API;

use Ramsey\Uuid\Uuid;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ProductController extends Controller
{
    public function getAllData()
    {
        $data = ProductModel::with('detail')->get();
        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'data not found'
            ]);
        } else {
            return response()->json([
                'message' => 'success get data',
                'data' => $data
            ]);
        }
    }

    public function createData(Request $request)
    {
        $validation = Validator::make(
            $request->all(),
            [
                'product_name' => 'required',
                'product_model' => 'required',
                'price' => 'required',
                'stock' => 'required',
                'image_phone' => 'required|image|max:2048',
            ],
            [
                'product_name.required' => 'Form product name tidak boleh kosong',
                'product_model.required' => 'Form product model tidak boleh kosong',
                'price.required' => 'Form price tidak boleh kosong',
                'stock.required' => 'Form required tidak boleh kosong',
                'image_phone.required' => 'Form Image Tidak boleh kosong',
                'image_phone.max' =>  'Ukuran gambar tidak boleh lebih dari 2MB',
            ]
        );

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
            if ($request->hasFile('image_phone')) {
                $file = $request->file('image_phone');
                $extention = $file->getClientOriginalExtension();
                $filename = 'PHONE-' . Str::random(15) . '.' . $extention;
                Storage::makeDirectory('uploads/phone/');
                $file->move(public_path('uploads/phone/'), $filename);
                $data->image_phone = $filename;
            }
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

    public function updateDataByUuid(Request $request , $uuid)
    {
    
        if (!Uuid::isValid($uuid)) {
            return response()->json([
                'code' => 400,
                'message' => 'UUID Invalid'
            ]);
        }
        try {
            $data = ProductModel::where('uuid', $uuid)->firstOrFail();
            $data->product_name = $request->input('product_name');
            $data->product_model = $request->input('product_model');
            $data->price = $request->input('price');
            $data->stock = $request->input('stock');
            $data->detail_id = $request->input('detail_id');
            if ($request->hasFile('image_phone')) {
                $file = $request->file('image_phone');
                $extention = $file->getClientOriginalExtension();
                $filename = 'PHONE-' . Str::random(15) . '.' . $extention;
                Storage::makeDirectory('uploads/phone/');
                $file->move(public_path('uploads/phone/'), $filename);
                $old_file_path = public_path('uploads/phone/') . $data->image_phone;
                if (file_exists($old_file_path)) {
                    unlink($old_file_path);
                }
                $data->image_phone = $filename;

            }

            
            $data->save();
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 401,
                'message' => $th->getMessage()
            ]);
        }


        return response()->json([
            'code' => 200,
            'message' => 'success update',
            'data' => $data
        ]);
    }

    public function deleteData($uuid)
    {
        if (!Uuid::isValid($uuid)) {
            return response()->json([
                'code' => 400,
                'message' => 'UUID Invalid'
            ]);
        }
        try {
            $data = ProductModel::where('uuid', $uuid)->first();
            $location = 'uploads/phone/' . $data->image_phone;
            $data->delete();
            if ((File::exists($location))) {
                File::delete($location);
            }
            return response()->json([
                'code' => 200,
                'message' => 'success delete data',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'failed delete data',
                'errors' => $th->getMessage()
            ]);
        }
    }
}
