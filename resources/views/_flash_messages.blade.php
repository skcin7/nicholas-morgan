@if(Session::has('flash_message'))
    <div class="flash-message">
        <div class="alert alert-{{ isset(Session::get('flash_message')['type']) ? Session::get('flash_message')['type'] : 'secondary' }} py-2">
            @if(! (isset(Session::get('flash_message')['dismissable']) && Session::get('flash_message')['dismissable'] === false))
                <button type="button" class="close" data-dismiss="alert">×</button>
            @endif
{{--            <div class="my-3">--}}
                {!! isset(Session::get('flash_message')['message']) ? Session::get('flash_message')['message'] : '' !!}
{{--            </div>--}}
        </div>
    </div>
@endif

@if(isset($errors) && count($errors) > 0)
    <div class="alert alert-danger">
        <p><strong>Please correct the following errors:</strong></p>
        <ol>
            @foreach($errors->all() as $error)
                <li>{!! $error !!}</li>
            @endforeach
        </ol>
    </div>
@endif
