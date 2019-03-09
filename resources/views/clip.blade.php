@extends('layouts.app')

@section('content')
<iframe src="{{ $clip[0]->embed_url }}" width='100%' height='500' frameborder='0' scrolling='no' allowfullscreen='true'></iframe>
<div class="container">
	<div class="clip-details">
		<div class="clip-info">
			<h1>{{ $clip[0]->title }}</h1>
			<p class="lead">{{ $clip[0]->view_count }} views</p>
		</div>
		<div class="clip-actions">

		</div>
	</div>

    <comments-manager :clip="{{ json_encode($clip[0]) }}" :user="{{ json_encode(auth()->user()) }}"></comments-manager>
</div>
@endsection
