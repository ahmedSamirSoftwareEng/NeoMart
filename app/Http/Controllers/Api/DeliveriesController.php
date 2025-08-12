<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DeliveriesController extends Controller
{
    public function show($id)
    {
        $delivery = Delivery::query()
            ->select([
                'id',
                'order_id',
                'status',
                DB::raw("ST_y(current_location) as lng"),
                DB::raw("ST_x(current_location) as lat"),

            ])
            ->where('id', $id)
            ->firstOrFail();

        return $delivery;
    }
    public function update(Request $request, Delivery $delivery)
    {
        $request->validate(
            [
                'lng' => ['required', 'numeric'],
                'lat' => ['required', 'numeric']
            ]
        );

        $delivery->update([
            'current_location' => DB::raw("POINT({$request->lng},{$request->lat})")
        ]);

        event(new \App\Events\DeliveryLocationUpdated($request->lng, $request->lat));
        return $delivery;
    }
}
