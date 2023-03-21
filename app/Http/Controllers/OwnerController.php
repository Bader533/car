<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $owners = Owner::all();
        if (request()->ajax()) {
            return datatables()->of($owners)
                ->addColumn('action', function ($data) {
                    $button = '<form action="' . route('owner.destroy', $data->id) . '" method="post">' . csrf_field() . ' ' . method_field('DELETE') . '<a href="' . route('owner.edit', $data->id) . '" class="btn btn-primary"> <i class="fa fa-pen"></i></a>' . '&nbsp;' . '<button type="submit" class="btn btn-danger">' . trans('<i class="fa fa-trash"></i>') . '</button></form>';
                    return $button;
                })
                ->addColumn('cars', function ($data) {
                    $a = '<a href="' . route('car.show', $data->id) . '" class="">  ' . $data->cars->count() . '</a>';
                    return $a;
                })
                ->rawColumns(['action', 'cars'])
                ->make(true);
        }
        return view('dashboard.admin.owner.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cities = City::all();
        return view('dashboard.admin.owner.create', ['cities' => $cities]);
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
            'name' => 'required | max:50 | unique:owners,name',
            'email' => 'required | max:50 | unique:owners,email',
            'phone' => 'required | numeric',
            'city' => 'required',
            'password' => 'required',
        ]);

        $owner = new Owner();
        $owner->name = $request->input('name');
        $owner->email = $request->input('email');
        $owner->phone = $request->input('phone');
        $owner->city_id = $request->input('city');
        $owner->password = Hash::make($request->input('password'));
        if ($request->file('image') != null) {
            $file_name = 'images/owners/' . str::random(10)  . time() . str::random(10) . '.' . $request->file('image')->getClientOriginalExtension();
            $path = 'images/owners';
            $request->file('image')->move($path, $file_name);
            $owner->image_url = $file_name;
        }
        $isSaved = $owner->save();

        if ($isSaved) {
            return redirect()->route('owner.index')->with('message', 'Owner Created Successfully');
        } else {
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Owner  $owner
     * @return \Illuminate\Http\Response
     */
    public function show(Owner $owner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Owner  $owner
     * @return \Illuminate\Http\Response
     */
    public function edit(Owner $owner)
    {
        $cities = City::all();
        return view('dashboard.admin.owner.edit', ['cities' => $cities, 'owner' => $owner]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Owner  $owner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Owner $owner)
    {
        request()->validate([
            'name' => 'max:50',
            'email' => 'max:50',
            'phone' => 'numeric',
            // 'city' => 'required',
            // 'password' => 'required',
        ]);
        $owner->name = $request->input('name');
        $owner->email = $request->input('email');
        $owner->phone = $request->input('phone');
        $owner->city_id = $request->input('city');
        $owner->password = Hash::make($request->input('password'));
        if ($request->file('image') != null) {
            $file_name = str::random(10)  . time() . str::random(10) . '.' . $request->file('image')->getClientOriginalExtension();
            $path = 'images/owners';
            $request->file('image')->move($path, $file_name);
            $owner->image_url = $file_name;
        }
        $isSaved = $owner->save();
        if ($isSaved) {
            return redirect()->route('owner.index')->with('message', 'Owner Updated Successfully');
        } else {
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Owner  $owner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Owner $owner)
    {
        $isDeleted = $owner->delete();

        if ($isDeleted) {
            return redirect()->route('owner.index')->with('message', 'Owner deleted Successfully');
        } else {
            return redirect()->route('owner.index')->with('error', 'Owner deleted failed!');
        }
    }
}
