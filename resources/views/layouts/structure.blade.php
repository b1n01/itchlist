<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <title>{{ config('app.name', 'Ithclist') }}</title> -->
    <meta name="description" content="Itchlist is a better wishlist. It lets you add your favourite Amazon items to your wish list and share it with your Facebook friends.">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" async></script>
 
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

    <!-- Facebook sdk -->
    <script>window.fbAsyncInit = function() { FB.init({appId: '2288050971522038', autoLogAppEvents: true, xfbml: true, version: 'v3.3' }) }</script>
    <script async defer src="https://connect.facebook.net/en_US/sdk.js"></script>

    <!-- Open Graph -->
    <meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}" />
    <meta property="og:url" content="{{ Request::url() }}" />
    <meta property="og:image" content="{{ asset('images/og-image.png') }}" />
    <meta property="og:title" content="Ithclist: a better wishlist" />
    <meta property="og:description" content="It eases the 'what can we gift?' problem. Just add your 'itches' to your list an share it with your friends" />
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="en_US" />

    <!-- Build facebook send dialog endpoint -->
    <script type="text/javascript">
        var sendDialogEndpoint = "https://www.facebook.com/dialog/send" +
            "?app_id={{ config('services.facebook.client_id') }}" +
            "&link={{ route('list') }}" + 
            "&redirect_uri={{ route('list') }}";
    </script>

    <!-- Sentry -->
    <script src="https://browser.sentry-cdn.com/5.4.2/bundle.min.js" crossorigin="anonymous"></script>
    <script>
        if(window.location.hostname.includes('itchlist.me')) {
            Sentry.init({ dsn: 'https://5db4b6559c4048a6bb6128db62e0f8db@sentry.io/1487573' });
        }
    </script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-142533789-1"></script>
    <script>
        if(window.location.hostname.includes('itchlist.me')) {
              window.dataLayer = window.dataLayer || [];
              function gtag(){dataLayer.push(arguments);}
              gtag('js', new Date());
              gtag('config', 'UA-142533789-1');
          }
    </script>

    @yield('head')
</head>
<body>

    <div id="app">
        @yield('page')  
    </div>
</body>
</html>
