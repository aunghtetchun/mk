@extends('main')

@section('content')
<div class="container">
    <div class="row align-content-center pt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="example" class="table table-striped" style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                            <tr>
                                <td>{{ $service->id}}</td>
                                <td>{{ $service->title}}</td>
                                <td class="text-nowrap">
                                    <a href="" class="btn btn-warning">
                                        <i class="fas fa-pencil-alt text-white"></i>
                                    </a>
                                    <a href="" class="btn btn-info">
                                        <i class="fas fa-map-pin"></i>
                                    </a>
                                    <form action="{{route('service.destroy',$service->id)}}" method="post" class="d-inline-block">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger"> 
                                            <i class="fas fa-trash-alt text-white"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>  
                    </table>      
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('dataTable')
    <script>
        $(document).ready(function() {
            new DataTable('#example');
        });
    </script>
@endpush