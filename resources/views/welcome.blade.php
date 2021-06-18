@extends('layouts.app')

@section('pageName', 'welcome')

@section('content')
    <div class="container">

        @include('_flash_messages')

        <p>WELCOME TO MY AWESOME WEB SITE!!!!!</p>
    </div>
@endsection
