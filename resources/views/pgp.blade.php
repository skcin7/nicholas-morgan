@extends('layouts.app')

@section('pageName', 'pgp')

@section('content')
    <div class="container">
        <p>This key's fingerprint is <code>{{ $fingerprint }}</code>.</p>
        <pre style="user-select: all;">{{ $public_key }}</pre>
    </div>
@endsection
