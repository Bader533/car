<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CityController extends Controller
{
    public function index()
    {
        $cities = City::all();
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $cities
        ], Response::HTTP_OK);
    }
}
