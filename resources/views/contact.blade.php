@extends('layouts.app')

@section('pageName', 'contact')

@section('content')
    <div class="container">
        <p>The best way to contact me for now is via email (or DM me on Instagram). Usually but not always I will respond within 24 hours (if not way sooner).</p>

        <ul class="list-unstyled">
            <li><strong>Email:</strong> <a href="mailto:nick@nicholas-morgan.com">nick@nicholas-morgan.com</a></li>
            <li><strong>Instagram:</strong> <a class="external_link_arrow" href="https://www.instagram.com/skcin7" target="_blank">@skcin7</a></li>
        </ul>

        <p><a href="{{ route('contact_card') }}">Download my Contact Card</a> (import into your mobile device's Contacts list)</p>
    </div>
@endsection
