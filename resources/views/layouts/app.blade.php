<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <v-app id="inspire">
        <nav-component></nav-component>
        <v-content>
            <main>
                @yield('content')
            </main>
{{--            <v-speed-dial--}}
{{--                v-model="fab"--}}
{{--                :direction="left"--}}
{{--                :open-on-hover="true"--}}
{{--                :bottom="true"--}}
{{--                :right="true"--}}
{{--                :transition="slide-x-reverse-transition"--}}
{{--                :absolute="true"--}}
{{--            >--}}
{{--                <template v-slot:activator>--}}
{{--                    <v-btn--}}
{{--                        v-model="fab"--}}
{{--                        color="blue"--}}
{{--                        dark--}}
{{--                        fab--}}
{{--                    >--}}
{{--                        <v-icon v-if="fab">mdi-close</v-icon>--}}
{{--                        <v-icon v-else>mdi-cog</v-icon>--}}
{{--                    </v-btn>--}}
{{--                </template>--}}
{{--                <v-btn--}}
{{--                    fab--}}
{{--                    dark--}}
{{--                    small--}}
{{--                    color="red"--}}
{{--                >--}}
{{--                    <v-icon>mdi-logout</v-icon>--}}
{{--                </v-btn>--}}
{{--                <v-btn--}}
{{--                    fab--}}
{{--                    dark--}}
{{--                    small--}}
{{--                    color="indigo"--}}
{{--                >--}}
{{--                    <v-icon>mdi-account-circle</v-icon>--}}
{{--                </v-btn>--}}
{{--            </v-speed-dial>--}}
        </v-content>
        <v-footer color="indigo" app>
            <span class="white--text">&copy; 2020</span>
        </v-footer>
        {{--    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">--}}
        {{--        <div class="container">--}}
        {{--            <a class="navbar-brand" href="{{ url('/') }}">--}}
        {{--                {{ config('app.name', 'Laravel') }}--}}
        {{--            </a>--}}
        {{--            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"--}}
        {{--                    aria-controls="navbarSupportedContent" aria-expanded="false"--}}
        {{--                    aria-label="{{ __('Toggle navigation') }}">--}}
        {{--                <span class="navbar-toggler-icon"></span>--}}
        {{--            </button>--}}

        {{--            <div class="collapse navbar-collapse" id="navbarSupportedContent">--}}
        {{--                <!-- Left Side Of Navbar -->--}}
        {{--                <ul class="navbar-nav mr-auto">--}}

        {{--                </ul>--}}

        {{--                <!-- Right Side Of Navbar -->--}}
        {{--                <ul class="navbar-nav ml-auto">--}}
        {{--                    <!-- Authentication Links -->--}}
        {{--                    @guest--}}
        {{--                        <li class="nav-item">--}}
        {{--                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>--}}
        {{--                        </li>--}}
        {{--                        @if (Route::has('register'))--}}
        {{--                            <li class="nav-item">--}}
        {{--                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
        {{--                            </li>--}}
        {{--                        @endif--}}
        {{--                    @else--}}
        {{--                        <li class="nav-item dropdown">--}}
        {{--                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"--}}
        {{--                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>--}}
        {{--                                {{ Auth::user()->name }} <span class="caret"></span>--}}
        {{--                            </a>--}}

        {{--                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">--}}
        {{--                                <a class="dropdown-item" href="{{ route('logout') }}"--}}
        {{--                                   onclick="event.preventDefault();--}}
        {{--                                                     document.getElementById('logout-form').submit();">--}}
        {{--                                    {{ __('Logout') }}--}}
        {{--                                </a>--}}

        {{--                                <form id="logout-form" action="{{ route('logout') }}" method="POST"--}}
        {{--                                      style="display: none;">--}}
        {{--                                    @csrf--}}
        {{--                                </form>--}}
        {{--                            </div>--}}
        {{--                        </li>--}}
        {{--                    @endguest--}}
        {{--                </ul>--}}
        {{--            </div>--}}
        {{--        </div>--}}
        {{--    </nav>--}}
    </v-app>
</div>
</body>
</html>
