@extends('layouts.app')

@section('pageName', 'contacts')

@section('content')
    <div class="container-fluid">

        @include('_flash_messages')

        <h1 class="text-center my-0">Contacts</h1>

        <button class="btn btn-primary" type="button">Create Contact</button>

        @if($contacts->count())

            @foreach($contacts as $contact)

            @endforeach

        @else
            <p>No Contacts</p>
        @endif

    </div>
@endsection
