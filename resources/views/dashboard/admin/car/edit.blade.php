@extends('dashboard.starter')
@section('title', 'edit Car')
@section('pageName', 'edit Car')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="{{ asset('asset/css/app2.css') }}">
@endsection

@section('content')
<div class="div1">
    <div class="div2">
        <p class="textAdd">Edit Car</p>
    </div>
    <form>
        <div class="cardInput">

            {{-- owner --}}
            <div class="divInput">
                <label for="owner">owner</label>
                <select name="owner_id" id="owner_id" class="@error('owner') text-danger @enderror">
                    <option value="" disabled>---</option>
                    @foreach ($owners as $owner)
                    <option value="{{ $owner->id }}" @if ($owner->id == $car->owner_id) selected @endif>
                        {{ $owner->name }}</option>
                    @endforeach
                </select>
                @error('owner')
                <p class="text-danger">{{ $errors->first('owner') }}</p>
                @enderror
            </div>
            {{-- end owner --}}

            {{-- name --}}
            <div class="divInput">
                <label for="name">Car Name</label>
                <input type="text" name="car_name" id="car_name" class="@error('car_name') text-danger @enderror"
                    value="{{ old('car_name', $car->car_name) }}">
                @error('car_name')
                <p class="text-danger">{{ $errors->first('car_name') }}</p>
                @enderror
            </div>
            {{-- end name --}}

            {{-- price --}}
            <div class="divInput">
                <label for="price">price</label>
                <input type="text" name="price" id="price" class="@error('price') text-danger @enderror"
                    value="{{ old('price', $car->price) }}">
                @error('price')
                <p class="text-danger">{{ $errors->first('price') }}</p>
                @enderror
            </div>
            {{-- end price --}}

            {{-- city --}}
            <div class="divInput">
                <label for="city">city</label>
                <select name="city" id="city" class="@error('city') text-danger @enderror">
                    <option selected="true" disabled="disabled"> Select Your City</option>
                    @foreach ($cities as $city)
                    <option value="{{$city->id}}" @if ($city->id == $car->city_id) selected @endif>{{$city->name}}
                    </option>
                    @endforeach
                </select>
                @error('city')
                <p class="text-danger">{{$errors->first('city')}}</p>
                @enderror
            </div>
            {{-- end city --}}

            {{-- fuel_type --}}
            <div class="divInput">
                <label for="fuel_type">Fuel Type</label>
                <select name="fuel_type" id="fuel_type" class="@error('fuel_type') text-danger @enderror">
                    <option value="" disabled>--</option>
                    @foreach ($fuelTypes as $fuelType)
                    <option value="{{ $fuelType }}" @if ($car->fueltype == $fuelType) selected @endif>
                        {{ $fuelType }}</option>
                    @endforeach
                </select>
                @error('fuel_type')
                <p class="text-danger">{{ $errors->first('fuel_type') }}</p>
                @enderror
            </div>
            {{-- end fuel_type --}}

            {{-- car type --}}
            <div class="divInput">
                <label for="car_type">Car Type</label>

                <select name="car_type" id="car_type" class="@error('car_type') text-danger @enderror">
                    <option value="" disabled>--</option>
                    @foreach ($carsTypes as $carType)
                    <option value="{{ $carType }}" @if ($car->cartype == $carType) selected @endif>
                        {{ $carType }}</option>
                    @endforeach
                </select>
                @error('car_type')
                <p class="text-danger">{{ $errors->first('car_type') }}</p>
                @enderror
            </div>
            {{-- end car type --}}

            {{-- description --}}
            <div class="divInput">
                <label for="description">description</label>
                <textarea name="description" id="description" cols="30"
                    rows="10">{{ old('description', $car->description) }}</textarea>
                @error('description')
                <p class="text-danger">{{ $errors->first('description') }}</p>
                @enderror
            </div>
            {{-- end description --}}

            {{-- image --}}
            <div class="dragover">
                <span class="inner">
                    Upload Images
                    <span class="select" role="button">Browse</span>
                </span>


                <input name="car_image[]" type="file" class="file" multiple />
            </div>
            {{-- end image --}}

            {{-- show images --}}
            <div class="container">
                @if (count($car->images) != 0)
                @foreach ($car->images as $key => $image)
                <div class="image" id="imageDiv">
                    <img src="{{ asset($image->image_url) }}" alt="image">
                    <span onclick="performDelete('{{ $image->id }}')">&times;</span>
                </div>
                @endforeach
                @endif
            </div>
            {{-- end show images --}}
        </div>

        <div class="divButton">
            <button type="button" onclick="updateCar('{{$car->id}}')" class="buttonAdd"> Add </button>
        </div>
    </form>
</div><br>
@endsection

@section('js')
<script src="{{ asset('asset/js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios@1.1.2/dist/axios.min.js"></script>
<script src="https://unpkg.com/axios@1.1.2/dist/axios.min.js"></script>
<script>
    @if (Session::has('message'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('message') }}");
        @endif

        @if (Session::has('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('error') }}");
        @endif

        @if (Session::has('info'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.info("{{ session('info') }}");
        @endif

        @if (Session::has('warning'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.warning("{{ session('warning') }}");
        @endif
</script>
@endsection
