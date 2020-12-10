@extends('layouts.app')

@section('pageName', 'writing')

@section('content')
    <div class="container">

        @include('_flash_messages')

{{--        <ol class="breadcrumb">--}}
{{--            <li class="breadcrumb-item"><a href="{{ route('writing') }}">Writings</a></li>--}}
{{--            <li class="breadcrumb-item active">{{ ! $writing->exists ? 'Create Writing' : 'Editing ' . $writing->title }}</li>--}}
{{--        </ol>--}}

        <h1>{{ $writing->title }}</h1>

        @if(Auth::check() && Auth::user()->isAdmin())
            <div id="action_buttons_container">
                <a class="btn btn-primary" href="{{ route('writing.update', ['id' => $writing->getSlug()]) }}">Edit Writing</a>
            </div>
        @endif

        <ul id="body_headings">
            <li class="heading_date">
                {{ $writing->created_at->format('F j, Y') }}
            </li>
            <li class="heading_twitter">
                skcin7
            </li>
        </ul>

        {!! Markdown::convertToHTML($writing->body) !!}
    </div>
@endsection
