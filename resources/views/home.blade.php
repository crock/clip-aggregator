@extends('layouts.app')

@section('content')
<div class="hero-banner">
    <h1>PlayBattleRoyale.com</h1>
    <h2>Search the largest database of battle royale clips</h2>

	<search></search>
</div>
<div class="container">
	<div class="bg-blue-lightest border-t border-b border-blue text-blue-dark px-4 py-3 my-4" role="alert">
		<p class="font-bold">Clip Submission!</p>
		<p class="text-sm">Instantly submit any Twitch clip to our database to unlock the ability to comment on it.</p>
		<a class="bg-blue hover:bg-blue-dark text-white font-bold py-2 px-4 rounded hover:no-underline" href="{{ route('clip-submission') }}"><i class="fas fa-upload"></i> Submit Clip</a>
	</div>
    <front-page></front-page>
</div>
@endsection
