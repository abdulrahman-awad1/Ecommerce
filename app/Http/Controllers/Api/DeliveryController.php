<?php

namespace App\Http\Controllers\Api;

use App\Events\DeliveryLocationUpdateEvent;
use App\Http\Controllers\Controller;
use App\Models\Delivery;
use App\Models\Order;
use App\services\GoogleMapsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DeliveryController extends Controller
{
    protected $googleMapsService;

    // حقن خدمة GoogleMapsService في الـ Controller
    public function __construct(GoogleMapsService $googleMapsService)
    {
        $this->googleMapsService = $googleMapsService;
    }

    // دالة للحصول على الإحداثيات من العنوان
    public function getCoordinates(Request $request)
    {
        $address = $request->input('address');  // الحصول على العنوان من المدخلات

        // استدعاء خدمة GoogleMapsService للحصول على الإحداثيات
        $coordinates = $this->googleMapsService->getCoordinates($address);

        // إرجاع الإحداثيات على شكل JSON
        return response()->json($coordinates);
    }



    public function show($id){
        $delivery = Delivery::query()->select([
            'id',
            'order_id',
            'status',
            DB::raw("ST_X(current_location) AS lng"),
            DB::raw("ST_Y(current_location) AS lat"),
        ])->where('id',$id)
            ->firstOrFail();
        return $delivery;


    }



    public function update(Request $request, Delivery $delivery){
        $request->validate([
            'lng'=> ['required','numeric'],
            'lat'=> ['required','numeric'],
            'order_id'=> ['required','numeric'],
        ]);
        $delivery->update([
            'current_location'=>DB::raw("POINT({$request->lat},{$request->lng})")
        ]);
        event(new DeliveryLocationUpdateEvent($request->lat,$request->lng));

        return response()->json(['status' => 'success', $delivery]);

    }






}
