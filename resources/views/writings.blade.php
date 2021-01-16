@extends('layouts.app')

@section('pageName', 'writings')

@section('content')
    <div class="container">
        <h1>Writings</h1>

        <p>Basically sometimes I have some streams of consciousness about certain topics and for whatever reason I decide to record said streams of consciousness in writing/words, and sometimes I publish some of them here. It's mostly just me incoherently babbling/rambling on my part, with very little actual of this so-called "content", though I've heard there is actually _some_ content here too buried underneath all the fluff, but you're gonna have to look really hard to find it. I can't say I would recommend reading ANY of this, and you should probably <a href="https://www.oprah.com">leave now</a> before it's too late (for your own good)! 😀 Okay, don't say I didn't warn you.</p>

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
