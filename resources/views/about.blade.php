@extends('layouts.app')

@section('pageName', 'about')

@section('content')
{{--    <div id="dr_nick_background"></div>--}}

    <div id="about_container" class="container">

        <h1>About Dr. Nick</h1>

        <p><span class="bigger">Hi, Everybody!</span> Dr. Nick is a <strong>Business Owner, Video Game Collector/Preservationist, and Software Engineer</strong> from California, USA (and originally from New Jersey, USA).</p>

        <p class="text-justify">As a software engineer, I specialize in highly-scalable, fully-robust, beautiful looking web applications that look and work great in Mobile and Desktop for solving a specific problem. I use a test-driven design approach, to ensure nothing breaks. On the server-side, I typically utilize <a href="https://laravel.com/" target="_blank">Laravel: The PHP Framework for Web Artisans</a>, because I like things that are good, though I am not married to any specific server-side language and/or framework combination. I am completely agnostic to working on an application's server-side, or its front-end, and do not specialize in or have a preference for either (both are awesome, and necessary). I can handle everything from DNS setup, to server management, to webserver configuration, to developing server-side code, to SQL database maintenance/design, to developing front-end code, to UI/UX user experience design, and probably more. An example of some of my work is this very <strike>stupid</strike> awesome web page that you are using now. Isn't it awesome?</p>

        <p>If you ever need someone to help you with solving all of the problems in your life, Dr. Nick is who to call.</p>

    </div>

    <img id="dr_nick_image" src="{{ asset('images/dr_nick.png') }}" width="220"/>
@endsection
