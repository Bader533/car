<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        public function ownerProfile()
    {
        $owner = Owner::with('city:id,name','cars.images')->where('id', '=', auth('owner-api')->id())->first();
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $owner
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $owner = Owner::with('city:id,name','cars.images')->where('id', '=', $id)->first();
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $owner
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
        $owner = Owner::where('id', '=', auth('owner-api')->id())->first();
        $validator = Validator(
            $request->all(),
            [
                'name' => 'string|min:3|max:45',
                'email' => 'email|min:3|max:45',
                'phone' => 'numeric',
            ]
        );
        
        if (!$validator->fails()) {

            $owner->name = $request->get('name');
            $owner->email = $request->get('email');
            $owner->phone = $request->get('phone');
            if ($request->file('image') != null) {
                $file_name = 'images/owners/' . str::random(10)  . time() . str::random(10) . '.' . $request->file('image')->getClientOriginalExtension();
                $path = 'images/owners';
                $request->file('image')->move($path, $file_name);
                $owner->image_url = 'https://car.windicar.com/'.$file_name;
            }
         
            $isSaved = $owner->save();

            return response()->json([
                'status' => $isSaved,
                'message' => $isSaved ? 'Updated sucessfully' : 'Updated failed !'
            ]);
        } else {
            return response()->json(['message' => $validator->getMessageBag()->first()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
