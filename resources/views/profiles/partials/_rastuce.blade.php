@if(!isset($model))
<div class="attribute-label font-14 m-1 p-4" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
    <p>U cilju boljeg razumevanja Prijavnog formulara, obe kategorije se u daljem tekstu nazivaju “startap”.</p>
    <p>Obavezna polja za kreiranje profila su označena zvezdicom (<span class="text-danger">*</span>) i svetlo
        plavom pozadinom. <strong>Ova polja su obavezna za kreiranje profila</strong>. Nakon kreiranog profila možete popuniti
        preostali deo prijave i konačno je poslati kada je spremna.</p>
</div>
@endif

@include('profiles.partials._rastuce_header', ['mode' => $mode])
@include('profiles.partials._rastuce_general', ['mode' => $mode])

@if ($mode == "anonimous")
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

    <div class="d-flex align-items-center justify-content-center mt-4 mb-4">
        <span class="attribute-label font-14 ">U nastavku se možete informativno upoznati sa pitanjima koja vas čekaju prilikom popunjavanja prijave.
        Prijavu popunjavate na linku koji dobijate nakon što registrujete svoj profil.</span>
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

@include('profiles.partials._rastuce_tim', ['mode' => $mode])
@include('profiles.partials._rastuce_innovative', ['mode' => $mode])
@include('profiles.partials._rastuce_komercijalizacija', ['mode' => $mode])
@include('profiles.partials._rastuce_annual_growth', ['mode' => $mode])
@include('profiles.partials._rastuce_nio', ['mode' => $mode])
@include('profiles.partials._rastuce_resources', ['mode' => $mode])
@include('profiles.partials._rastuce_attachments', ['mode' => $mode])

@if ($mode == "administrator")
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
