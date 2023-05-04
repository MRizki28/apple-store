<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DetailModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class DetailProductController extends Controller
{
    public function getAllData()
    {
        $data = DetailModel::all();
        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'data not found'
            ]);
        } else {
            return response()->json([
                'code' => 200,
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
                'image_phone' => 'required|image|max:2048',
                'ram' => 'required',
                'storage' => 'required',
                'os' => 'required',
                'cpu' => 'required',
                'baterry' => 'required',
                'camera' => 'required'
            ],
            [
                'image_phone.required' => 'Form Image Tidak boleh kosong',
                'image_phone.max' =>  'Ukuran gambar tidak boleh lebih dari 2MB',
                'ram.required' => 'Form ram tidak boleh kosong',
                'storage' => 'Form storage tidak boleh kosong',
                'os' => 'Form Os tidak boleh kosong',
                'cpu' => 'Form CPU tidak boleh kosong',
                'baterry' => 'Form baterry tidak boleh kosong',
                'camera' => 'Form camera tidak boleh kosong'
            ]
        );

        if ($validation->fails()) {
            return response()->json([
                'code' => 401,
                'message' => 'check your validation' ,
                'errors' => $validation->errors()
            ]);
        }

        try {
            $data = new DetailModel();
            $data->uuid = Uuid::uuid4()->toString();
            if ($request->hasFile('image_phone')) {
                $file = $request->file('image_phone');
                $extention = $file->getClientOriginalExtension();
                $filename = 'PHONE-' . Str::random(15) . '.' . $extention;
                Storage::makeDirectory('uploads/phone/');
                $file->move(public_path('uploads/phone/'), $filename);
                $data->image_phone = $filename;
            }
            $data->ram = $request->input('ram');
            $data->storage = $request->input('storage');
            $data->os = $request->input('os');
            $data->cpu = $request->input('cpu');
            $data->baterry =$request->input('baterry');
            $data->camera = $request->input('camera');
            $data->save();
        } catch (\Throwable $th) {
            return response()->json([
                'code' => 400,
                'message' => 'gagal insert data phone',
                'errors' => $th->getMessage()
            ]);
        }

        return response()->json([
            'code' => 200,
            'message' => 'success insert data',
            'data' => $data
        ]);
    }

    public function getDataByUuid($uuid)
    {
        if (!Uuid::isValid($uuid)) {
            return response()->json([
                'code' => 402,
                'message' => 'uuid invalid'
            ]);
        }
        $data =  DetailModel::where('uuid', $uuid)->first();
        return response()->json([
            'code' => 200,
            'message' => 'success get data by uuid',
            'data' => $data
        ]);
    }
}
