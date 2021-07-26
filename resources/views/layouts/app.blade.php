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
</head>
<body>
    <div id="app">
        <header id="header">
            <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm" id="navbar">
                <div class="container-fluid">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        Nick Morgan
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <!-- Left Side Of Navbar -->
                        <ul class="navbar-nav mr-auto">
                            @if(admin())
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('about') }}">{{ __('About') }}</a>
                                </li>
                            @endif

                            @if(Route::has('writings'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('writings') }}">{{ __('Writings') }} <span class="badge badge-dark">{{ \App\Writing::getActiveCount() }}</span></a>
                                </li>
                            @endif

                            @if(admin())
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Stuff I Endorse
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
                        <ul class="navbar-nav ml-auto">
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
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ '@' . Auth::user()->name }} <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout_form').submit();">
                                            <i class="icon-off"></i> {{ __('Logout') }}
                                        </a>
                                        <form action="{{ route('logout') }}" class="d-none" id="logout_form" method="post">@csrf</form>
                                        @if(admin())
                                            <div class="dropdown-divider"></div>
                                            <h6 class="dropdown-header font-weight-bold">ADMINISTRATION</h6>
                                            <a class="dropdown-item" href="{{ route('admin') }}">Admin Home</a>
                                        @endif
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <div id="header_banner">
                <h1>{{ isset($title_prefix) ? $title_prefix : 'Nick Morgan' }}</h1>
            </div>
        </header>

        <main id="page_content" name="@yield('pageName')">
            <div id="avatar" style="display: none;">
                <a href="{{ url('/') }}"><img src="{{ asset('images/avatar.jpg') }}"></a>
            </div>

            @yield('content')
        </main>

        <footer id="footer">
            <div class="container">
                <div class="row my-3">
                    <div class="col footer_column">
                        <h6 class="mb-2">Social Media</h6>
                        <ul class="list-inline mb-3">
                            <li class="list-inline-item"><a href="https://www.instagram.com/skcin7" target="_blank"><i class="icon-instagram"></i></a></li>
                            <li class="list-inline-item"><a href="https://github.com/skcin7" target="_blank"><i class="icon-github"></i></a></li>
                        </ul>
                    </div>
                    <div class="col footer_column">
                        <h6 class="mb-2">Highly Important</h6>
                        <ul class="list-unstyled mb-3">
                            <li><a class="hover-up" href="#" data-action="mirror">Mirror</a></li>
                            <li><a class="hover-up" href="#" data-action="rotate">Rotate</a></li>
                            <li><a class="hover-up" href="#" data-action="barrel_roll">Do A Barrel Roll</a> | <a class="hover-up" href="#" data-action="barrel_roll_reverse">Reverse</a></li>
                            @if(admin())
                                <li><a class="hover-up" href="{{ route('nes') }}" data-action="play_nes">Play NES</a></li>
                            @endif
                        </ul>
                    </div>
                    <div class="col footer_column">
                        <h6 class="mb-2">Tools</h6>
                        <ul class="list-unstyled mb-3">
                            <li><a class="hover-up" href="{{ route('alphabetizer') }}">Alphabetizer</a></li>
                            <li><a class="hover-up" href="{{ route('bookmarklets') }}">Bookmarklets</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col footer_copyright_column">
                        <i class="icon-copyright"></i>{{ date('Y') }} <a href="{{ route('welcome') }}">Nick Morgan</a>. All Rights Reserved.
                        @guest
                            <a href="{{ route('login') }}"><i class="icon-skull"></i></a>
                        @else
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout_form').submit();"><i class="icon-off"></i></a>
                        @endguest
                        <br/>
                        <span class="smaller">
                            <a class="border-underlined" href="{{ route('contact') }}">How To Contact Me</a>
                            | <a class="border-underlined" href="{{ route('pgp') }}">PGP</a>
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
<script type="text/javascript">
    window.NickMorgabWebApp.setConfig({
        "base_url": '{{ config('app.url') }}',
    }).init();
</script>
</html>
