<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>File Upload</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset/css/app2.css') }}">

</head>

<body>


    <div class="card">

        <div class="top">
            <p>Drag & drop image uploading</p>
            <button type="button">Upload</button>
        </div>


        <form action="" class="dragover">
            <span class="inner">
                Drag & drop image here or
                <span class="select" role="button">Browse</span>
            </span>

            {{-- <span class="on-drop">Drop images here</span> --}}
            <input name="file" type="file" class="file" multiple />
        </form>
        <div class="container">
        </div>

        
    </div>
    <script src="{{asset('asset/js/app.js')}}">

    </script>
</body>

</html>
