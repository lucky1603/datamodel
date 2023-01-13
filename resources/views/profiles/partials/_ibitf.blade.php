@if(!isset($model))
<div class="attribute-label font-14 m-1 p-4" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
    <p>U cilju boljeg razumevanja Prijavnog formulara, obe kategorije se u daljem tekstu nazivaju “startap”.</p>
    <p>
        Obavezna polja za kreiranje profila su označena zvezdicom (<span class="text-danger">*</span>) i svetlo plavom
        pozadinom.<strong>Ova polja su obavezna za kreiranje profila</strong>. Nakon kreiranog profila možete popuniti
        preostali deo prijave kroz softver nakon što vam stigne verifikacioni mail sa daljim upustvima i konačno je poslati
        kroz softver kada je spremna.
    </p>
</div>
@endif

@include('profiles.partials._ibitf_general_data', ['mode' => $mode])
@include('profiles.partials._ibitf_responsible_person', ['mode' => $mode])

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


    <div style="display: flex; flex-wrap: wrap; align-items: center; justify-content: center" class="mb-4">
        <button type="button" id="buttonSend" class="btn btn-sm btn-primary rounded-pill mx-1 mt-4" style="width: 250px" title="{{ __('gui.Application-SaveDataAndSendApp') }}">
            <span id="okSpinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            {{ __('Register Profile') }}
        </button>

        <button type="button" id="buttonCancel" class="btn btn-sm btn-outline-primary rounded-pill mx-1 mt-4" style="width: 250px" title="{{ __('gui.Application-ReturnToMain') }}">
            <span id="cancelSpinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            {{ __('Return to Main Page') }}
        </button>
    </div>
@endif


@include('profiles.partials._ibitf_contests', ['mode' => $mode])
@include('profiles.partials._ibitf_financial_users', ['mode' => $mode])
@include('profiles.partials._ibitf_founders1', ['mode' => $mode])
@include('profiles.partials._ibitf_founding_enterprise', ['mode' => $mode])

<div class="bg-light p-4">
    <h4 class="mb-3">NAPOMENE PRE POPUNJAVANJA OBRASCA</h4>
    <p>Pokušajte da što jasnije opišete svoj proizvod/uslugu popunjavanjem ovog obrasca.
        Formular je sastavljen na osnovu LEAN metodologije. Prvo pročitajte sva pitanja
        pa pokušajte iskreno da odgovorite na sva.</p>
    <p>Popunjavanje prijave će Vas navesti na šire sagledavanje planova i čemu bi eventualno
        trebalo više da se posvetite.</p>
    <p>Poslovno tehnološkom inkubatoru tehničkih fakulteta će ovaj obrazac biti polazna osnova
        za plan podrške razvoju vašeg biznisa. </p>
    <p>Imajte u vidu da će popunjen obrazac biti dostupan samo zaposlenima na poslovima podrške
        u Poslovno-tehnološkom inkubatoru tehničkih fakulteta i da ima tretman poslovne tajne.</p>

    <h5>UZ PRIJAVU POTREBNO JE PRILOŽITI:</h5>
    <ol>
        <li>Rešenje o izvršenoj registraciji privrednog društva ili izvod iz registra za privredno društvo ili link sa APR gde se može preuzeti rešenje</li>
        <li>Podaci o osnivačima i vlasnicima (lični podaci i kratke profesionalne biografije ili linkovi ka Linkedin profilima ukoliko postoje za svako lice)</li>
    </ol>
    <p>Za sva pitanja koja budete imali tokom popunjavanja prijave kontaktirajte nas na: 011/3370-950. </p>
</div>

@include('profiles.partials._ibitf_general_2_data')
@include('profiles.partials._ibitf_expenses', ['mode' => $mode])
@include('profiles.partials._ibitf_generate_income', ['mode' => $mode])
@include('profiles.partials._ibitf_infrastructure', ['mode' => $mode])
@include('profiles.partials._ibitf_attachments', ['mode' => $mode])

@if ($mode == 'administrator')
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
            {{ __('Register Profile') }}
        </button>

        <button type="button" id="buttonCancel" class="btn btn-sm btn-outline-primary rounded-pill mx-1 mt-4" style="width: 250px" title="{{ __('gui.Application-ReturnToMain') }}">
            <span id="cancelSpinner" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            {{ __('Return to Main Page') }}
        </button>
    </div>
@endif




