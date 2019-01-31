@extends('layouts.app')

@section('content')
<iframe src="{{ $clip->embed_url }}" width='100%' height='500' frameborder='0' scrolling='no' allowfullscreen='true'></iframe>
<div class="container">
    <div class="clip-info">
        <h1>{{ $clip->title }}</h1>
        <p class="lead">{{ $clip->views }} views</p>
    </div>
</div>
@endsection
