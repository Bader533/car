@extends('dashboard.starter')
@section('title', 'all cities')
@section('pageName', 'All Cities')

@section('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-
         alpha/css/bootstrap.css" rel="stylesheet">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

@endsection

@section('content')

<div class="col-md-12">
    <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th class="text-center">id</th>
                <th class="text-center">name</th>
                <th class="text-center">Car Count</th>
                <th class="text-center">action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cities as $city)
            <tr>
                <td class="text-center">{{$city->id}}</td>
                <td class="text-center">{{$city->name}}</td>
                <td class="text-center">{{$city->cars->count()}}</td>
                <td class="text-center">
                    <div class="input-group">
                        <form action="{{route('city.destroy', $city->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i>
                            </button>
                        </form>&nbsp;
                        <a href="{{ route('city.edit', $city->id)}}" class="btn btn-primary"> <i
                                class="fa fa-pen"></i></a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
    <div class="container">
        <div class="row">
            <div class="col-sm">
                <div style="float: right">
                    {{ $cities->links() }}
                </div>
            </div>
        </div>
    </div>

</div><br>
@endsection

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type="text/javascript">
    // $(function() {

    //         var table = $('#example').DataTable({
    //             processing: true,
    //             serverSide: true,
    //             ajax: "{{ route('city.index') }}",
    //             columns: [{
    //                     data: 'id',
    //                     name: 'id'
    //                 },
    //                 {
    //                     data: 'name',
    //                     name: 'name'
    //                 },
    //                 ,
    //                 // {
    //                 //      data: 'cars',
    //                 //      name: 'cars'
    //                 // },
    //                 {
    //                     data: 'action',
    //                     name: 'action',
    //                     orderable: false,
    //                     searchable: false
    //                 },
    //             ]
    //         });

    //     });

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
