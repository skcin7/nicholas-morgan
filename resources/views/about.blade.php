@extends('layouts.app')

@section('pageName', 'about')

@section('content')
{{--    <div id="dr_nick_background"></div>--}}

    <div id="about_container" class="container">

        <h1>About</h1>

        <p><span class="bigger">Hi, Everybody!</span> I am a <strong>computer programmer</strong>, <strong>video game collector</strong>, and <strong>business owner</strong> from California, USA (and originally from New Jersey, USA).</p>

        <p class="text-justify">As a computer programmer, I work in highly-scalable, fully-robust, beautiful web applications that solve some sort of problem or make life easier in some way, and work great in both Mobile and Desktop environments. I use a test-driven design approach, to help ensure things don't break and that my code doesn't suck. On the server-side, I like to use PHP and specifically the <a href="https://laravel.com/" target="_blank">Laravel: The PHP Framework for Web Artisans</a> framework, because I like things that are good. Though, I am not married to any specific server-side language and/or framework, and something like <a href="https://en.wikipedia.org/wiki/Brainfuck" target="_blank">brainfuck</a> or <a href="https://en.wikipedia.org/wiki/Whitespace_(programming_language)" target="_blank">Whitespace</a> or <a href="https://en.wikipedia.org/wiki/Shakespeare_Programming_Language" target="_blank">Shakespeare</a> works just as good (or usual languages like Java/Python/Ruby/whatever works too I guess). On the client side I am very well versed in HTML5 and all the JavaScriptey stuff that comes along with it (such as Node and NPM), and AngularJS sucks ass. Despite that many may consider this blasphemy, I do not have a preference to work on the server side or a client side environment, since both are necessary to solve a problem and make a great app, and I typically am working in both, often at the same time. I can handle everything from DNS setup, to server setup/management/security, to webserver configuration (NGINX and/or Apache - but NGINX is better obviously), to code engineering/development, to SQL database design/maintenance, to UI/UX design, and probably more. Things I don't do - work in your shitty "Agile" Kumbaya group and clap my hands in a circle because that's what some manager heard good teams do at some conference they were sent to once (spoiler alert: they don't). An example of some of my work is this amazingly <strike>stupid</strike> great web page that you are looking at now.
{{--            <a href="{{ route('nes') }}">Can You Defeat The Vile Red Falcon?</a>--}}
        </p>

{{--        <p>If you ever need someone to help you with solving all of the problems in your life, Dr. Nick is who to call.</p>--}}

    </div>

    <img id="dr_nick_image" src="{{ asset('images/dr_nick.png') }}" width="220"/>
@endsection
