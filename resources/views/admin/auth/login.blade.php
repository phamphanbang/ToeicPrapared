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
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app" class="vh-100">
        <div class="container h-100 w-100 d-flex justify-content-center align-items-center">
            <div class="row justify-content-center w-50">
                <div class="col-md-8 w-100">
                    <div class="d-flex flex-column align-items-center border border-2 rounded py-5 shadow-lg">
                        <div class="logo">
                            <span class="logo-span">TOEICAMP</span>
                        </div>
                        <form method="POST" action="/admin/login" class="admin-login-form">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email')?old('email'):'' }}">
                                @error('email')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control" name="password">
                                @error('password')
                                <p class="text-danger">{{$message}}</p>
                                @enderror
                                @if(session()->has('loginFail'))
                                <p class="text-danger">{{ session()->get('loginFail') }}</p>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary float-end w-100 py-2 mt-2">Login</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>

</html>