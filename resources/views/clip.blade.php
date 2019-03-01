@extends('layouts.app')

@section('content')
<iframe src="{{ $clip['data'][0]['embed_url'] }}" width='100%' height='500' frameborder='0' scrolling='no' allowfullscreen='true'></iframe>
<div class="container">
	<div class="clip-details">
		<div class="clip-info">
			<h1>{{ $clip['data'][0]['title'] }}</h1>
			<p class="lead">{{ $clip['data'][0]['view_count'] }} views</p>
		</div>
		<div class="clip-actions">
			<thumb-ratings></thumb-ratings>
		</div>
	</div>

    <comments-manager :user="{{ json_encode(auth()->user()) }}"></comments-manager>
</div>
@endsection
