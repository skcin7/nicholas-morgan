@extends('layouts.app')

@section('pageName', 'albums')

@section('content')
    <div class="container">

        @if($albums->count())

            <ul class="list-unstyled mb-0" id="albums_list">
                @foreach($albums as $album)
                    <li class="album clearfix">
{{--                        {{ $album->created_at->format('F j') }}--}}
                        <img class="img-thumbnail float-left mr-3 album_cover" src="{{ $album->getCoverUrl() }}"/>
                        <h3 class="album_title">
                            {{ $album->title }}
                            @if(admin())
                                <button class="btn btn-secondary btn-sm" type="button" data-action="edit_album" data-album-id="{{ $album->id }}"><i class="icon-pencil"></i> Edit Album</button>
                            @endif
                        </h3>
                        <h4 class="album_subtitle">{{ $album->artist }}, {{ $album->year }}</h4>

                        @if(strlen($album->blurb))
                            {!! Markdown::convertToHTML($album->blurb) !!}
                        @endif
                    </li>
                @endforeach
            </ul>

        @else
            <div class="alert alert-warning">No albums that I endorse are here... :-/</div>
        @endif

        <p>That's It! (more to come soon)</p>

        @if(admin())
            <button class="btn btn-primary" type="button" data-action="add_album">Add An Album</button>
        @endif

    </div>

    @if(admin())
        @include('_album_modal')
    @endif

@endsection
