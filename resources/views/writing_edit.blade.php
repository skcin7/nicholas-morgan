@extends('layouts.app')

@section('pageName', 'writing_edit')

@section('content')
    <div class="container">

        @include('_flash_messages')

{{--        <ol class="breadcrumb">--}}
{{--            <li class="breadcrumb-item"><a href="{{ route('writings') }}">Writings</a></li>--}}
{{--            <li class="breadcrumb-item active">{{ ! $writing->exists ? 'Create Writing' : $writing->title }}</li>--}}
{{--        </ol>--}}

{{--        <ol class="breadcrumb">--}}
{{--            <li class="breadcrumb-item"><a href="{{ route('writings.writing', ['id' => $writing->getSlug()]) }}">{{ $writing->title }}</a></li>--}}
{{--            <li class="breadcrumb-item active">Edit</li>--}}
{{--        </ol>--}}

{{--        <p><a href="{{ route('writings.writing', ['id' => $writing->getSlug()]) }}">← Back To Writing</a></p>--}}

        <h1>{{ $writing->exists ? 'Edit' : 'Create' }} Writing</h1>

        <form action="{{ ! $writing->exists ? route('writings.create') : route('writings.writing.process_edit', ['id' => $writing->getSlug()]) }}" id="writing_form" method="post">
            @csrf

            <div class="form-group row">
                <div class="col">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Title</span>
                        </div>
                        <input autocapitalize="off" autocomplete="off" autocorrect="off" class="form-control autosize {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title" placeholder="Type Your Writing Title..." spellcheck="false" value="{{ old('title') ? old('title') : $writing->title }}"/>
                    </div>
                </div>
            </div>

            <ul class="nav nav-tabs mb-3">
                <li class="nav-item">
                    <a class="nav-link active" href="#editor" data-toggle="tab" role="tab" aria-controls="editor" aria-selected="false">Body</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#preview" data-toggle="tab" role="tab" aria-controls="preview" aria-selected="false">Preview</a>
                </li>
            </ul>

            <div class="tab-content mb-5">
                <div class="tab-pane show active" id="editor">

                    <div class="form-group row">
                        <div class="col">
                            <div class="input-group">
                                <textarea autocapitalize="off" autocomplete="off" autocorrect="off" class="form-control autosize text-monospace {{ $errors->has('body') ? 'is-invalid' : '' }}" name="body" placeholder="Type Your Writing Body..." rows="1" spellcheck="false">{{ old('body') ? old('body') : $writing->body }}</textarea>
                            </div>
                            {{--                            <span class="smaller text-muted">Markdown Formatting is Accepted</span>--}}
                        </div>
                    </div>

                </div>
                <div class="tab-pane" id="preview">
                    //TODO
                </div>
            </div>

            <button class="btn btn-primary" type="submit"><i class="icon-floppy"></i> Save Changes</button>
            @if($writing->exists)
                <button class="btn btn-secondary" type="submit" name="cancel" value="1">Back To Writing</button>
{{--                <button class="btn btn-danger" type="submit"><i class="icon-trash"></i> Delete Writing</button>--}}
            @endif

        </form>
    </div>
@endsection
