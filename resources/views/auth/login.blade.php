@extends('layouts.app')

@section('pageName', 'login')

@section('content')
    <div class="container">
{{--        @if(Session::has('flash_message'))--}}
{{--            <div class="alert alert-danger py-3 mt-3">--}}
{{--                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>--}}


{{--                <div class="my-3">--}}
{{--                    {!! isset(Session::get('flash_message')['message']) ? Session::get('flash_message')['message'] : '' !!}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endif--}}

        @if(isset($errors) && count($errors) > 0)
            <div class="alert alert-danger py-3 mt-5">
                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                {!! $errors->first() !!}
{{--                <ol>--}}
{{--                    @foreach($errors->all() as $error)--}}
{{--                        <li>{!! $error !!}</li>--}}
{{--                    @endforeach--}}
{{--                </ol>--}}
            </div>
        @endif




        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-3 mt-5 border_2 box_shadow">
{{--                    <div class="card-header text-center bigger"><i class="icon-lock"></i> {{ __('Secure Login') }}</div>--}}

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="login_as" class="col-md-4 col-form-label text-md-end bigger">{{ __('Who Are You?') }}:</label>

                                <div class="col-md-6">
                                    <input id="login_as" type="text" class="form-control @error('login_as') is-invalid @enderror" name="login_as" value="{{ old('login_as') }}" required autocomplete="login_as" autofocus>

                                    @error('login_as')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end bigger">{{ __('Speak, Friend, and Enter') }}:</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label bigger" for="remember">
                                            {{ __('Remember Thy Name') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button class="btn btn-primary bigger" type="submit">
                                        {{ __('Enter') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link bigger" href="{{ route('password.request') }}">
                                            {{ __('Forgot Password') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

{{--                <p class="big text-secondary">If you don't already have an account for buying and/or selling, <a class="hover_up" href="{{ route('register') }}">click here to create buying account</a>.</p>--}}
            </div>
        </div>
    </div>



{{--<div class="container">--}}
{{--    <div class="row justify-content-center">--}}
{{--        <div class="col-md-8">--}}
{{--            <form action="{{ route('login') }}" method="post">--}}
{{--                @csrf--}}

{{--                <div class="form-group row">--}}
{{--                    <label for="login" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}

{{--                    <div class="col-md-6">--}}
{{--                        <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" name="login" value="{{ old('login') }}" required autocomplete="login" autofocus>--}}

{{--                        @error('login')--}}
{{--                        <span class="invalid-feedback" role="alert">--}}
{{--                            <strong>{{ $message }}</strong>--}}
{{--                        </span>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="form-group row">--}}
{{--                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}

{{--                    <div class="col-md-6">--}}
{{--                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">--}}

{{--                        @error('password')--}}
{{--                        <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="form-group row">--}}
{{--                    <div class="col-md-6 offset-md-4">--}}
{{--                        <div class="form-check abc-checkbox abc-checkbox-primary">--}}
{{--                            <input class="form-check-input" id="remember" name="remember" type="checkbox" checked>--}}

{{--                            <label class="form-check-label" for="remember">--}}
{{--                                {{ __('Remember Me') }}--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="form-group row mb-0">--}}
{{--                    <div class="col-md-8 offset-md-4">--}}
{{--                        <button type="submit" class="btn btn-primary">--}}
{{--                            {{ __('Login') }}--}}
{{--                        </button>--}}

{{--                        @if(Route::has('password.request'))--}}
{{--                            <a class="btn btn-link" href="{{ route('password.request') }}">--}}
{{--                                {{ __('Change Password') }}--}}
{{--                            </a>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </form>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
@endsection
