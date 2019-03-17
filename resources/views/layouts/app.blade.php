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

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-grey-lightest">
    <div id="app">
            <nav class="navbar navbar-dark navbar-expand-lg">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <img src="{{ asset('images/PLAYBattleRoyale_onDark.png') }}" width="250" alt="logo">
                    </a>

					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">

						<ul class="navbar-nav mr-lg-auto">
							<li class="nav-item">
								<a class="nav-link" href="{{ url('/game/fortnite') }}">Fortnite</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ url('/game/apex') }}">Apex Legends</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ url('/game/pubg') }}">PUBG</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="{{ url('/game/h1z1') }}">H1Z1</a>
							</li>
						</ul>
                        <ul class="navbar-nav ml-lg-auto">
								<li class="nav-item">
									<a class="nav-link" href="{{ route('clip-submission') }}">
										<i class="fas fa-upload"></i> Submit Clip
									</a>
								</li>
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">
                                        <i class="fas fa-sign-in-alt"></i> Login
                                    </a>
                                </li>
							@endguest
							@auth
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        <i class="fas fa-user"></i> {{ Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="javascript:void(0)"
                                            onclick="event.preventDefault();
                                                                    document.getElementById('logout-form').submit();">
                                            {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
							@endauth
                        </ul>
                    </div>
            </nav>

        <main>
            @yield('content')
        </main>
    </div>

</body>
</html>
