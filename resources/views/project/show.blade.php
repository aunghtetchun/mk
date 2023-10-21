@extends('main')

@section('content')
<div class="container">
    <div class="row align-content-center pt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    {{ $project->title }}
                </div>
                <div class="card-body">
                    <p>Description: {{ $project->description }}</p>
                    <p>Pinpost: {{ $project->is_pinpost ? 'Yes' : 'No' }}</p>
                    <h5>Images:</h5>
                    <div class="d-flex flex-wrap">
                        @foreach($project->photos as $photo)
                            <div class="col-12 col-md-4"><img src="{{ asset('storage/project/' . $photo->url) }}" class="w-100" alt="Project Image"></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection