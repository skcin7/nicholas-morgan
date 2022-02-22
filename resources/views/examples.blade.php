@extends('layouts.app')

@section('pageName', 'examples')

@section('content')
    <div class="container-fluid">
        <h1 class="text-center my-0">Examples</h1>
        <ul class="list-unstyled">
            <li><a href="{{ route('examples.menubar') }}">Menubar</a></li>
        </ul>
    </div>
@endsection
