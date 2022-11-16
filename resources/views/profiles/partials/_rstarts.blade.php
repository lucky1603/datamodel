@if(isset($model) && count($errors))
    <div class="alert alert-danger">Promene nisu sačuvane zbog validacionih grešaka. Prekontrolišite formu. Polja sa porgrešnim unosima su označena crvenom bojom.</div>
@endif

@if(!isset($model))
<div class="attribute-label font-14 m-1 p-4" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
    <p>Obavezna polja za kreiranje profila su označena zvezdicom (<span class="text-danger">*</span>) i svetlo
        plavom pozadinom.</p>
</div>
@endif
<div class="form-group row mt-2">
    @php
        $attribute = $attributes->where('name', 'app_type')->first();
        $value = $attribute->getValue() ?? old($attribute->name);
    @endphp
    <label for="{{ $attribute->name }}" class="col-lg-2 attribute-label col-form-label col-form-label-sm mandatory-label">{!! $attribute->label !!}</label>
    <div class="col-lg-10">
        <select id="{{$attribute->name}}" name="{{$attribute->name}}"
                class="form-control form-control-sm mandatory-field"
                @error($attribute->name) is-error @enderror
                @if(isset($model) && $value != null) disabled @endif>
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
<div class="row form-group mt-2">
    @php
        $attribute = $attributes->where('name', 'ntp')->first();
        $value = $attribute->getValue() ?? old($attribute->name);
    @endphp
    <label for="{{ $attribute->name }}" class="col-lg-2 attribute-label col-form-label col-form-label-sm mandatory-label">Naučno-tehnološki park u kojem aplicirate za Raising Starts program:</label>
    <div class="col-lg-10">
        <select id="{{$attribute->name}}"
                name="{{$attribute->name}}"
                class="form-control form-control-sm mandatory-field"
                @error($attribute->name) is-error @enderror
                @if(isset($model)  && $value != null) disabled @endif>
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

@include('profiles.partials._rstarts_general_data', ['mode' => $mode])

@if ($mode == 'anonimous')
    <div class="mt-4 d-flex align-items-center" id="submitArea">
        <input
            type="checkbox"
            id="gdpr"
            name="gdpr"
            class="@error('gdpr') is-invalid @enderror"
            @if(old('gdpr') == 'on') checked @endif>
        <label class="ml-1 mt-1 attribute-label">
            Popunjavanjem i podnošenjem ove prijave potvrdjujem da sam saglasan sa svim navedenim uslovima poziva.
        </label>
    </div>
    @error('gdpr') <div class="alert alert-danger">{{ $message }}</div> @enderror

    <div class="d-flex align-items-center justify-content-center mt-4">
        <span class="mr-1 font-weight-bold">Polja ispod su samo informativnog karaktera i nemoguće ih je popuniti u ovom koraku. Aho želite odmah na slanje podataka</span>
        <a href="#submitArea" class="font-weight-bold">kliknite ovde.</a>
    </div>

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

@endif

@include('profiles.partials._rstarts_team', ['mode' => $mode])
@include('profiles.partials._rstarts_business_model', ['mode' => $mode])
@include('profiles.partials._rstarts_startup_story', ['mode' => $mode])
@include('profiles.partials._rstarts_additional_doc', ['mode' => $mode])
@if(auth()->user() == null)
    @include('profiles.partials._rstarts_izjave', ['mode' => $mode] )
@endif

@if ($mode != 'anonimous')
    <div class="mt-4 d-flex align-items-center" id="submitArea">
        <input
            type="checkbox"
            id="gdpr"
            name="gdpr"
            style="position: relative; top:4px"
            class="@error('gdpr') is-invalid @enderror"
            @if(old('gdpr') == 'on') checked @endif>
        <label class="ml-1 mt-2 attribute-label">

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
@endif

