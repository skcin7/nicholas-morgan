@extends('layouts.app')

@section('pageName', 'writing_edit')

@section('content')
    <div class="container-fluid">

        @include('_flash_messages')

        <form action="{{ $writing->exists ? route('writing.update', ['id' => $writing->getSlug()]) : route('writing.create') }}" method="post">
            @csrf

            <div class="row mb-3">
                <div class="col">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Title</div>
                        </div>
                        <input autocapitalize="off" autocomplete="off" autocorrect="off" spellcheck="false" class="form-control" name="title" placeholder="Writing Title" type="text" value="{{ $writing->title }}"/>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <ul class="list-unstyled mb-0">
                        <li>
                            <div class="form-check abc-checkbox abc-checkbox-primary">
                                <input class="form-check-input" id="is_published_checkbox" name="is_published" type="checkbox" value="1" {{ $writing->is_published ? 'checked' : '' }}/>
                                <label class="form-check-label" for="is_published_checkbox">Published</label>
                            </div>
                        </li>
                        <li>
                            <div class="form-check abc-checkbox abc-checkbox-primary">
                                <input class="form-check-input" id="is_hidden_checkbox" name="is_hidden" type="checkbox" value="1" {{ $writing->is_hidden ? 'checked' : '' }}/>
                                <label class="form-check-label" for="is_hidden_checkbox">Hidden</label>
                            </div>
                        </li>
                        <li>
                            <div class="form-check abc-checkbox abc-checkbox-primary">
                                <input class="form-check-input" id="is_unlisted_checkbox" name="is_unlisted" type="checkbox" value="1" {{ $writing->is_unlisted ? 'checked' : '' }}/>
                                <label class="form-check-label" for="is_unlisted_checkbox">Unlisted</label>
                            </div>
                        </li>
                        <li>
                            <div class="form-check abc-checkbox abc-checkbox-primary">
                                <input class="form-check-input" id="trashed_checkbox" name="trashed" type="checkbox" value="1" {{ $writing->trashed() ? 'checked' : '' }}/>
                                <label class="form-check-label" for="trashed_checkbox">Trashed</label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">

                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="#body_html" data-toggle="tab" role="tab" aria-controls="body_html" aria-selected="false">Body HTML</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#css" data-toggle="tab" role="tab" aria-controls="css" aria-selected="false">CSS</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane show active" id="body_html">
                            <div class="input-group">
                                <textarea autocapitalize="off" autocomplete="off" autocorrect="off" class="form-control autosize" id="body_html_textarea" name="body_html" placeholder="Body HTML" rows="20" spellcheck="false">{{ $writing->body_html }}</textarea>
                            </div>
                        </div>
                        <div class="tab-pane" id="css">
                            <div class="input-group">
                                <textarea autocapitalize="off" autocomplete="off" autocorrect="off" class="form-control autosize" id="css_textarea" name="css" placeholder="CSS" rows="20" spellcheck="false">{{ $writing->css }}</textarea>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <button class="btn btn-primary" type="submit">Save Writing</button>

            {{--        @if(! $writing->trashed())--}}
            {{--            <button class="btn btn-danger" type="submit"><i class="icon-trash"></i> Move To Trash</button>--}}
            {{--        @endif--}}



            {{--        --}}{{--        <p class="ml-3"><a class="ml-5" href="{{ route('writings') }}">← Back To Writings</a></p>--}}

            {{--        <h3 class="mt-0 mb-2" id="writing_title">{{ $writing->title }}</h3>--}}

            {{--        <ul class="list-unstyled d-flex" id="writing_details">--}}
            {{--            <li id="writing_details_dates">--}}
            {{--                Published {{ $writing->created_at->format('F j, Y') }}--}}
            {{--                @if($writing->created_at->format('F j, Y') !== $writing->updated_at->format('F j, Y'))--}}
            {{--                    <br/>Edited {{ $writing->updated_at->format('F j, Y') }}--}}
            {{--                @endif--}}

            {{--                @if(admin())--}}
            {{--                    @if($writing->isPublished())--}}
            {{--                        <i class="icon-success" title="Published {{ $writing->created_at->format('n/j/Y') }}" data-toggle="tooltip" data-placement="bottom"></i>--}}
            {{--                    @endif--}}
            {{--                    @if($writing->isHidden())--}}
            {{--                        <i class="icon-eye-off" title="Hidden" data-toggle="tooltip" data-placement="bottom"></i>--}}
            {{--                    @endif--}}
            {{--                    @if($writing->isUnlisted())--}}
            {{--                        <i class="icon-warning" title="Unlisted" data-toggle="tooltip" data-placement="bottom"></i>--}}
            {{--                    @endif--}}
            {{--                    @if($writing->trashed())--}}
            {{--                        <i class="icon-trash" title="Trashed" data-toggle="tooltip" data-placement="bottom"></i>--}}
            {{--                    @endif--}}
            {{--                @endif--}}
            {{--            </li>--}}
            {{--            <li id="writing_details_author">--}}
            {{--                @nick--}}
            {{--            </li>--}}
            {{--            @if(admin())--}}
            {{--                <li id="writing_details_admin_options">--}}
            {{--                    <div class="btn-group dropdown">--}}
            {{--                        <button id="writing{{ $writing->id }}Dropdown" class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre="">--}}
            {{--                            Options--}}
            {{--                        </button>--}}
            {{--                        <div class="dropdown-menu" aria-labelledby="writing{{ $writing->id }}Dropdown">--}}
            {{--                            --}}{{--                            <h6 class="dropdown-header font-weight-bold">ADMIN OPTIONS</h6>--}}
            {{--                            <button class="dropdown-item" type="button" data-action="EDIT_WRITING"><i class="icon-pencil"></i> Edit</button>--}}
            {{--                            <button class="dropdown-item" type="button" data-action="TRASH_WRITING"><i class="icon-trash"></i> Trash</button>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                </li>--}}
            {{--            @endif--}}
            {{--        </ul>--}}

            {{--        <div id="writing_body">--}}
            {{--            --}}{{--            {!! Markdown::convertToHTML($writing->body) !!}--}}
            {{--            {!! $writing->body_html !!}--}}
            {{--        </div>--}}


        </form>


        @if($writing->trashed())
            <form action="{{ route('writing.permanently_delete', ['id' => $writing->getSlug()]) }}" method="post">
                @csrf
                {{--            <button class="btn btn-secondary" type="submit">Remove From Trash</button>--}}
                <button class="btn btn-danger" type="submit">Permanently Delete</button>
            </form>
        @endif


    </div>
@endsection

{{--@push('css')--}}
{{--    <style>--}}
{{--        {!! $writing->css !!}--}}
{{--    </style>--}}
{{--@endpush--}}
