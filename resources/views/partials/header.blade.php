<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- FAVICON HERE -->
    <link rel="shortcut icon" href="{{asset('public/img/cv-icon.png')}}" type="image/png">
    <!-- Global CSS file, used for the header, here -->
    <link rel="stylesheet" href="{{asset('public/css/global.css')}}">
    <!-- Include CSS analagous to a specific view here -->
    @yield('css')
    <!-- Include JQuery here -->
    <script src="{{asset('public/js/jQuery/jQuery.js')}}"></script>
    <!-- Include gsap here -->
    <script src="{{asset('public/js/gsap/gsap.min.js')}}"></script>
    <!-- Font Awesome here -->
    <link rel="stylesheet" href="{{asset('public/css/font_awesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/css/font_awesome/css/fontawesome.min.css')}}">

    @yield('title')
</head>
<header id="header">
    <section class="header__left-section">
        <a href="{{route('home')}}">
            <h1 class="header__title">Aston CV</h1>
        </a>
        <ul class="header__options_small">
            <li id="open_header_submenu">Menu <i class="fa-solid fa-caret-down"></i></li>
        </ul>
        <ul class="header__options @guest header__options--no_auth @endguest">
            <i class="fa-solid fa-xmark" id="header__dropdown_close"></i>
            <a href="{{route('home')}}">
                <li class="header__first_option">Home</li>
            </a>
            @auth
                @if (auth()->user()->cv)
                <a href="{{route('update.cv')}}"><li>My CV</li></a>
                @else
                <a href="{{route('create.cv')}}"><li>Create CV</li></a>
                @endif
            @endauth
        </ul>
    </section>
    @auth
    <a href="{{route('logout')}}" class="header__account_btn">Logout</a>
    @endauth
    @guest
    <a href="{{route('login')}}" class="header__account_btn">Login</a>
    @endguest
</header>
<!-- HEADER SCRIPT -->
<script src="{{asset('public/js/header.js')}}"></script>
@yield('body')
