@extends('layouts.app')

@section('pageName', 'pgp')

@section('content')
    <div class="container-fluid p-3">
        <p class="mb-1">
            @if(isset($pgpkey['fingerprint']))
                This Key's Fingerprint Is: <code>{{ $pgpkey['fingerprint'] }}</code>.
            @endif
            <button class="btn btn-secondary" data-event-action="copy_pgp_key_to_clipboard"><i class="icon-copy"></i> Copy To Clipboard</button>
        </p>
        <pre class="mb-0 user_select_all" id="pgpkey_publickey">{{ $pgpkey['publickey'] }}</pre>
    </div>
@endsection
