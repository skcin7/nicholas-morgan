@extends('layouts.app')

@section('pageName', 'writing')

@section('content')
    <div class="container">

        @include('_flash_messages')

        <p><a href="{{ route('writings') }}">← Back To Writings</a></p>

        @if(! $writing->is_published)
            <div class="alert alert-warning">NOTE: This writing is currently in unpublished state.</div>
        @endif

        <ul id="writing_subheadings">
            <li class="subheading_date">
                {{ $writing->created_at->format('F j, Y') }}

                @if($writing->created_at->format('F j, Y') !== $writing->updated_at->format('F j, Y'))
                    (Updated {{ $writing->updated_at->format('F j, Y') }})
                @endif
            </li>
            <li class="subheading_twitter">
                @nick
            </li>
            @if(Auth::check() && Auth::user()->isAdmin())
                <li class="subheading_edit">
                    <a class="btn btn-primary" href="{{ route('writings.writing.edit', ['id' => $writing->getSlug()]) }}"><i class="icon-pencil"></i> Edit Writing</a>

                    @if(! $writing->trashed())
                        <a class="btn btn-danger" href="{{ route('writings.writing.trash', ['id' => $writing->getSlug()]) }}" onclick="event.preventDefault(); if(confirm('Really move this writing to the trash?')){ document.getElementById('trash_form').submit(); }"><i class="icon-trash"></i> Move To Trash</a>
                        <form action="{{ route('writings.writing.trash', ['id' => $writing->getSlug()]) }}" class="d-none" id="trash_form" method="post">@csrf</form>
                    @else
                        <a class="btn btn-danger" href="{{ route('writings.writing.untrash', ['id' => $writing->getSlug()]) }}" onclick="event.preventDefault(); if(confirm('Really remove this writing from the trash?')){ document.getElementById('untrash_form').submit(); }"><i class="icon-trash"></i> Remove From Trash</a>
                        <form action="{{ route('writings.writing.untrash', ['id' => $writing->getSlug()]) }}" class="d-none" id="untrash_form" method="post">@csrf</form>

                        <a class="btn btn-danger" href="{{ route('writings.writing.permanently_delete', ['id' => $writing->getSlug()]) }}" onclick="event.preventDefault(); if(confirm('Really permanently delete this writing? This can NOT be undone!')){ document.getElementById('permanently_delete_form').submit(); }">Permanently Delete</a>
                        <form action="{{ route('writings.writing.permanently_delete', ['id' => $writing->getSlug()]) }}" class="d-none" id="permanently_delete_form" method="post">@csrf</form>
                    @endif
                </li>
            @endif
        </ul>

        <h1 id="writing_heading">{{ $writing->title }}</h1>

        <div id="writing_body">
            {!! Markdown::convertToHTML($writing->body) !!}
        </div>
    </div>
@endsection
