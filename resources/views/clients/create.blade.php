@extends('layouts.create')

@section('title')
    <h1 class="page-title">Dodavanje novog klijenta</h1>
@endsection

@section('create_user')
    <hr style="margin-top:40px;"/>
    <h3 style="text-align: center; margin-top:20px; margin-bottom: 20px">Osnovni korisnik</h3>
    <div class="form-group row">
        <div class="col-sm-3"></div>
        <label for="user_name" class="col-sm-2 col-form-label">Ime korisnika</label>
        <div class="col-sm-4">
            <input type="text"
                   class="form-control @error('user_name') is-invalid @enderror"
                   id="user_name"
                   name="user_name"
                   value="{{ old('user_name') }}"
                   required
                   autocomplete="user_name"
                   autofocus>
            @error('user_name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-sm-3"></div>
    </div>
    <div class="form-group row">
        <div class="col-sm-3"></div>
        <label for="user_email" class="col-sm-2 col-form-label">E-Mail</label>
        <div class="col-sm-4">
            <input type="email"
                   class="form-control @error('user_email') is-invalid @enderror"
                   id="user_email"
                   name="user_email"
                   value="{{ old('user_email') }}"
                   required
                   autocomplete="user_email"
            >
            @error('user_email')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-sm-3"></div>
    </div>
    <div class="form-group row">
        <div class="col-sm-3"></div>
        <label for="user_password" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-4">
            <input type="password"
                   class="form-control @error('user_password') is-invalid @enderror"
                   id="user_password"
                   name="user_password"
                   required
                   autocomplete="user_password"
            >
            @error('user_password')
            <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="col-sm-3"></div>
    </div>
    <div class="form-group row">
        <div class="col-sm-3"></div>
        <label for="user_repeat_password" class="col-sm-2 col-form-label">Repeat Password</label>
        <div class="col-sm-4">
            <input type="password"
                   class="form-control"
                   id="user_repeat_password"
                   name="user_repeat_password"
                   required
                   autocomplete="user_repeat_password"
            >
        </div>
        <div class="col-sm-3"></div>
    </div>
    <hr style="margin-top:20px;"/>
@endsection
