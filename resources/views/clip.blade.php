@extends('layouts.app')

@section('content')
<vue-headful
	title="{{ $clip[0]->title }}"
	description="Watch and comment on this clip by {{ $clip[0]->broadcaster_name }}."
	keywords="battle royale, twitch clips, gaming clips, clip, video"
    image="{{ $clip[0]->thumbnail_url }}"
    lang="{{ $clip[0]->language }}"
	locale="{{ $clip[0]->language }}"
    url="https://playbattleroyale.com/clip/{{ $clip[0]->twitch_clip_id }}">
	</vue-headful>

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
	@guest
	<div class="bg-blue-lightest border-t border-b border-blue text-blue-dark px-4 py-3 my-4" role="alert">
		<p class="font-bold">Clip Commenting</p>
		<p class="text-sm">Login to leave a comment on this clip!</p>
		<a class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded hover:no-underline" href="{{ route('login') }}"><i class="fas fa-sign-in"></i> Login</a>
	</div>
	@endguest

    <comments-manager :clip="{{ json_encode($clip[0]) }}" :user="{{ json_encode(auth()->user()) }}"></comments-manager>
</div>
@endsection
