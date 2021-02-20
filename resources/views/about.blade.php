@extends('layouts.app')

@section('pageName', 'about')

@section('content')
{{--    <div id="dr_nick_background"></div>--}}

    <div id="about_container" class="container">

        <h1>About Dr. Nick</h1>

        <p>Nick is a <strong>Business Owner, Video Game Collector/Preservationist, and Software Engineer</strong> from California, USA, and originally from New Jersey, USA.</p>

        <p>If you ever need someone to help you with your medical needs, Dr. Nick is who to call.</p>

    </div>

    <img id="dr_nick_image" src="{{ asset('images/dr_nick.png') }}" width="220"/>
@endsection
