@extends('layouts.app')

@section('pageName', 'contact')

@section('content')
    <div class="container-fluid">

        <h1 class="text-center my-0 fst-normal">Contact Info</h1>

{{--        <h1>Contact</h1>--}}
{{--        <p>The best way to contact me for now is via email (or DM me on Instagram). Usually but not always I will respond within 24 hours (if not way sooner).</p>--}}

        <ul class="list-unstyled mb-5">
            <li>
                <strong>Email:</strong>
                <a class="hover_up" href="mailto:nick@nicholas-morgan.com">nick@nicholas-morgan.com</a>
            </li>
            <li>
                <strong>Personal IG:</strong>
                <a class="external_link_arrow hover_up" href="https://www.instagram.com/skcin7" target="_blank">@skcin7</a>
                <span class="ms-3 fst-italic text-muted">Slide Into Them DMs ;-)</span>
            </li>
            <li>
                <strong>Contact Card:</strong>
                <a class="hover_up" href="{{ route('contact_card') }}">Download My Contact Card</a>
                <span class="ms-3 fst-italic text-muted">Import Into Your Mobile Device</span>
            </li>
        </ul>

{{--        <h2 class="text-center">My Contact Card</h2>--}}
{{--        <p><a href="{{ route('contact_card') }}">Download my Contact Card</a> (import it into your mobile device)</p>--}}
    </div>
@endsection
