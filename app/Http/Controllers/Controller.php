<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\City;
use App\Models\Image;
use App\Models\Owner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpFoundation\Response;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function deleteImage($id)
    {

        $image = Image::where('id', $id)->first();
        $isDeleted = $image->delete();
        return response()->json(
            ['message' => $isDeleted ? 'Deleted successfully' : 'Delete failed!'],
            $isDeleted ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST
        );
    }

    public function totalCount()
    {
        $owners = Owner::count();
        $cars = Car::count();
        $cities = City::count();
        return view('dashboard.index', ['owners' => $owners, 'cars' => $cars, 'cities' => $cities]);
    }
}
