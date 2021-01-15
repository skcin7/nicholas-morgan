@extends('layouts.app')

@section('pageName', 'followers_difference')

@section('content')
<div class="container-fluid">
    <p>Get the difference (followers lost, and followers gained) between 2 different lists of followers.</p>

    <form action="{{ route('followers_difference') }}" enctype="multipart/form-data" method="post">
        @csrf

        <div class="form-group row">
            <div class="col">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">List Before</span>
                    </div>
                    <input name="list_before" type="file"/>
                </div>
            </div>

            <div class="col">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">List After</span>
                    </div>
                    <input name="list_after" type="file"/>
                </div>
            </div>
        </div>

        <button class="btn btn-primary" type="submit">Submit</button>


    </form>

    <div class="row">
        <div class="col">
            <fieldset>
                <legend>Followers Lost</legend>

                @if(! is_null($followers_lost))
                    <ul>
                        @foreach($followers_lost as $follower_lost)
                            <li><a href="https://www.instagram.com/{{ $follower_lost }}">{{ '@' . $follower_lost }}</a></li>
                        @endforeach
                    </ul>
                @endif
            </fieldset>
        </div>

        <div class="col">
            <fieldset>
                <legend>Followers Gained</legend>

                @if(! is_null($followers_gained))
                    <ul>
                        @foreach($followers_gained as $follower_gained)
                            <li><a href="https://www.instagram.com/{{ $follower_gained }}">{{ '@' . $follower_gained }}</a></li>
                        @endforeach
                    </ul>
                @endif
            </fieldset>
        </div>
    </div>
</div>
@endsection
