@extends('layouts.app')

@section('content')
<div class="hero-banner" style="background-image: url({{ $game[0]->cover_image }});">
    <h1>{{ $game[0]->name }}</h1>
    <h2>Search the largest database of battle royale clips</h2>

	<form method="get" action="" class="form-inline my-2 d-block">
		<input type="search" name="q" placeholder="Search for clips..." aria-label="Search">
		<button type="submit">Search</button>
	</form>
</div>
<div class="container">
    <featured-clip game="{{ $game[0]->slug }}"></featured-clip>
</div>
@endsection
