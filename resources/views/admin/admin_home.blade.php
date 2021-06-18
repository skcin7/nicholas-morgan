@extends('layouts.app')

@section('content')

    <div class="container">

        <ol class="breadcrumb">
            <li class="breadcrumb-item active">Admin</li>
        </ol>

        <ul class="list-unstyled">
            <li><a href="#" onclick="alert('TODO');">Notes</a></li>
        </ul>

        <a href="{{ route('admin.phpinfo') }}">phpinfo</a> | <a href="{{ route('admin.adminer') }}">adminer</a>

    </div>

@endsection
