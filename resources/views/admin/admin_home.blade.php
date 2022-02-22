@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <h1 class="text-center my-0">Administration - Home</h1>

        <ul class="list-unstyled">
            <li><a href="{{ route('admin.writings') }}">Writings</a> <span class="badge bg-dark">{{ \App\Writing::count() }}</span></li>
            <li><a href="{{ route('admin.writing_categories') }}">Writing Categories</a> <span class="badge bg-dark">{{ \App\WritingCategory::count() }}</span></li>
            <li><a href="{{ route('admin.avatars') }}">Avatars</a> <span class="badge bg-dark">{{ \App\Avatar::count() }}</span></li>
        </ul>

        <ul class="list-unstyled">
            <li><a href="#" onclick="alert('TODO');">Notes</a></li>
            <li><a href="{{ route('admin.quotes') }}">Quotes</a> <span class="badge bg-dark">{{ \App\Quote::count() }}</span></li>
        </ul>

        <a href="{{ route('admin.phpinfo') }}">phpinfo</a> | <a href="{{ route('admin.adminer') }}">adminer</a>

    </div>

@endsection
