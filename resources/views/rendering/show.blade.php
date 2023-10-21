@extends('main')

@section('content')
<div class="container">
    <div class="row align-content-center pt-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    {{ $rendering->title }}
                </div>
                <div class="card-body">
                    <p>Description: {{ $rendering->description }}</p>
                    <h5>Images:</h5>
                            <div class="col-12 col-md-4"><img src="{{ asset('storage/rendering/' . $rendering->image) }}" class="w-100" alt="Project Image"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection