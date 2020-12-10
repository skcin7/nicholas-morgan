@extends('layouts.app')

@section('pageName', 'writing_edit')

@section('content')
    <div class="container">

        @include('_flash_messages')

{{--        <ol class="breadcrumb">--}}
{{--            <li class="breadcrumb-item"><a href="{{ route('writing') }}">Writings</a></li>--}}
{{--            <li class="breadcrumb-item active">{{ ! $writing->exists ? 'Create Writing' : 'Editing ' . $writing->title }}</li>--}}
{{--        </ol>--}}

        <form action="{{ ! $writing->exists ? route('writing.create') : route('writing.update', ['id' => $writing->getSlug()]) }}" id="writing_form" method="post">
            @csrf

            <div id="action_buttons_container">
                <button class="btn btn-primary" type="submit">Save Writing</button>
                @if($writing->exists)
                    <button class="btn btn-danger" type="submit"><i class="icon-skull"></i> Delete</button>
                @endif
            </div>

            <div class="form-group row">
                <div class="col">
                    <div class="input-group">
                        <input autocapitalize="off" autocomplete="off" autocorrect="off" class="form-control autosize {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" placeholder="Type Your Writing Title..." spellcheck="false" value="{{ old('title') ? old('title') : $writing->title }}"/>
                    </div>
                </div>
            </div>

            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" href="#editor" data-toggle="tab" role="tab" aria-controls="editor" aria-selected="false">Editor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#preview" data-toggle="tab" role="tab" aria-controls="preview" aria-selected="false">Preview</a>
                </li>
            </ul>

            <div class="tab-content my-5">
                <div class="tab-pane show active" id="editor">

                    <div class="form-group row">
                        <div class="col">
                            <div class="input-group">
                                <textarea autocapitalize="off" autocomplete="off" autocorrect="off" class="form-control autosize {{ $errors->has('body') ? 'is-invalid' : '' }}" name="body" placeholder="Type Your Writing Body..." rows="1" spellcheck="false">{{ old('body') ? old('body') : $writing->body }}</textarea>
                            </div>
                            {{--                            <span class="smaller text-muted">Markdown Formatting is Accepted</span>--}}
                        </div>
                    </div>

                </div>
                <div class="tab-pane" id="preview">
                    preview
                </div>
            </div>

        </form>
    </div>
@endsection
