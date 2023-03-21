<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\City;
use Illuminate\Http\Request;
use DataTables;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::paginate(10);
        return view('dashboard.admin.city.index', ['cities' => $cities]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.admin.city.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator(
            $request->all(),
            [
                'name' => 'required|string|min:3|max:45 | unique:cities,name'
            ]
        );

        if (!$validator->fails()) {
            $city = new City();
            $city->name = $request->input('name');
            $isSaved = $city->save();
            return redirect()->route('city.index')->with('message', 'City Created Successfully');
        } else {
            return redirect()->back()->with('error', $validator->getMessageBag()->first());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        return view('dashboard.admin.city.edit', ['city' => $city]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {

        $validator = Validator(
            $request->all(),
            [
                'name' => 'required|string|min:3|max:45'
            ]
        );

        if (!$validator->fails()) {
            $city->name = $request->input('name');
            $isSaved = $city->save();
            return redirect()->route('city.index')->with('message', 'City Updated Successfully');
        } else {
            return redirect()->back()->with('error', $validator->getMessageBag()->first());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $cars = Car::where('city_id', $city->id)->get();
        foreach ($cars as $car) {
            $car->city_id = null;
            $car->save();
        }
        $isDeleted = $city->delete();

        if ($isDeleted) {
            return redirect()->route('city.index')->with('message', 'City deleted Successfully');
        } else {
            return redirect()->route('city.index')->with('error', 'City deleted failed!');
        }
    }
}
