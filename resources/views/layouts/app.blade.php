<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Nick Morgan</title>

{{--    <!-- Scripts -->--}}
{{--    <script src="{{ asset('js/app.js') }}" defer></script>--}}

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
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('welcome') }}">{{ __('Home') }}</a>
                            </li>
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Authentication Links -->
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}"><i class="icon-skull"></i></a>
                                </li>
                                @if (Route::has('register'))
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
                                        <a class="dropdown-item" href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <i class="icon-off"></i> {{ __('Logout') }}
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </div>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>

            <div id="avatar">
                <a href="{{ url('/') }}"><img src="{{ url('images/avatar.jpg') }}"></a>
            </div>

            <div id="hero">
                <h1>{{ isset($page_title) ? $page_title : 'Nick Morgan' }}</h1>
            </div>
        </header>

        <main class="py-4" id="page_content" name="@yield('pageName')">
            @yield('content')
        </main>

        <footer id="footer">
            <div class="container">
                <div class="my-0">
                    <i class="icon-copyright"></i> {{ date('Y') }} <a href="mailto:nick@nicholas-morgan.com">Nick Morgan</a>. All Rights Reserved.
                    <a href="http://instagram.com/skcin7" target="_blank"><i class="icon-instagram"></i></a>
{{--                    <a href="http://github.com/skcin7" target="_blank"><i class="icon-github"></i></a>--}}
                    @auth <a href="{{ url('admin') }}">Admin</a>@endauth
                </div>
            </div>
        </footer>
    </div>
</body>
<script src="{{ mix('js/app.js') }}"></script>
<script type="text/javascript">
    window.NickMorgan.init({
        appData: {
            appUrl: '{{ env('APP_URL') }}',
        },
        components: [
            {
                name: 'SomeComponent'
            }
        ],
        pages: [
            {
                name: 'welcome'
            }
        ]
    });
</script>
</html>
