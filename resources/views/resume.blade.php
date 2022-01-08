@extends('layouts.app')

@section('pageName', 'resume')

@section('content')
    <div class="container-fluid">
        <p>Select the resume that you would like to get.</p>
        <ul class="list-unstyled">
            <li><a href="{{ route('resume.game_collecting') }}">Game Collecting</a></li>
        </ul>
    </div>
@endsection
