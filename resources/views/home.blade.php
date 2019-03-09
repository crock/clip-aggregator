@extends('layouts.app')

@section('content')
<div class="hero-banner">
    <h1>PlayBattleRoyale.com</h1>
    <h2>Search the largest database of battle royale clips</h2>

	<search></search>
</div>
<div class="container">
    <featured-clip game="random"></featured-clip>
</div>
@endsection
