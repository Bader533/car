<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Car;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\City;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\File;

class CarController extends Controller
{
    public function index()
    {
        $cars = Car::with('owner:id,rate', 'images')->limit(10)->get();

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $cars
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator($request->all(), [
            'car_name' => 'required |string|min:3|max:45',
            'price' => 'required | numeric',
            'fuel_type' => 'required|string|min:3|max:45 ',
            'car_type' => 'required|string|min:3|max:45',
            'description' => 'required | string|min:3|max:200',
            'city_id' => 'required | integer',
        ]);
        if (!$validator->fails()) {
            $cars = new Car();
            $cars->owner_id = auth('owner-api')->id();
            $cars->car_name = $request->get('car_name');
            $cars->price = $request->get('price');
            $cars->fueltype = $request->get('fuel_type');
            $cars->cartype = $request->get('car_type');
            $cars->description = $request->get('description');
            $cars->city_id = $request->get('city_id');
            $isSaved = $cars->save();
            if ($request->car_image != null) {
                foreach ($request->car_image as $key => $multi_image) {
                    $file_name = str::random(10) . $key . time() . str::random(10) . '.' . $multi_image->getClientOriginalExtension();

                    $path = 'images/cars';
                    $multi_image->move($path, $file_name);
                    $newImage = new Image();
                    $newImage->image_url = 'https://car.windicar.com/images/cars/' . $file_name;
                    $newImage->car_id = $cars->id;
                    $isSaved = $newImage->save();
                }
            }
            return response()->json(
                [
                    'status' => true,
                    'message' => $isSaved ? 'Created Successfully' : 'Created failed !'
                ],
                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST

            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->getMessageBag()->first()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function show($id)
    {
        $car = Car::with('owner:id,name,rate,image_url,phone','images')->with('city:id,name')->findOrFail($id);
        $sameCars = Car::with('owner:id,rate', 'images')->where('city_id', $car->city_id)->limit(10)->get();
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => [
                'car' => $car,
                'sameCars' => $sameCars,
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator($request->all(), [
            'car_name' => 'string|min:3|max:45',
            'price' => 'numeric',
            'fuel_type' => 'string|min:3|max:45 ',
            'car_type' => 'string|min:3|max:45',
            'description' => 'string|min:3|max:45',
            'city_id' => 'required | integer',
        ]);
        if (!$validator->fails()) {
            $cars = Car::findOrFail($id);
            $cars->owner_id = auth('owner-api')->id();
            $cars->car_name = $request->get('car_name');
            $cars->price = $request->get('price');
            $cars->fueltype = $request->get('fuel_type');
            $cars->cartype = $request->get('car_type');
            $cars->description = $request->get('description');
            $cars->city_id = $request->get('city_id');
            $isSaved = $cars->save();
            if ($request->file('car_image') != null) {
                $images = Image::where('car_id', $cars->id)->delete();
                foreach ($request->file('car_image') as $key => $multi_image) {
                    $file_name = str::random(10) . $key . time() . str::random(10) . '.' . $multi_image->getClientOriginalExtension();

                    $path = 'images/cars';
                    $multi_image->move($path, $file_name);
                    $newImage = new Image();
                    $newImage->image_url = 'https://car.windicar.com/images/cars/' . $file_name;
                    $newImage->car_id = $cars->id;
                    $isSaved = $newImage->save();
                }
            }
            return response()->json(
                [
                    'status' => true,
                    'message' => $isSaved ? 'Updated Successfully' : 'Updated failed !'
                ],
                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST

            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->getMessageBag()->first()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->images()->delete();
        $car->favoriters()->delete();
        $isDeleted = $car->delete();
        return response()->json([
            'status' => true,
            'message' => $isDeleted ? 'Deleted Successfully' : 'Deleted failed !'


        ], $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
    
    public function carName()
    {
        $car = Car::get('car_name');
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $car
        ]);
    }
    
    public function cityName()
    {
        $city = City::get('name');
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $city
        ]);
    }
}
