<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use Illuminate\Http\Request;
use App\Models\Car;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $favorite = Favorite::with('car.owner:id,rate','car.images')->where('owner_id', '=', auth('owner-api')->id())->get();
        
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $favorite
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
        $validator = Validator($request->all(), [
            'car_id' => 'required',
        ]);
        if (!$validator->fails()) {
            $favorite = new Favorite();
            $favorite->owner_id = auth('owner-api')->id();
            $favorite->car_id = $request->car_id;
            $isSaved = $favorite->save();
            return response()->json(
                [
                    'status' => true,
                    'message' => $isSaved ? 'Add To Favorite' : 'Added failed !'
                ],
                $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST

            );
        } else {
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST,
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $favorite = Favorite::where('id', '=', $id)->first();
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $favorite
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $favorite = Favorite::where('owner_id', auth('owner-api')->id())
            ->where('car_id', $id)->first();

        $isDeletd = $favorite->delete();
        if ($isDeletd) {
            return response()->json([
                'status' => true,
                'message' => 'Deleted Successfully',
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Deleted failed !',
            ]);
        }
    }
}
