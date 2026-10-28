<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'item' => ['required', 'string', 'max:255'],
            'qty'  => ['required', 'integer', 'min:1'],
        ], [
            'item.required' => 'Укажите название товара.',
            'item.string'   => 'Название товара должно быть строкой.',
            'qty.required'  => 'Укажите количество.',
            'qty.integer'   => 'Количество должно быть целым числом.',
            'qty.min'       => 'Количество должно быть больше нуля.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], 422);
        }

        $order = Order::create($validator->validated());

        Redis::publish('orders', json_encode([
            'id'   => $order->id,
            'item' => $order->item,
            'qty'  => $order->qty,
        ]));

        return response()->json(['status' => 'ok', 'order_id' => $order->id]);
    }
}