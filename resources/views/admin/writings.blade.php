@extends('layouts.app')

@section('pageName', 'admin_writings')

@section('content')
    <div class="container-fluid">
        <p><a href="{{ route('admin') }}">← Back To Admin</a></p>

        @include('_flash_messages')

        @if($writings->count())

            <div class="table-responsive">
                <table class="table table-border table-hover">
                    {{--                    <thead class="thead-dark">--}}
                    {{--                    <tr>--}}
                    {{--                        <th>Quote Details</th>--}}
                    {{--                        <th class="text-right"></th>--}}
                    {{--                    </tr>--}}
                    {{--                    </thead>--}}
                    <tbody>
                    @foreach($writings as $writing)
                        <tr>
                            <td>
                                <span class="bigger">{{ $writing->title }}</span>
                            </td>
                            <td class="text-right">
                                <button class="btn btn-secondary" data-action="admin_edit_writing" data-id="{{ $writing->id }}"><i class="icon-pencil"></i> Edit Writing</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        @else
            <div class="alert alert-warning">No writings could be found.</div>
        @endif

        <button class="btn btn-primary" type="button" data-action="admin_add_writing">Add Writing</button>
    </div>

@endsection
