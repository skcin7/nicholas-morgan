@extends('layouts.app')

@section('pageName', 'writing_edit')

@section('content')

    <nav class="navbar navbar-expand navbar-light bg-light mb-3 p-0 border-bottom" style="flex-basis: auto;
flex-grow: 0;
flex-shrink: 1;">
        <div class="container-fluid">
            {{--            <a class="navbar-brand" href="#">Writing</a>--}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Format
                        </a>
                        <ul class="dropdown-menu mt-0" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#"><i class="icon-check"></i> TXT</a></li>
                            <li><a class="dropdown-item" href="#"><i class="icon-check-empty"></i> MD</a></li>
                            <li><a class="dropdown-item" href="#"><i class="icon-check-empty"></i> HTML</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link cursor-pointer" title="Move to Trash" data-bs-toggle="tooltip" data-bs-placement="bottom"><i class="icon-trash"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link cursor-pointer"><i class="icon-info"></i></a>
                    </li>
{{--                    <li class="nav-item">--}}
{{--                        <a class="nav-link">Saving...</a>--}}
{{--                    </li>--}}
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link">hi</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid pb-3" style="flex-grow: 1;
flex-shrink: 1;
flex-basis: auto; display: flex;
flex-flow: column;">
    <textarea autocapitalize="off" autocomplete="off" autocorrect="off" class="form-control p-2 textarea_code" id="writingBody" name="writingBody" placeholder="" spellcheck="false" style="flex-grow: 1;
flex-shrink: 1;
flex-basis: auto;"></textarea>
    </div>



        <div style="flex-basis: auto;
    flex-grow: 0;
    flex-shrink: 1; display: none;">
            yo
        </div>
        <div style="flex-grow: 1;
    flex-shrink: 1;
    flex-basis: auto; display: none;">
            hi
        </div>

    <nav class="navbar navbar-expand navbar-light bg-light mb-3 p-0 border-bottom d-none">
        <div class="container-fluid">
{{--            <a class="navbar-brand" href="#">Writing</a>--}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Format
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <li><a class="dropdown-item" href="#"><i class="icon-check"></i> TXT</a></li>
                            <li><a class="dropdown-item" href="#"><i class="icon-check-empty"></i> MD</a></li>
                            <li><a class="dropdown-item" href="#"><i class="icon-check-empty"></i> HTML</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"><i class="icon-trash"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"><i class="icon-info"></i></a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link">hi</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid mb-3 d-none">
        <div class="input-group">
            <textarea autocapitalize="off" autocomplete="off" autocorrect="off" class="form-control p-2" id="writingBody" name="writingBody" placeholder="" spellcheck="false"></textarea>
        </div>
    </div>

    <div class="container-fluid mb-3 border-top pt-3 d-none">

        @include('_flash_messages')

        <form action="/" method="post">
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
                    </ul>
                </div>
            </div>



            <div class="row mb-3">
                <div class="col">

                    <ul class="nav nav-tabs mb-0" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Home</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Profile</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            home
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            profile
                        </div>
                        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                            contact
                        </div>
                    </div>

                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item">
                            <a class="nav-link active" href="#body_html" data-bs-toggle="tab" role="tab" aria-controls="body_html" aria-selected="false">Body HTML</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#css" data-bs-toggle="tab" role="tab" aria-controls="css" aria-selected="false">CSS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#categories" data-bs-toggle="tab" role="tab" aria-controls="categories" aria-selected="false">Categories</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="body_html">
                            <div class="input-group">
                                <textarea autocapitalize="off" autocomplete="off" autocorrect="off" class="form-control autosize" id="body_html_textarea" name="body_html" placeholder="Body HTML" rows="20" spellcheck="false">{{ $writing->body_html }}</textarea>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="css">
                            <div class="input-group">
                                <textarea autocapitalize="off" autocomplete="off" autocorrect="off" class="form-control autosize" id="css_textarea" name="css" placeholder="CSS" rows="20" spellcheck="false">{{ $writing->css }}</textarea>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="categories">
                            @if(\App\WritingCategory::count())
                                <ul class="list-unstyled mb-0">
                                    @foreach(\App\WritingCategory::orderBy('name')->get() as $writingCategory)
                                        <li>
                                            <div class="form-check abc-checkbox abc-checkbox-primary">
                                                <input class="form-check-input" id="category_checkbox_{{ $writingCategory->name }}" name="writingCategories[]" type="checkbox" value="{{ $writingCategory->name }}" {{ in_array($writingCategory->name, $writing->categories->pluck('name')->toArray()) ? 'checked' : '' }}/>
                                                <label class="form-check-label" for="category_checkbox_{{ $writingCategory->name }}">
                                                    {{ $writingCategory->name }}
                                                </label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <span class="font-italic text-secondary">No Categories</span>
                            @endif
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

            {{--                @if(mastermind())--}}
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
            {{--            @if(mastermind())--}}
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
