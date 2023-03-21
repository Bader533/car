<?php

namespace App\Http\Controllers;

use App\Models\CarName;
use Illuminate\Http\Request;

class CarNameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carName = CarName::all();

        if (request()->ajax()) {
            return datatables()->of($carName)
                ->addColumn('action', function ($data) {
                    $button = '<form action="' . route('carName.destroy', $data->id) . '" method="post">' . csrf_field() . ' ' . method_field('DELETE') . '&nbsp' . '<a href="' . route('carName.edit', $data->id) . '" class="btn btn-primary"> <i class="fa fa-pen"></i></a>'  . '<button type="submit" class="btn btn-danger">' . trans('<i class="fa fa-trash"></i>') . '</button></form>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('dashboard.admin.carname.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.admin.carname.create');
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
                'name' => 'required | max:50 | unique:car_names,name'
            ]
        );

        if (!$validator->fails()) {
            $carname = new CarName();
            $carname->name = $request->input('name');
            $isSaved = $carname->save();
            return redirect()->route('carName.index')->with('message', 'Car Name Created Successfully');
        } else {
            return redirect()->back()->with('error', $validator->getMessageBag()->first());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CarName  $carName
     * @return \Illuminate\Http\Response
     */
    public function show(CarName $carName)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CarName  $carName
     * @return \Illuminate\Http\Response
     */
    public function edit(CarName $carName)
    {
        return view('dashboard.admin.carname.edit', ['carName' => $carName]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarName  $carName
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarName $carName)
    {
        $validator = Validator(
            $request->all(),
            [
                'name' => 'required | max:50'
            ]
        );

        if (!$validator->fails()) {
            $carName->name = $request->input('name');
            $isSaved = $carName->save();
            return redirect()->route('carName.index')->with('message', 'Car Name Updated Successfully');
        } else {
            return redirect()->back()->with('error', $validator->getMessageBag()->first());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarName  $carName
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarName $carName)
    {
        $isDeleted = $carName->delete();

        if ($isDeleted) {
            return redirect()->route('carName.index')->with('message', 'Car Name deleted Successfully');
        } else {
            return redirect()->route('carName.index')->with('error', 'Car Name deleted failed!');
        }
    }
}
