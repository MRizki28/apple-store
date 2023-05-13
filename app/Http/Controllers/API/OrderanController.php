<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OrderanModel;
use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class OrderanController extends Controller
{

    public function getAllData()
    {
        $data = OrderanModel::all();
        return response()->json([
            'message' => 'success get all data',
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
            $orderan->uuid = Uuid::uuid4()->toString();
            $orderan->firstname = $request->firstname;
            $orderan->lastname = $request->lastname;
            $orderan->phone_number = $request->phone_number;
            $orderan->post_code = $request->post_code;
            $orderan->city = $request->city;
            $orderan->detail_state = $request->detail_state;
            $orderan->qty = $request->qty;
            $orderan->total_price = $request->qty * $product->price;
   
            
          

            // Set your Merchant Server Key
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
            \Midtrans\Config::$isProduction = false;
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = true;

            $params = array(
                'transaction_details' => array(
                    'order_id' => $orderan->uuid,
                    'gross_amount' => $orderan->total_price,
                ),
                'customer_details' => array(
                    'name' => $request->firstname,
                    'phone' => $request->phone_number,
                ),
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $orderan->snapToken = $snapToken;
            $orderan->save();

            $product->stock -= $request->qty;
            $product->save();

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
            'data' => $orderan,
            'snapToken' => $snapToken
        ], 201);
    }


    public function getDataById($id)
    {
        $data = OrderanModel::where('id', $id)->with('product')->first();
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
