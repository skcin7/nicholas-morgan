@extends('layouts.app')

@section('pageName', 'pgp')

@section('content')
    <div class="container-fluid">

{{--        <p>This key's fingerprint is <code>{{ $fingerprint }}</code>.</p>--}}

        <fieldset id="pgpkey_fieldset">
            <legend>
                This key's fingerprint is: <code>{{ $pgpkey['fingerprint'] }}</code>.

                <button class="btn btn-secondary btn-sm" data-action="COPY_PGP_KEY"><i class="icon-copy"></i> Copy</button>


{{--                <div class="btn-group dropdown">--}}
{{--                    <button id="alphabetizationInputOptionsDropdown" class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre="">--}}
{{--                        Options--}}
{{--                    </button>--}}
{{--                    <div class="dropdown-menu" aria-labelledby="alphabetizationInputOptionsDropdown">--}}
{{--                        <button class="dropdown-item" type="button" data-action="COPY_ALPHABETIZATION_INPUT"><i class="icon-copy"></i> Copy</button>--}}
{{--                        <button class="dropdown-item" type="button" data-action="CLEAR_ALPHABETIZATION_INPUT"><i class="icon-trash"></i> Clear</button>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </legend>

            <pre class="mb-0" id="pgpkey_publickey">{{ $pgpkey['publickey'] }}</pre>
        </fieldset>

    </div>
@endsection
