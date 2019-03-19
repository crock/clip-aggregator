<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="battle royale, twitch clips, gaming clips, clip, video" />

	@yield('headmeta')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-136332080-1"></script>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', 'UA-136332080-1');
	</script>

	<!-- Google Adsense -->
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<script>
		(adsbygoogle = window.adsbygoogle || []).push({
			google_ad_client: "ca-pub-3627563344348929",
			enable_page_level_ads: true
		});
	</script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
	<script type="text/javascript">
		//(function($) {

			document.addEventListener("DOMContentLoaded", function (event) {
				var $hamburger = window.jQuery('.hamburger')
				var menu = window.jQuery('#menu')

				$hamburger.on('click', function(e) {
					e.preventDefault()
					$hamburger.toggleClass('is-active')
					menu.attr('data-menu-status', menu.attr('data-menu-status') == 'collapsed' ? 'expanded' : 'collapsed')
				})

				window.jQuery('.dropdown > a').on('click', function(e) {
					e.preventDefault()
					window.jQuery(this).parent().toggleClass('is-expanded')
				})
			})

		//})(window.jQuery)
	</script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-grey-lightest">
	<div id="app">
		<header>
			<div class="brand-logo">
				<a href="{{ url('/') }}">
					<img src="{{ asset('images/PBR.png') }}" alt="logo">
				</a>
			</div>
			<div class="menu-toggler">
				<button class="hamburger hamburger--slider" type="button" aria-label="Toggle navigation">
				<span class="hamburger-box">
					<span class="hamburger-inner"></span>
				</span>
				</button>
			</div>
			<nav id="menu" class="main-menu" data-menu-status="collapsed">
				<div class="dropdown game-menu">
					<a href="javascript:void(0)">Games <i class="fas fa-caret-down"></i></a>
					<div class="sub-menu">
						@foreach ($games as $game)
						<a href="{{ url('/game/' . $game->slug) }}">{{ $game->slug }}</a>
						@endforeach
					</div>
				</div>
				<a href="{{ route('clip-submission') }}"><i class="fas fa-upload"></i> Submit Clip</a>
				@guest
				<a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a>
				@endguest
				@auth
				<div class="dropdown auth-menu">
					<a href="javascript:void(0)"><i class="fas fa-user"></i> {{ Auth::user()->name }} <i class="fas fa-caret-down"></i></a>
					<div class="sub-menu">
						<a href="javascript:void(0)"
							onclick="event.preventDefault();
							document.getElementById('logout-form').submit();">
							{{ __('Logout') }}
						</a>

						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							@csrf
						</form>
					</div>
				</div>
				@endauth
			</nav>
		</header>

        <main>
            @yield('content')
        </main>
    </div>

</body>
</html>
