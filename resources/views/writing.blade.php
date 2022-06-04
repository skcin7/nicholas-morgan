@extends('layouts.app')

@section('pageName', 'writing')

@section('content')
    <div class="container-fluid">

        @include('_flash_messages')

{{--        <p class="ml-3"><a class="ml-5" href="{{ route('writings') }}">← Back To Writings</a></p>--}}

        <h1 class="mt-0 mb-2" id="writing_title">{{ $writing->title }}</h1>

{{--        <div class="row">--}}
{{--            <div class="col">--}}
{{--                --}}
{{--            </div>--}}
{{--        </div>--}}

        <ul class="list-unstyled d-flex align-items-center" id="writing_details">
            <li class="py-3" id="writing_details_dates">
                Published {{ $writing->created_at->format('F j, Y') }}
                @if($writing->created_at->format('F j, Y') !== $writing->updated_at->format('F j, Y'))
                    <br/>Edited {{ $writing->updated_at->format('F j, Y') }}
                @endif

                @if(mastermind())
                    @if($writing->isPublished())
                        <i class="icon-success" title="Published {{ $writing->created_at->format('n/j/Y') }}" data-bs-toggle="tooltip" data-placement="bottom"></i>
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
                @endif
            </li>
            <li class="py-3" id="writing_details_author">
                @nick
            </li>
{{--            @if(mastermind())--}}
{{--                <li class="py-3" id="writing_details_admin_options">--}}
{{--                    <div class="btn-group dropdown">--}}
{{--                        <button id="writing{{ $writing->id }}Dropdown" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre="">--}}
{{--                            Options--}}
{{--                        </button>--}}
{{--                        <div class="dropdown-menu" aria-labelledby="writing{{ $writing->id }}Dropdown">--}}
{{--                                                        <h6 class="dropdown-header font-weight-bold">ADMIN OPTIONS</h6>--}}
{{--                            <a class="dropdown-item" href="{{ route('writing.showEdit', ['id' => $writing->getSlug()]) }}" type="button" data-action="EDIT_WRITING"><i class="icon-pencil"></i> Edit</a>--}}
{{--                            <button class="dropdown-item" type="button" data-action="TRASH_WRITING"><i class="icon-trash"></i> Trash</button>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </li>--}}
{{--            @endif--}}
        </ul>

        <div class="mb-3">
            <div class="btn-group dropdown">
                <button id="writing{{ $writing->id }}Dropdown" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre="">
                    Options
                </button>
                <div class="dropdown-menu" aria-labelledby="writing{{ $writing->id }}Dropdown">
                    <h6 class="dropdown-header font-weight-bold">ADMIN OPTIONS</h6>
                    <a class="dropdown-item" href="{{ route('writing.showEdit', ['id' => $writing->getSlug()]) }}" type="button" data-action="EDIT_WRITING"><i class="icon-pencil"></i> Edit</a>
                    <button class="dropdown-item" type="button" data-action="TRASH_WRITING"><i class="icon-trash"></i> Trash</button>
                </div>
            </div>
        </div>

        <div id="writing_body">
{{--            {!! Markdown::convertToHTML($writing->body) !!}--}}
            {!! $writing->body_html !!}
        </div>
    </div>
@endsection

@push('css')
{{--    <style>--}}
{{--        {!! $writing->css !!}--}}
{{--    </style>--}}
@endpush
