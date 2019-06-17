<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Ithclist') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <!-- Fontawesom -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
 
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicons/favicon-16x16.png">
    <link rel="manifest" href="/favicons/site.webmanifest">

    <!-- Cookieconsent -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/cookieconsent@3/build/cookieconsent.min.js"></script>

    <!-- Open Graph -->
    <meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}" />
    <meta property="og:description" content="Ithclist: a better wishlist" />
    <meta property="og:image" content="{{ asset('images/logo.svg') }}" />

    @yield('head')
</head>
<body>
    <!-- load facebook sdk -->
    <script>
        window.fbAsyncInit = function() { FB.init({appId: '2288050971522038', autoLogAppEvents: true, xfbml: true, version: 'v3.3' }); };
    </script>
    <script async defer src="https://connect.facebook.net/en_US/sdk.js"></script>

    <div id="app">
        @yield('page')  
    </div>
</body>
</html>
