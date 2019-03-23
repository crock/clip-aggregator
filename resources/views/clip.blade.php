@extends('layouts.app')

@section('headmeta')
	<meta itemprop="name" content="{{ $clip[0]->title }}">
    <meta property="og:title" content="{{ $clip[0]->title }}">
    <meta name="twitter:title" content="{{ $clip[0]->title }}">

    <meta name="description" content="Watch and comment on this clip by {{ $clip[0]->broadcaster_name }}." />
    <meta itemprop="description" content="Watch and comment on this clip by {{ $clip[0]->broadcaster_name }}.">
    <meta property="og:description" content="Watch and comment on this clip by {{ $clip[0]->broadcaster_name }}.">
    <meta name="twitter:description" content="Watch and comment on this clip by {{ $clip[0]->broadcaster_name }}.">

    <meta itemprop="image" content="{{ $clip[0]->thumbnail_url }}">
    <meta property="og:image" content="{{ $clip[0]->thumbnail_url }}">
    <meta name="twitter:image" content="{{ $clip[0]->thumbnail_url }}">

	<meta property="og:video:width" content="640" />
	<meta property="og:video:height" content="426" />
	<meta property="og:video" content="{{ $clip[0]->embed_url }}" />
	<meta property="og:video:type" content="text/html" />

	<meta name="twitter:card" content="player" />
    <meta name="twitter:site" content="@pbrclips" />
    <meta name="twitter:player" content="{{ $clip[0]->embed_url }}" />
    <meta name="twitter:player:width" content="320" />
    <meta name="twitter:player:height" content="180" />
    <meta name="twitter:player:stream" content="{{ $clip[0]->embed_url }}" />
    <meta name="twitter:player:stream:content_type" content="video/mp4" />

	<meta property="og:locale" content="{{ $clip[0]->language }}">
	<meta property="og:url" content="https://playbattleroyale.com/clip/{{ $clip[0]->twitch_clip_id }}">
@endsection

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
