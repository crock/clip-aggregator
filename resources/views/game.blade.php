@extends('layouts.app')

@section('content')
<div class="hero-banner" style="background-image: url({{ $game[0]->cover_image }});">
    <h1>{{ $game[0]->name }}</h1>
    <h2>Search the largest database of battle royale clips</h2>

	<search></search>
</div>
<div class="container">
    <featured-clip game="{{ $game[0]->slug }}"></featured-clip>
</div>
@endsection
