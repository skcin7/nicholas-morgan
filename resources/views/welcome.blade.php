@extends('layouts.app')

@section('pageName', 'welcome')

@section('content')
    <div class="container">

        @include('_flash_messages')

        <div class="row justify-content-center">
            <div class="col-md-10">
{{--                <p>I'm a full stack web and API developer with over 10 years of industry experience in crafting highly usable fully scalable interactive web applications.</p>--}}

{{--                <p>I am based in Los Angeles, CA. I work in <a href="https://laravel.com/" target="_blank">Laravel - The PHP Framework for Web Artisans</a> because I like things that are good, and use a test-driven (TDD) development approach to make sure things don't break and ALWAYS run smoothly (as smoothly as possible).</p>--}}

{{--                <p>My experience/knowledge is very broad and covers many aspects of good software and application development including server configuration, database management/administration, HTML5 and front-end web development (including SCSS and various JavaScript frameworks including jQuery, React, and Bootstrap), SSH key configuration and modern good security techniques such as SSL/TLS Certificate installation, management of my apps through Cloudflare, DNS configuration/setup, Git for source code management, business development, search engine optimization, OAuth2 and API implementation including design of my own OAuth2 APIs and using other APIs, and probably more. PHP is my language of choice, and of course in this day and age, JavaScript, but am agnostic for many languages and frameworks.</p>--}}

{{--                <p>I use Bitbucket now for many things (free private repositories!) but here's <a href="https://github.com/skcin7" target="_blank">my public Github</a>.</p>--}}

{{--                <p>—Nick</p>--}}

{{--                <div class="mb-3">--}}
{{--                    <button class="btn btn-primary" data-action="mirror">Mirror</button>--}}
{{--                    <button class="btn btn-primary" data-action="rotate">Rotate</button>--}}
{{--                    <button class="btn btn-primary" data-action="barrel_roll">Do A Barrel Roll</button>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
@endsection
