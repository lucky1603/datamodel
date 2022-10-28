@extends('layouts.backbone')

@section('title')
    Rastuce - Prijava
@endsection

@section('body-content')
    <div class="w-100 h-100 px-1">
        <div class="row bg-dark" >
            <div class="col-lg-4 h-100">
                <img src="/images/custom/ntplogo.png" class="ml-3 m-4" style="width: 90%"/>
            </div>

            <div class="col-lg-3 offset-lg-5 h-100" style="display: flex; align-items: center; justify-content: center">
                <img src="/images/custom/rastuce.png" class="m-4" style="height: 150px"/>
            </div>
        </div>
        <div class="row mx-1 no-gutters">
            <div class="col-12 col-lg-8 offset-lg-2">
                <div class="text-center mb-4 mt-4">
                    <h1 class="attribute-lagbel">{{ __('PRIJAVA')}}</h1>
                </div>
                <form action="{{ route('storeRastuce') }}" method="post" enctype="multipart/form-data" id="myRastuceForm" class="mt-4 w-100 h-100">
                    @csrf
                    <div class="row form-group mt-2">
                        @php
                            $attribute = $attributes->where('name', 'ntp')->first();
                            $value = old($attribute->name);
                        @endphp
                        <label for="{{ $attribute->name }}" class="col-lg-2 attribute-label col-form-label col-form-label-sm mandatory-label">Naučno-tehnološki park u kojem aplicirate za Incubation BITF program:</label>
                        <div class="col-lg-10">
                            <select id="{{$attribute->name}}"
                                    name="{{$attribute->name}}"
                                    class="form-control form-control-sm mandatory-field"
                                    @error($attribute->name) is-error @enderror>
                                <option value="0" @if( $value == 0) selected @endif>Izaberite...</option>
                                @foreach($attribute->getOptions() as $key => $val)
                                    <option value="{{$key}}" @if($key == $value) selected @endif>{{$val}}</option>
                                @endforeach
                            </select>
                            @error($attribute->name)
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>


                    @include('profiles.partials._rastuce', ['mode' => 'anonimous'])


                    <div class="mt-4" style="display: flex" id="submitArea">
                        <input
                            type="checkbox"
                            id="gdpr"
                            name="gdpr"
                            style="position: relative; top:4px"
                            class="@error('gdpr') is-invalid @enderror"
                            @if(old('gdpr') == 'on') checked @endif>
                        <label class="ml-1 attribute-label">
                            Popunjavanjem i podnošenjem ove prijave potvrdjujem da sam saglasan sa svim navedenim uslovima poziva.
                        </label>
                    </div>
                    @error('gdpr') <div class="alert alert-danger">{{ $message }}</div> @enderror

                    <div class="row mt-4">
                        <div class="col-md-4"></div>
                        <div class="form-group col-md-3">
                            <div class="captcha text-center">
                                <span>{!! captcha_img('ntp') !!}</span>
                                <button type="button" id="refresh" class="btn btn-sm btn-success text-light"><i class="mdi mdi-refresh font-18" id="refresh"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="form-group col-md-3">
                            <input id="captcha" type="text" class="form-control" placeholder="Unesite karaktere sa slike" name="captcha"></div>

                    </div>
                    @error('captcha') <div class="alert alert-danger text-center">{{ $message }}</div>@enderror
                    <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: center">
                        <button type="button" id="buttonSend" class="btn btn-sm btn-primary rounded-pill mx-1 mt-4" style="width: 250px" title="{{ __('gui.Application-SaveDataAndSendApp') }}">
                            <span id="okSpinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{ __('Save Data and Create Profile') }}
                        </button>

                        <button type="button" id="buttonCancel" class="btn btn-sm btn-outline-primary rounded-pill mx-1 mt-4" style="width: 250px" title="{{ __('gui.Application-ReturnToMain') }}">
                            <span id="cancelSpinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            {{ __('Return to Main Page') }}
                        </button>
                    </div>
                    <div class="text-center mt-4">
                        <p>Ukoliko ste već potvrdili vašu e-mail adresu i kreirali nalog, prijaviti se sa vašim korisničkim imenom i lozinkom
                           na adresi <a href="https://platforma.ntpark.rs/login" target="_blank">https://platforma.ntpark.rs/login</a> i nastavite
                           popunjavanje prijave.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
