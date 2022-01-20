@extends('layouts.app')

@section('pageName', 'admin_writing_categories')

@section('content')
    <div class="container-fluid">
        <p><a href="{{ route('admin') }}">← Back To Admin</a></p>

        @include('_flash_messages')

        @if($writingCategories->count())

            <ul class="list-unstyled mb-5">
                @foreach($writingCategories as $writingCategory)
                    <li class="d-flex p-2">

                        <form action="{{ route('admin.writing_categories.update', ['name' => $writingCategory->name]) }}" class="form-inline" method="post">
                            @csrf
                            <div class="input-group-prepend">
                                <div class="input-group-text">Name</div>
                                <input autocapitalize="off" autocomplete="off" autocorrect="off" spellcheck="false" class="form-control" name="name" placeholder="Name" type="text" value="{{ $writingCategory->name }}"/>
                            </div>

                            <button class="btn btn-primary" type="submit">Update</button>
                        </form>

                        <form action="{{ route('admin.writing_categories.delete', ['name' => $writingCategory->name]) }}" class="form-inline" method="post">
                            @csrf
                            <button class="btn btn-danger" type="submit"><i class="icon-trash"></i> Delete</button>
                        </form>


{{--                        <td>--}}
{{--                            --}}
{{--                        </td>--}}
{{--                        <td class="text-right">--}}
{{--                            <button class="btn btn-secondary" data-action="admin_edit_writing" data-id="{{ $writingCategory->id }}"><i class="icon-pencil"></i> Edit Writing Category</button>--}}
{{--                        </td>--}}
                    </li>
                @endforeach
            </ul>

{{--            <div class="table-responsive">--}}
{{--                <table class="table table-border table-hover">--}}
{{--                    --}}{{--                    <thead class="thead-dark">--}}
{{--                    --}}{{--                    <tr>--}}
{{--                    --}}{{--                        <th>Quote Details</th>--}}
{{--                    --}}{{--                        <th class="text-right"></th>--}}
{{--                    --}}{{--                    </tr>--}}
{{--                    --}}{{--                    </thead>--}}
{{--                    <tbody>--}}
{{--                    @foreach($writingCategories as $writingCategory)--}}
{{--                        <tr>--}}
{{--                            <td>--}}
{{--                                <span class="bigger">{{ $writingCategory->name }}</span>--}}
{{--                            </td>--}}
{{--                            <td class="text-right">--}}
{{--                                <button class="btn btn-secondary" data-action="admin_edit_writing" data-id="{{ $writingCategory->id }}"><i class="icon-pencil"></i> Edit Writing Category</button>--}}
{{--                            </td>--}}
{{--                        </tr>--}}
{{--                    @endforeach--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}

        @else
            <div class="alert alert-warning">No writing categories could be found.</div>
        @endif

        <fieldset class="p-3" style="max-width: 380px;">
            <legend class="font-weight-bold">Add Writing Category</legend>

            <form action="{{ route('admin.writing_categories.create') }}" method="post">
                @csrf

                <div class="mb-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">Name</div>
                        </div>
                        <input autocapitalize="off" autocomplete="off" autocorrect="off" spellcheck="false" class="form-control" name="name" placeholder="Name" type="text"/>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit" data-action="admin_add_writing_category">Add Writing Category</button>
            </form>
        </fieldset>


    </div>

@endsection
