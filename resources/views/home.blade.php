@extends('layouts.app')

@section('content')
<div class="hero-banner">
    <h1>PlayBattleRoyale.com</h1>
    <h2>Search the largest database of battle royale clips</h2>

	<form method="get" action="" class="form-inline my-2 d-block">
		<input type="search" name="q" placeholder="Search for clips..." aria-label="Search">
		<button type="submit">Search</button>
	</form>
</div>
<div class="container">
    <featured-clip game="random"></featured-clip>
</div>
@endsection
