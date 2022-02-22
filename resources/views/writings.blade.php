@extends('layouts.app')

@section('pageName', 'writings')

@section('content')
    <div class="container-fluid">

        @include('_flash_messages')

        <h1 class="text-center my-0">Writings</h1>
        <p>This is a collection of random writings which I have wrote.</p>

        @if(admin())
            <a class="btn btn-primary" href="{{ route('writing.showCreate') }}">Create Writing</a>
        @endif

{{--        <p>Basically sometimes I have some streams of consciousness about certain topics and for whatever reason I decide to record said streams of consciousness in writing/words, and sometimes I publish some of them here. It's mostly just me incoherently babbling/rambling on my part, with very little actual of this so-called "content" we've been hearing about, though I've heard there is actually _some_ content here too buried underneath all the fluff, but you're gonna have to look really hard to find it. I can't say I would recommend reading ANY of this, so you should probably <a href="https://www.oprah.com">leave now</a> before it's too late! <a href="https://www.eltonjohn.com/">Leave now</a>, for your own good! 😀 Okay, don't say I didn't warn you...</p>--}}

        <div id="writings_container">
            @if($writings->count())

                @foreach($writings_by_years as $year => $writings_by_year)
                    <div class="mb-5">
                        <h3 class="writings_year">{{ $year }}</h3>

                        <ul class="writings_by_year_list">
                            @foreach($writings_by_year as $writing)
                                <li class="d-flex">
                                    <div class="py-1">
                                        <span class="writing_date">{{ $writing->created_at->format('F j') }}</span>

                                        <div>
                                            @if($writing->isPublished())
                                                <i class="icon-success" title="Published {{ $writing->created_at->format('n/j/Y') }}" data-bs-toggle="tooltip" data-placement="bottom"></i>
                                            @else
                                                <i class="icon-danger text-danger" title="Not Published" data-bs-toggle="tooltip" data-placement="bottom"></i>
                                            @endif
                                            @if($writing->isHidden())
                                                <i class="icon-eye-off" title="Hidden" data-bs-toggle="tooltip" data-placement="bottom"></i>
                                            @endif
                                            @if($writing->isUnlisted())
                                                <i class="icon-warning" title="Unlisted" data-bs-toggle="tooltip" data-placement="bottom"></i>
                                            @endif
                                            @if($writing->trashed())
                                                <i class="icon-trash" title="Trashed" data-bs-toggle="tooltip" data-placement="bottom"></i>
                                            @endif
                                        </div>
                                    </div>




                                    <ul class="list-unstyled mb-0 writing_details">
                                        <li class="mb-0">
                                            <a class="writing_title" href="{{ route('writing.show', ['id' => $writing->getSlug()]) }}">{{ $writing->title }}</a>

                                            <div class="btn-group dropdown">
                                                <button id="writing{{ $writing->id }}Dropdown" class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre="">
                                                    Options
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="writing{{ $writing->id }}Dropdown">
{{--                                                    <a class="dropdown-item" href="{{ route('writing.show', ['id' => $writing->getSlug()]) }}" type="button">View Writing</a>--}}
                                                    <a class="dropdown-item" href="{{ route('writing.showEdit', ['id' => $writing->getSlug()]) }}" type="button"><i class="icon-pencil"></i> Edit</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="mb-0">
                                            @if($writing->categories->count())
                                                <strong>Categories:</strong>
                                                @foreach($writing->categories()->orderBy('name')->get() as $category)
                                                    <a class="big" href="{{ route('writings', ['category' => $category->name]) }}">{{ $category->name }}</a>
                                                    @if(! $loop->last)
                                                        <span>,</span>
                                                    @endif
                                                @endforeach
                                            @else
                                                <span class="font-italic text-muted">No Categories</span>
                                            @endif
                                        </li>
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach

            @else
                <p class="fst-italic text-muted">No Writings!</p>
            @endif
        </div>

{{--        @if(Auth::check() && Auth::user()->isAdmin())--}}
{{--            <a class="btn btn-primary" href="{{ route('writings.create') }}">Create Writing</a>--}}
{{--        @endif--}}


    </div>
@endsection
