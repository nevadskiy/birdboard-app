<!DOCTYPE html>
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
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="bg-page text-default">
    <div id="app">
        <nav class="bg-nav shadow-sm">
            <div class="container mx-auto">
                <div class="flex items-center py-2">
                    <div class="mr-auto">
                        <a class="font-bold" href="{{ route('projects.index') }}">{{ config('app.name') }}</a>
                    </div>

                    <div class="ml-auto flex items-center">
                        <theme-switcher class="mr-8 flex items-center"></theme-switcher>

                        @guest
                            <div class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </div>
                            @if (Route::has('register'))
                                <div class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </div>
                            @endif
                        @else
                            <div class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle flex items-center" href="#" role="button">
                                    <img class="w-8 h-8 rounded-full mr-2" src="http://www.tsu.ru/upload/medialibrary/679/net-foto-m.png" alt="">
                                    {{ Auth::user()->name }}
                                </a>
                            </div>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <main class="container mx-auto py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
