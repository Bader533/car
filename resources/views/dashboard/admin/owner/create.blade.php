@extends('dashboard.starter')
@section('title', 'add owner')
@section('pageName', 'Add Owner')

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
        <p class="textAdd">Add New Owner</p>
    </div>
    <form action="{{ route('owner.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="cardInput">

            {{-- name --}}
            <div class="divInput">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="@error('name') text-danger @enderror"
                    value="{{ old('name') }}">
                @error('name')
                <p class="text-danger">{{ $errors->first('name') }}</p>
                @enderror
            </div>
            {{-- end name --}}

            {{-- email --}}
            <div class="divInput">
                <label for="email">Email</label>
                <input type="text" name="email" value="{{ old('email') }}"
                    class="@error('email') text-danger @enderror">
                @error('email')
                <p class="text-danger">{{ $errors->first('email') }}</p>
                @enderror
            </div>
            {{-- end email --}}

            {{-- phone --}}
            <div class="divInput">
                <label for="phone">phone</label>
                <input type="text" name="phone" id="phone" value="{{old('phone')}}"
                    class="@error('phone') text-danger @enderror">

                @error('phone')
                <p class="text-danger">{{$errors->first('phone')}}</p>
                @enderror
            </div>
            {{-- end phone --}}

            {{-- city --}}
            <div class="divInput">
                <label for="city">city</label>
                <select name="city" id="city" class="@error('city') text-danger @enderror">
                    <option selected="true" disabled="disabled"> Select Your City</option>
                    @foreach ($cities as $city)
                    <option value="{{$city->id}}">{{$city->name}}</option>
                    @endforeach
                </select>
                @error('city')
                <p class="text-danger">{{$errors->first('city')}}</p>
                @enderror
            </div>
            {{-- end city --}}

            {{-- password --}}
            <div class="divInput">
                <label for="password">password</label>
                <input type="text" name="password" id="password" class="@error('password') text-danger @enderror">
                @error('password')
                <p class="text-danger">{{$errors->first('password')}}</p>
                @enderror
            </div>
            {{-- end password --}}

            {{-- image --}}
            <div class="dragover">
                <span class="inner">
                    Upload Images
                    <span class="select" role="button">Browse</span>
                </span>

                <input name="image" type="file" class="file" />
            </div>
            {{-- image --}}

            <div class="container">
            </div>
        </div>

        <div class="divButton">
            <button type="submit" class="buttonAdd"> Add </button>
        </div>
    </form>
</div><br>
@endsection

@section('js')
<script src="{{ asset('asset/js/app.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
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
