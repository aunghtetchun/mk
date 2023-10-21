@extends('main')

@section('content')
<div class="container">
    <div class="row align-content-center pt-5">
        <div class="col-12 d-flex flex-wrap">
            <div class="card col-5">
                <div class="card-body">
                    <form action="{{ route('project.update',$project->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" value="{{$project->title}}" class="form-control" id="title" name="title" placeholder="Title">
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea class="form-control" id="summernote" name="description">{{$project->description}}</textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_pinpost" name="is_pinpost">
                            <label class="form-check-label" for="is_pinpost">Is Pin Post?</label>
                        </div>
                        <button type="submit" class="btn btn-outline-primary">Update</button>
                    </form>

                </div>
            </div>
            <div class=" col-7">
                <div class="card">
                <div class="card-body">
                    <form action="{{ route('photo.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" value="{{ $project->id }}" name="project_id">
                        <div class="form-group input-field">
                            <div class="input-images-1" style="padding-top: .5rem;"></div>
                            @error('images')
                            <small class="invalid-feedback font-weight-bold" role="alert">
                                {{ $message }}
                            </small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary " ><i class="fas fa-plus-square mr-1"></i> Upload Photos</button>
                    </form>
                    <div class="d-flex mt-3" style="overflow-x: scroll;" >
                        @foreach($project->photos as $photo)
                            <div class="mr-2" >
                                <img src="{{ asset("/storage/project/".$photo->url) }}" alt="" >
                                <form action="{{ route('photo.destroy',$photo->id) }}"  method="post">
                                    @csrf
                                    @method("DELETE")
                                    <button onClick="return confirm('Are you sure you want to delete?')" class="btn  btn-sm btn-danger text-left" style="margin-top: -330px; margin-left: 8px">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>

                        @endforeach
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('summernote')
    <script>
        $('.input-images-1').imageUploader();
    </script>
@endpush