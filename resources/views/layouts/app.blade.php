<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ (App::environment(['development']) ? "[Dev] " : "") . (isset($title_prefix) ? $title_prefix . ' • ' : '') }}Nick Morgan</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @stack('css')
</head>
<body>
    <div id="app">
        <header id="header">
{{--            @if(isset($show_avatar) && $show_avatar)--}}
{{--                <div id="avatar">--}}
{{--                    <a href="{{ url('/') }}"><img src="{{ asset('images/Avatar_460x460.jpg') }}"></a>--}}
{{--                </div>--}}
{{--            @endif--}}

            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" id="navbar">
                <div class="container-fluid">

                    <a class="navbar-brand hover_up" href="{{ route('web.welcome') }}">
                        <img class="rounded-circle" src="{{ asset('images/Avatar_460x460.jpg') }}" width="50" height="50">
                        <span class="bigger">Nick Morgan</span>
                    </a>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav me-auto">
{{--                            <li class="nav-item">--}}
{{--                                <a class="nav-link" href="{{ route('web.projects') }}">{{ __('Projects') }}</a>--}}
{{--                            </li>--}}
                            @if(mastermind())
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('writings') }}" data-action="CHANGE_PAGE" data-pagename="writings">{{ __('Writings') }} <span class="badge bg-dark">{{ \App\Writing::getActiveWritingsCount() }}</span></a>
                                </li>
{{--                                <li class="nav-item dropdown">--}}
{{--                                    <a class="nav-link dropdown-toggle" href="#" id="navbarUserAccountMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">--}}
{{--                                        {{ '@' . Auth::user()->name }} <span class="caret"></span>--}}
{{--                                    </a>--}}
{{--                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarUserAccountMenuLink">--}}
{{--                                        @if(admin())--}}
{{--                                            <h6 class="dropdown-header fw-bold">ADMINISTRATION</h6>--}}
{{--                                            <li><a class="dropdown-item" href="{{ route('web.mastermind') }}">Admin Home</a></li>--}}
{{--                                            <div class="dropdown-divider"></div>--}}
{{--                                        @endif--}}
{{--                                        <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="(function() { if(confirm('Really log out?')) { document.getElementById('logout_form').submit(); }})(); return false;"><i class="icon-off"></i> {{ __('Logout') }}</a></li>--}}
{{--                                        <form action="{{ route('logout') }}" class="d-none" id="logout_form" method="post">@csrf</form>--}}
{{--                                    </ul>--}}
{{--                                </li>--}}

                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        The Best Of All Time
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('albums') }}">Albums</a>
                                    </div>
                                </li>

{{--                                <li class="nav-item">--}}
{{--                                    <a class="nav-link" href="{{ route('albums') }}">{{ __('Albums I Endorse') }} <span class="badge badge-dark">{{ \App\Album::getCount() }}</span></a>--}}
{{--                                </li>--}}
                            @endif
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav">
                            <!-- Authentication Links -->
                            @guest
{{--                                <li class="nav-item">--}}
{{--                                    <a class="nav-link" href="{{ route('login') }}"><i class="icon-skull"></i></a>--}}
{{--                                </li>--}}
                                @if(Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                    </li>
                                @endif
                            @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarUserAccountMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ '@' . Auth::user()->name }} <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarUserAccountMenuLink">
                                        @if(mastermind())
                                            <h6 class="dropdown-header fw-bold">MASTERMIND</h6>
                                            <li><a class="dropdown-item" href="{{ route('web.mastermind') }}"><i class="icon-skull"></i> Mastermind Home</a></li>
                                            <div class="dropdown-divider"></div>
                                        @endif
                                        <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="(function() { if(confirm('Are you sure you want to log out?')) { document.getElementById('logout_form').submit(); }})(); return false;"><i class="icon-off"></i> {{ __('Logout') }}</a></li>
                                        <form action="{{ route('logout') }}" class="d-none" id="logout_form" method="post">@csrf</form>
                                    </ul>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            @if((isset($show_hero) && $show_hero))
                <div id="hero_banner">
                    <h1>{{ isset($hero_message) ? $hero_message : 'Nick Morgan' }}</h1>
                </div>
            @endif
        </header>

        <main id="page_content" name="@yield('pageName')">
            @yield('content')
        </main>

        <footer id="footer">
            <div class="container">
                <div class="row my-3">
{{--                    <div class="col footer_column">--}}
{{--                        <h6 class="mb-2">Social Media</h6>--}}
{{--                        <ul class="list-inline mb-3">--}}
{{--                            <li class="list-inline-item"><a href="https://www.instagram.com/skcin7" target="_blank"><i class="icon-instagram"></i></a></li>--}}
{{--                            <li class="list-inline-item"><a href="https://github.com/skcin7" target="_blank"><i class="icon-github"></i></a></li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
                    <div class="col footer_column">
                        <h6 class="mb-2">Highly Important</h6>
                        <ul class="list-unstyled mb-3">
                            <li><a class="hover-up" href="#" data-action="MIRROR">Mirror</a></li>
                            <li><a class="hover-up" href="#" data-action="ROTATE">Rotate</a></li>
                            <li><a class="hover-up" href="#" data-action="BARREL_ROLL">Do A Barrel Roll</a> | <a class="hover-up" href="#" data-action="BARREL_ROLL_REVERSE">lloR lerraB</a></li>
{{--                            @if(admin())--}}
{{--                                <li><a class="hover-up" href="{{ route('nes') }}" data-action="play_nes">Play NES</a></li>--}}
{{--                            @endif--}}
                        </ul>
                    </div>
                    <div class="col footer_column">
                        <h6 class="mb-2">Tools</h6>
                        <ul class="list-unstyled mb-3">
                            <li><a class="hover-up" href="{{ route('alphabetizer') }}">Alphabetizer</a></li>
{{--                            <li><a class="hover-up" href="{{ route('bookmarklets') }}">Bookmarklets</a></li>--}}
                        </ul>
                    </div>
                </div>
            </div>
            <div class="container-fluid my-2 text-left">
{{--                <p class="mb-0 text-muted">Copyright <i class="icon-copyright"></i> {{ date('Y') }} Nick Morgan. Made With <i class="icon-heart" style="color: red;"></i>. All Rights Reserved.</p>--}}
{{--                <ul class="list-unstyled d-inline mb-0 pb-0">--}}
{{--                    <li class="d-inline-block me-2 pe-2">--}}
{{--                        <a class="hover_up" href="{{ route('web.contact') }}">Contact Info</a>--}}
{{--                    </li>--}}
{{--                    <li class="d-inline-block me-2 pe-2">--}}
{{--                        <a class="hover_up" href="{{ route('web.pgp') }}">PGP</a>--}}
{{--                    </li>--}}
{{--                    @guest--}}
{{--                        <a href="{{ route('login') }}"><i class="icon-skull"></i></a>--}}
{{--                    @else--}}
{{--                        <a href="{{ route('logout') }}" title="Logout" data-bs-toggle="tooltip" onclick="(function() { if(confirm('Really log out?')) { document.getElementById('logout_form').submit(); }})(); return false;"><i class="icon-off"></i></a>--}}
{{--                    @endguest--}}
{{--                </ul>--}}



                <div class="row my-3">
                    <div class="col footer_copyright_column">
                        <i class="icon-copyright"></i>{{ date('Y') }} <a href="{{ route('web.welcome') }}">Nick Morgan</a>. All Rights Reserved.
                        @guest
                            <a href="{{ route('login') }}"><i class="icon-skull"></i></a>
                        @else
                            <a href="{{ route('logout') }}" title="Logout" data-bs-toggle="tooltip" onclick="(function() { if(confirm('Really log out?')) { document.getElementById('logout_form').submit(); }})(); return false;"><i class="icon-off"></i></a>
                        @endguest
                        <br/>
                        <span class="small">
                            <a class="border-underlined" href="{{ route('web.contact') }}">Contact Info</a>
                            | <a class="border-underlined" href="{{ route('web.pgp') }}">PGP</a>
{{--                            | <a class="border-underlined" href="#" data-action="play_nes">Defeat The Vile Red Falcon</a>--}}
                        </span>
                    </div>
                </div>
            </div>

{{--            <div class="container">--}}
{{--                <div class="my-0">--}}
{{--                    <i class="icon-copyright"></i> {{ date('Y') }} <a href="mailto:nick@nicholas-morgan.com">Nick Morgan</a>. All Rights Reserved.--}}
{{--                    <a href="http://instagram.com/skcin7" target="_blank"><i class="icon-instagram"></i></a>--}}
{{--                    <a href="http://github.com/skcin7" target="_blank"><i class="icon-github"></i></a>--}}
{{--                    @auth <a href="{{ url('admin') }}">Admin</a>@endauth--}}
{{--                </div>--}}
{{--            </div>--}}
        </footer>
    </div>
</body>
<script src="{{ mix('js/app.js') }}"></script>
{{--<script type="text/javascript">--}}
{{--    window.NickMorgabWebApp.setConfig({--}}
{{--        "base_url": '{{ config('app.url') }}',--}}
{{--    }).init();--}}
{{--</script>--}}
</html>
