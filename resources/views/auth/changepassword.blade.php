@extends('layouts.ntp')

@section('content')
    <div class="row">
        <div class="col-sm-2 offset-sm-5">
            <form id="myForm" action="{{ route('user.updatepassword') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" id="token" name="token" value="{{ $token }}">
                <div class="form-group">
                    <h4 class="text-center attribute-label mb-5 mt-5" >{{ $email }}</h4>
                </div>
                <div class="form-group">
                    <label for="password">{{__('New Password')}}</label>
                    <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password-confirm">{{__('Confirm Password')}}</label>
                    <input type="password" id="password_confirm" name="password_confirmation" class="form-control required autocomplete="new-password">

                </div>
                <div class="text-center m-5">
                    <button type="submit" class="btn btn-primary">{{ __('Change Password') }}</button>
                </div>
            </form>
        </div>
    </div>

@endsection
