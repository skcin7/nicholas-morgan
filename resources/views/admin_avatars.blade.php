@extends('layouts.app')

@section('pageName', 'admin_avatars')

@section('content')
    <div class="container-fluid">
        <p><a href="{{ route('admin') }}">← Back To Admin</a></p>

        @include('_flash_messages')

        @if($avatars->count())

            <div class="table-responsive">
                <table class="table table-border table-hover">
                    <tbody>
                    @foreach($avatars as $avatar)
                        <tr>
                            <td>
                                <img src="{{ $avatar->getFormat('md') }}"/>
                            </td>
                            <td>
                                <span class="bigger">{{ $avatar->name }}</span>
                            </td>
                            <td class="text-right">
                                <button class="btn btn-secondary" data-action="admin_edit_writing" data-id="{{ $avatar->id }}"><i class="icon-pencil"></i> Edit Writing</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        @else
            <p class="font-italic text-muted">No Avatars!</p>
        @endif

        <fieldset>
            <legend class="font-weight-bold font-italic"><u>Add Avatar:</u></legend>

            <form action="{{ route('admin.avatars.create') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="form-group row photo_file_container">
                    <div class="col">
                        <div class="input-group">
                            <button class="btn btn-secondary btn_file_container">
                                <span>Select Avatar...</span>
                                <input accept="image/*" name="avatar_file" type="file"/>
                            </button>
                        </div>
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Upload Avatar</button>
            </form>
        </fieldset>
    </div>

@endsection
