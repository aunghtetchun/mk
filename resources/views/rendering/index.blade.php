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
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($renderings as $rendering)
                            <tr>
                                <td>{{ $rendering->id}}</td>
                                <td>{{ $rendering->title}}</td>
                                <td>{{ Str::limit($rendering->description, 100) }}</td>
                                <td class="text-nowrap">
                                    <a href="{{route('rendering.edit',$rendering->id)}}" class="btn btn-warning">
                                        <i class="fas fa-pencil-alt text-white"></i>
                                    </a>
                                    <a href="{{route('rendering.show',$rendering->id)}}" class="btn btn-info">
                                        <i class="fas fa-map-pin"></i>
                                    </a>
                                    <button class="btn btn-danger" onclick="confirmDelete({{ $rendering->id }})">
                                        <i class="fas fa-trash-alt text-white"></i>
                                    </button>

                                    <form  action="{{route('rendering.destroy',$rendering->id)}}" method="post" class="d-none">
                                        @csrf
                                        @method('delete')
                                        <button id="dl_{{$rendering->id}}" class="btn btn-danger"> 
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
        function confirmDelete(renderingId) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $(`#dl_${renderingId}`).click();
                }
            });
        }
    </script>
@endpush