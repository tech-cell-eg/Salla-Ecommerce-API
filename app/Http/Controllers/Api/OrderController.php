<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends ApiController
{
    public function show($id){
        return ApiController::successResponse([
            'data'=>new OrderResource(Order::findOrFail($id)),
            "message"=>"order created "
        ]);
    }
}
