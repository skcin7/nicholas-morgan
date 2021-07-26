@extends('layouts.app')

@section('pageName', 'bookmarklets')

@section('content')
    <div class="container">

        <p>This page shows some JavaScript bookmarklets which I use. What's a JavaScript bookmarket? Well, it's a way to be able to execute some arbitrary JavaScript code on any page. The way it works is you save some JavaScript code as a bookmark in your browser, and then when you click on the bookmark, instead of going to that page which is how bookmarks generally work, the JavaScript code will execute instead. Just save the JavaScript snippet of code as a bookmark, then click the bookmark and that's how it works. Couldn't be simpler.</p>

        @if($bookmarklets->count())
            <div class="table-responsive">
                <table class="table table-hover table-border">
{{--                    <thead class="thead-dark">--}}
{{--                    <tr>--}}
{{--                        <th>Name</th>--}}
{{--                        <th></th>--}}
{{--                    </tr>--}}
{{--                    </thead>--}}
                    <tbody>
                    @foreach($bookmarklets as $bookmarklet)
                        <tr data-bookmarklet_id="{{ $bookmarklet->id }}">
                            <td>
                                {{ $bookmarklet->name }}
                                @if(admin())
                                    <button class="btn btn-secondary" type="button" data-action="edit_bookmarklet" data-id="{{ $bookmarklet->id }}"><i class="icon-pencil"></i> Edit</button>
                                @endif
                            </td>
                            <td>
                                <a href="javascript:{!! $bookmarklet->getJavascriptCode() !!}" class="btn btn-primary">{{ $bookmarklet->name }}</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-warning">No Bookmarklets are here!</div>
        @endif

        @if(admin())
            <button class="btn btn-primary" type="button" data-action="add_bookmarklet">Create Bookmarklet</button>
        @endif
    </div>

    @if(admin())
        @include('modals._bookmarklet_modal')
    @endif
@endsection
