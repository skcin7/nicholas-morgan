@extends('layouts.app')

@section('pageName', 'writings')

@section('content')
    <div class="container">
        <h1>Writing</h1>

        @if(Auth::check() && Auth::user()->isAdmin())
            <div id="action_buttons_container">
                <a class="btn btn-primary" href="{{ route('writing.create') }}">Create Writing</a>
            </div>
        @endif

        @if($writings->count())

            <ul id="writings_list">
                @foreach($writings as $writing)
                    <li>
                        <span class="writing_date">{{ $writing->created_at->format('F j') }}</span>
                        <a class="writing_title" href="{{ route('writing.writing', ['id' => $writing->getSlug()]) }}">{{ $writing->title }}</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p>No writing is here.</p>
        @endif


    </div>
@endsection
