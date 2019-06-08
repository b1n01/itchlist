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

    <!-- Fonts -->
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

</head>
<body>
    <div id="app">
        <section class="nav">

            <ul class="menu">
                @guest
                @else
                <li class="menu-item">
                    <a href="{{ route('list') }}">
                        <i class="fas fa-tasks menu-icon"></i><span class="menu-label">My List</span>
                    </a>
                </li>
                @endguest   
            </ul>
            
            <a class="menu-logo-wrapper" href="{{ route('list') }}">
                <img src="{{ asset('images/logo.svg') }}" class="menu-logo">
                <span class="menu-logo-label">Itchlist</span>
            </a>

            @guest
            <div class="profile">
                <a class="profile-join" href="{{ route('login.form') }}">Join</a>
            </div>
            @else
             <div class="profile">
                @if(Auth::check())
            <div id="searchbox" class="searchbox">
                <input id="searchbox-input" class="searchbox-input" type="input" name="searches" placeholder="Search your friends">
                <i id="searchbox-icon" class="fas fa-search searchbox-icon"></i>
                 <!--<i class="fas fa-user-friends searchbox-icon"></i>-->
                <ul class="friends" id="frieds"></ul>
            </div>
            @endif
                <img id="profile-hook" src="{{ Auth::user()->pic }}" class="profile-pic">
            </div>
             <div id="profile-dropdown" class="profile-dropdown">
                <!-- <a href="{ route('home') }}" class="profile-item">My list</a> -->
                <a href="#" class="profile-item">Account</a>
                <!-- <a href="#" class="profile-item">About</a> -->
                <a 
                    class="profile-item"  
                    href="{{ route('logout') }}" 
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>
            </div>
             <form id="logout-form" action="{{ route('logout') }}" method="POST">@csrf</form>
            @endguest   
        </section>
        <div class="nav-spacer"></div>

        <main>
            @yield('content')  
        </main> 

        <section class="footer">

            <ul>
                <li class="footer-item"><a target="_blank" href="/static/about.html">About</a></li>
                <li class="footer-item"><a target="_blank" href="/static/policy.html#privacy">Privacy</a></li>
                <li class="footer-item"><a target="_blank" href="/static/policy.html#terms">Terms</a></li>
                <li class="footer-item"><a target="_blank" href="https://www.cookiesandyou.com/">Cookies</a></li>
            </ul>

            <p class="footer-disclaimer">©{{ date('Y') }} Itchlist all rights reserved</p>

        </section>
    </div>
</body>
</html>
