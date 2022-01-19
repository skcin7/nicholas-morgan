@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <h1 class="text-center my-0">Administration - Home</h1>

        <ul class="list-unstyled">
            <li><a href="{{ route('admin.writings') }}">Writings</a> <span class="badge badge-dark">{{ \App\Writing::count() }}</span></li>
        </ul>

        <ul class="list-unstyled">
            <li><a href="#" onclick="alert('TODO');">Notes</a></li>
            <li><a href="{{ route('admin.quotes') }}">Quotes</a> <span class="badge badge-dark">{{ \App\Quote::count() }}</span></li>
        </ul>

        <a href="{{ route('admin.phpinfo') }}">phpinfo</a> | <a href="{{ route('admin.adminer') }}">adminer</a>

    </div>

@endsection
