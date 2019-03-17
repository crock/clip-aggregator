@extends('layouts.app')

@section('headmeta')
	<meta itemprop="name" content="Battle Royale Clips | PlayBattleRoyale.com">
    <meta property="og:title" content="Battle Royale Clips | PlayBattleRoyale.com">
    <meta name="twitter:title" content="Battle Royale Clips | PlayBattleRoyale.com">

    <meta name="description" content="Watch and comment on battle royale clips at PlayBattleRoyale.com" />
    <meta itemprop="description" content="Watch and comment on battle royale clips at PlayBattleRoyale.com">
    <meta property="og:description" content="Watch and comment on battle royale clips at PlayBattleRoyale.com">
    <meta name="twitter:description" content="Watch and comment on battle royale clips at PlayBattleRoyale.com">

    <meta itemprop="image" content="{{ asset('/images/brgames_cover.jpg') }}">
    <meta property="og:image" content="{{ asset('/images/brgames_cover.jpg') }}">
    <meta name="twitter:image" content="{{ asset('/images/brgames_cover.jpg') }}">

	<meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@PBR_Clips" />
	<meta name="twitter:creator" content="@CrocBuzz" />

	<meta property="og:locale" content="en">
	<meta property="og:url" content="https://playbattleroyale.com/">
@endsection

@section('content')
<div class="hero-banner" style="background-image: url({{ asset('/images/brgames_cover.jpg') }});">
    <h1>PlayBattleRoyale.com</h1>
    <h2>Search the largest database of battle royale clips</h2>

	<search></search>
</div>
<div class="container">
	<div class="bg-blue-lightest border-t border-b border-blue text-blue-dark px-4 py-3 my-4 mx-2" role="alert">
		<p class="font-bold">Clip Submission!</p>
		<p class="text-sm">Instantly submit any Twitch clip to our database to unlock the ability to comment on it.</p>
		<a class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded hover:no-underline" href="{{ route('clip-submission') }}"><i class="fas fa-upload"></i> Submit Clip</a>
	</div>
    <front-page></front-page>
</div>
@endsection
