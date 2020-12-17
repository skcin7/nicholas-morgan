@extends('layouts.app')

@section('pageName', 'writings')

@section('content')
    <div class="container">
        <h1>Writings</h1>

        <div id="writings_container">
            @if($writings->count())

                @foreach($writings_by_years as $year => $writings_by_year)
                    <h3 class="writings_year">{{ $year }}</h3>

                    <ul class="writings_by_year_list">
                        @foreach($writings_by_year as $writing)
                            <li>
                                @if($writing->trashed())
                                    <i class="icon-trash" title="The writing is in the trash." data-toggle="tooltip" data-placement="bottom"></i>
                                @endif
                                @if(! $writing->published())
                                    <i class="icon-eye-off" title="The writing is not published." data-toggle="tooltip" data-placement="bottom"></i>
                                @endif
                                <span class="writing_date">{{ $writing->created_at->format('F j') }}</span>
                                <a class="writing_title" href="{{ route('writings.writing', ['id' => $writing->getSlug()]) }}">{{ $writing->title }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endforeach

            @else
                <p>No writings are here. :-/</p>
            @endif
        </div>

        @if(Auth::check() && Auth::user()->isAdmin())
            <a class="btn btn-primary" href="{{ route('writings.create') }}">Create Writing</a>
        @endif


    </div>
@endsection
