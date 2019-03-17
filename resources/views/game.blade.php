@extends('layouts.app')

@section('headmeta')
	<meta itemprop="name" content="{{ $game[0]->name }} Clips | PlayBattleRoyale.com">
    <meta property="og:title" content="{{ $game[0]->name }} Clips | PlayBattleRoyale.com">
    <meta name="twitter:title" content="{{ $game[0]->name }} Clips | PlayBattleRoyale.com">

    <meta name="description" content="Watch and comment on {{ $game[0]->name }} clips at PlayBattleRoyale.com" />
    <meta itemprop="description" content="Watch and comment on {{ $game[0]->name }} clips at PlayBattleRoyale.com">
    <meta property="og:description" content="Watch and comment on {{ $game[0]->name }} clips at PlayBattleRoyale.com">
    <meta name="twitter:description" content="Watch and comment on {{ $game[0]->name }} clips at PlayBattleRoyale.com">

    <meta itemprop="image" content="{{ $game[0]->cover_image }}">
    <meta property="og:image" content="{{ $game[0]->cover_image }}">
    <meta name="twitter:image" content="{{ $game[0]->cover_image }}">

	<meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@PBR_Clips" />
	<meta name="twitter:creator" content="@CrocBuzz" />

	<meta property="og:locale" content="en">
	<meta property="og:url" content="https://playbattleroyale.com/game/{{ $game[0]->slug }}">
@endsection

@section('content')
<div class="hero-banner" style="background-image: url({{ $game[0]->cover_image }});">
    <h1>{{ $game[0]->name }}</h1>
    <h2>Search the largest database of battle royale clips</h2>

	<search></search>
</div>
<div class="container">
	<div class="bg-blue-lightest border-t border-b border-blue text-blue-dark px-4 py-3 my-4 mx-2" role="alert">
		<p class="font-bold">Clip Submission!</p>
		<p class="text-sm">Instantly submit any Twitch clip to our database to unlock the ability to comment on it.</p>
		<a class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded hover:no-underline" href="{{ route('clip-submission') }}"><i class="fas fa-upload"></i> Submit Clip</a>
	</div>
    <featured-clip game="{{ $game[0]->slug }}"></featured-clip>
</div>
@endsection
