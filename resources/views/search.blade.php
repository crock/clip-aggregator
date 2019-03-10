@extends('layouts.app')

@section('content')
<div class="hero-banner">
    <h1>PlayBattleRoyale.com</h1>
    <h2>Search the largest database of battle royale clips</h2>

	<search></search>
</div>
<div class="container">
	<h3 class="text-grey-dark text-center mt-3">Search results for: <span class="text-black italic">{{$query}}</span></h3>

	<search-results query="{{$query}}"></search-results>
</div>
@endsection
