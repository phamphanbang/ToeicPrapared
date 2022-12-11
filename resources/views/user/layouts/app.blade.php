<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/userapp.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        @include('user.layouts.nav')

        <main class="d-flex flex-column admin-main w-100">
            <div class="main-content">
                @yield('content')
            </div>
            
        </main>
    </div>
    @include('user.layouts.footer')
</body>

</html>