@extends('layouts.ntp')

@section('content')
    <div class="container h-100">
        <div class="col-sm-12 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <form id="myForm" action="{{ route('user.updatepassword') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" id="token" name="token" value="{{ $token }}">
                <div class="form-group">
                    <h4 class="text-center attribute-label mb-5 mt-5" >{{ $email }}</h4>
                </div>
                <div class="form-group">
                    <label for="password">{{__('New Password')}}</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        required
                        autocomplete="new-password" placeholder="Unesite kombinaciju od minimum 8 karaktera.">                    

                </div>
                <div class="form-group">
                    <label for="password-confirm">{{__('Confirm Password')}}</label>
                    <input
                        type="password"
                        id="password_confirm"
                        name="password_confirmation"
                        class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password"
                        placeholder="Ponovite gornji unos">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="text-center m-5">
                    <button type="submit" class="btn btn-primary">{{ __('Change Password') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
