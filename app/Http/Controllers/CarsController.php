<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\City;
use App\Models\Image;
use App\Models\Owner;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CarsController extends Controller
{
    private $carsTypes = ['Normal', 'Automatic'];
    private $fuelTypes = ['gasoline', 'Solar', 'Diesel', 'battery'];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cars = Car::all();
        if (request()->ajax()) {
            return datatables()->of($cars)
                ->addColumn('action', function ($data) {
                    $button = '<form action="' . route('car.destroy', $data->id) . '" method="post">' . csrf_field() . ' ' . method_field('DELETE') . '<a href="' . route('car.edit', $data->id) . '" class="btn btn-primary"> <i class="fa fa-pen"></i></a>' . '&nbsp;' . '<button type="submit" class="btn btn-danger">' . trans('<i class="fa fa-trash"></i>') . '</button></form>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('dashboard.admin.car.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $owners = Owner::all();
        $cities = City::all();
        return view('dashboard.admin.car.create', [
            'owners' => $owners,
            'cities' => $cities,
            'carsTypes' => $this->carsTypes,
            'fuelTypes' => $this->fuelTypes
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'owner_id' => 'required',
            'car_name' => 'required|string|min:3|max:45',
            'price' => 'required | numeric| min:1',
            'fuel_type' => 'required|string|min:3|max:45',
            'car_type' => 'required|string|min:3|max:45',
            'description' => 'required |string|min:3|max:200 ',
            'city' => 'required',
        ]);

        $cars = new Car();
        $cars->owner_id = $request->input('owner_id');
        $cars->car_name = $request->input('car_name');
        $cars->price = $request->input('price');
        $cars->fueltype = $request->input('fuel_type');
        $cars->cartype = $request->input('car_type');
        $cars->description = $request->input('description');
        $cars->city_id = $request->input('city');
        $isSaved = $cars->save();
        if ($request->file('car_image') != null) {
            foreach ($request->file('car_image') as $key => $multi_image) {
                $file_name = str::random(10) . $key . time() . str::random(10) . '.' . $multi_image->getClientOriginalExtension();

                $path = 'images/cars';
                $multi_image->move($path, $file_name);
                $newImage = new Image();
                $newImage->image_url = 'images/cars/' . $file_name;
                $newImage->car_id = $cars->id;
                $isSaved = $newImage->save();
            }
        }


        if ($isSaved) {
            return redirect()->route('car.index')->with('message', 'Cars Created Successfully');
        } else {
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cars  $cars
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cars = Car::where('owner_id', $id)->get();

        return view('dashboard.admin.car.show', [
            'ownerId' => $id,

            'cars' => $cars
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cars  $cars
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $car = Car::with('images')->findOrFail($id);
        $owners = Owner::all();
        $cities = City::all();
        return view('dashboard.admin.car.edit', [
            'car' => $car,
            'owners' => $owners,
            'cities' => $cities,
            'carsTypes' => $this->carsTypes,
            'fuelTypes' => $this->fuelTypes
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cars  $cars
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
    {
        $request->validate([
            'owner_id' => 'required',
            'car_name' => 'string|min:3|max:45',
            'price' => ' numeric| min:1',
            'fuel_type' => 'string|min:3|max:45',
            'car_type' => 'string|min:3|max:45',
            'description' => 'string|min:3|max:200 ',
        ]);
        $car->owner_id = $request->owner_id;
        $car->car_name = $request->car_name;
        $car->price = $request->price;
        $car->fueltype = $request->fuel_type;
        $car->cartype = $request->car_type;
        $car->description = $request->description;
        $car->city_id = $request->city;
        $isSaved = $car->save();
        if ($request->images != null) {
            foreach ($request->images as $image) {
                $file_name = str::random(10) . '_' . time() . str::random(10) . '.' . $image->getClientOriginalExtension();
                $path = 'images/cars';
                $image->move($path, $file_name);
                $newImage = new Image();
                $newImage->image_url = 'images/cars/' . $file_name;
                $newImage->car_id = $car->id;
                $isSaved = $newImage->save();
            }
        }
        if ($isSaved) {
            return response()->json(['status' => true]);
        } else {
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cars  $cars
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->images()->delete();
        $car->favoriters()->delete();
        $isDeleted = $car->delete();
        
        if ($isDeleted) {
            return redirect()->route('car.index')->with('message', 'Car deleted Successfully');
        } else {
            return redirect()->route('car.index')->with('error', 'Car deleted failed!');
        }
    }
}
