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
                                <th>Pin Post?</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                            <tr>
                                <td>{{ $project->id}}</td>
                                <td>{{ $project->title}}</td>
                                <td>{{ Str::limit($project->description, 100) }}</td>
                                <td>{{ $project->is_pinpost ? 'Yes' : 'No'}}</td>
                                <td class="text-nowrap">
                                    <a href="{{route('project.edit',$project->id)}}" class="btn btn-warning">
                                        <i class="fas fa-pencil-alt text-white"></i>
                                    </a>
                                    <a href="{{route('project.show',$project->id)}}" class="btn btn-info">
                                        <i class="fas fa-map-pin"></i>
                                    </a>
                                    <button class="btn btn-danger" onclick="confirmDelete({{ $project->id }})">
                                        <i class="fas fa-trash-alt text-white"></i>
                                    </button>

                                    <form  action="{{route('project.destroy',$project->id)}}" method="post" class="d-none">
                                        @csrf
                                        @method('delete')
                                        <button id="dl_{{$project->id}}" class="btn btn-danger"> 
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
        function confirmDelete(projectId) {
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
                    $(`#dl_${projectId}`).click();
                }
            });
        }
    </script>
@endpush