<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Owner;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function filterCars(Request $request)
    {
        
        $allCars = Car::with('owner:id,rate', 'images')->where('car_name', 'like', '%' . $request->car . '%')
            ->whereRelation('city', 'name', 'like', '%' . $request->city . '%')->get();
            
            if (!empty($data)) {
                foreach ($allCars as $data) {
                    $data->search_count = $data->search_count + 1;
                }
            }
            
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $allCars
        ]);
    }

    public function callCount($id)
    {
        $owner = Owner::where('id', $id)->first();
        $owner->call_count = $owner->call_count + 1;
        $owner->save();
        return response()->json([
            'status' => true,
            'message' => 'Success',
        ]);
    }
    
    public function sameCar(Request $request)
    {
        $cars = Car::with('owner:id,rate', 'images')->where('car_name', $request->carName)->limit(10)->get();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $cars
        ]);
    }
}
