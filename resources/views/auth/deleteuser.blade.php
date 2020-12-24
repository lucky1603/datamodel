@extends('layouts.app')

@section('content')
    <h1>{{__('gui.UserDeleteTitle', ['username' => $user->name])}}</h1>
    <form method="POST" enctype="multipart/form-data" action="{{ route('user.deleted') }}">
        @csrf
        <input type="hidden" id="user_id" name="user_id" value="{{$user->id}}">
        <input type="hidden" id="return_to" name="return_to" value="{{ $return_to }}">
        <p>{{ __('gui.UserDeleteQuestion', ['username' => $user->name]) }}</p>

        <div class="form-group row">
            <div class="col-sm-6" style="text-align: right">
                <button type="submit" class="btn btn-primary">{{ __('Yes') }}</button>
            </div>
            <div class="col-sm-6" style="text-align: left">
                <a href="{{ $return_to }}" role="button" class="btn btn-secondary">{{ __('No') }}</a>
            </div>
        </div>
    </form>
@endsection
