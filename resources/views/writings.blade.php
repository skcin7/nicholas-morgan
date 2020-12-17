@extends('layouts.app')

@section('pageName', 'writings')

@section('content')
    <div class="container">
        <h1>Writings</h1>

        @if($writings->count())
            <ul id="writings_list">
                @foreach($writings as $writing)
                    <li>
                        @if($writing->trashed())
                            <i class="icon-trash" title="This writing is in the trash." data-toggle="tooltip" data-placement="bottom"></i>
                        @endif
                        <span class="writing_date">{{ $writing->created_at->format('F j') }}</span>
                        <a class="writing_title" href="{{ route('writings.writing', ['id' => $writing->getSlug()]) }}">{{ $writing->title }}</a>
                    </li>
                @endforeach
            </ul>
        @else
            <p id="writings_list">No writings are here. :-/</p>
        @endif

        @if(Auth::check() && Auth::user()->isAdmin())
            <a class="btn btn-primary" href="{{ route('writings.create') }}">Create Writing</a>
        @endif


    </div>
@endsection
