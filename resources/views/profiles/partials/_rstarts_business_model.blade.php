<h3 class="text-center attribute-label m-4">Poslovna ideja</h3>


<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_tagline')->first();
    @endphp
    <label class="attribute-label" for="{{ $attribute->name }}">{!! $attribute->label !!} </label>
    <textarea class="form-control @error($attribute->name) is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() ?? old($attribute->name) }}</textarea>
    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_solve_problem')->first();
    @endphp
    <label class="attribute-label" for="{{ $attribute->name }}">Koji problem pokušavate da rešite na tržištu?
        <span class="font-11 font-italic text-dark">Ukratko objasnite problem koji rešavate potencijalnim kupcima.
            Da li ovaj problem postoji globalno? Da li mislite da je ovaj problem težak i opišite zašto.
            Kako ste saznali za taj problem?</span>
    </label>
    <textarea class="form-control @error($attribute->name) is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() ?? old($attribute->name) }}</textarea>
    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_targetted_market')->first();
    @endphp
    <label class="attribute-label" for="{{ $attribute->name }}">Koje je ciljano tržište koje targetirate i koja je procenjena veličina tog tržišta?
        <span class="font-11 font-italic text-dark">Navedite koje tržište targetirate svojim proizvodom  i/ili uslugom i koja je procenjena veličina
            tog tržišta uz navodjenje izvora koji su korišćeni za prikupljanje tih podataka (primer izvora koji možete koristiti: https://www.statista.com/).
            Koliki prostor vidite za širenje svog biznisa odnosno za geografsku ekspanziju (navesti zemlje širenja u naredne 2 godine)? </span>
    </label>
    <textarea class="form-control @error($attribute->name) is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() ?? old($attribute->name) }}</textarea>
    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_problem_solve')->first();
    @endphp
    <label class="attribute-label" for="{{ $attribute->name }}">Kome rešavate problem?
        <span class="font-11 font-italic text-dark">Ko su vaši potencijalni kupci? Navedite koje su njihove glavne karakteristike (demografija,
            motivi, navike, komunikacija, strahovi itd.) Opišite da li ste već ostvarili komunikaciju/sproveli aktivnosti (ankete, intervjui i sl)
            sa njima. Ukoliko jeste, sa koliko njih i koji su vaši zaključci? </span>
    </label>
    <textarea class="form-control @error($attribute->name) is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() ?? old($attribute->name) }}</textarea>
    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_which_product')->first();
    @endphp
    <label class="attribute-label" for="{{ $attribute->name }}">Koji inovativni proizvod i/ili uslugu razvijate ili planirate da razvijate (najviše 100 reči)?
        <span class="font-11 font-italic text-dark">Opišite glavne karakteristike inovativnog proizvoda i/ili usluge koju razvijate:
                Naveditekoju tehnologiju koristite (npr. Blockchain, AI, IoT, ML):
                Navedite šta vaš proizvod i/ili uslugu čini jedinstvenim u poređenju sa postojećim koji zadovoljavaju iste potrebe kupaca:
 </span>
    </label>
    <textarea class="form-control @error($attribute->name) is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() ?? old($attribute->name) }}</textarea>
    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_customer_problem_solve')->first();
    @endphp
    <label class="attribute-label" for="{{ $attribute->name }}">Kako potencijalni kupci trenutno rešavaju problem?
        <span class="font-11 font-italic text-dark">Ukratko objasnite kako potencijalni kupci trenutno rešavaju
            navedeni problem (navesti druge proizvode  i/ili usluge koji su direktna konkurencija, a koje potencijalni
            kupci trenutno koriste ili druge metode koje primenjuju za rešavanje datog problema)
        </span>
    </label>
    <textarea class="form-control @error($attribute->name) is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() ?? old($attribute->name) }}</textarea>
    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_benefits')->first();
    @endphp
    <label class="attribute-label" for="{{ $attribute->name }}">Koje benefite/vrednosti svojim proizvodom  i/ili uslugom donosite kupcima?
        <span class="font-11 font-italic text-dark">Opišite koji su to glavni benefiti koje vaši kupci dobijaju koristeći vaše proizvode/usluge.
            Šta vaš proizvod  i/ili uslugu čini jedinstvenim u poređenju sa postojećim koji zadovoljavaju iste/slične potrebe kupaca.
        </span>
    </label>
    <textarea class="form-control  @error($attribute->name) is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() ?? old($attribute->name)}}</textarea>
    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'rstarts_how_innovative')->first();
        $selectedValue = $attribute->getValue() ?? old($attribute->name);
    @endphp
    <label for="{{ $attribute->name }}" class="col-lg-5 attribute-label col-form-label col-form-label-sm">Koliko je inovativan vaš proizvod/usluga (odaberite jednu opciju)?</label>
    <div class="col-lg-7">
        <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control form-control-sm @error($attribute->name) is-invalid @enderror">
            <option value="0" @if( $selectedValue == 0) selected @endif>Izaberite...</option>
            @foreach($attribute->getOptions() as $key => $value)
                <option value="{{$key}}" @if($key == $selectedValue) selected @endif>{{$value}}</option>
            @endforeach
        </select>
        @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
    </div>
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_clarification_innovative')->first();
    @endphp
    <label class="attribute-label" for="{{ $attribute->name }}">Obrazložite odabranu opciju (npr. Zašto mislite da je
        vaš proizvod potpuno nov na tržištu, značajno poboljšan i drugo):
    </label>
    <textarea class="form-control @error($attribute->name) is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() ?? old($attribute->name) }}</textarea>
    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>

<h5 class="text-center attribute-label mt-4">Vaša inovacija se nalazi u fazi (odaberite jednu opciju za tehnološki i jednu opciju za poslovni razvoj).</h5>

<div class="row mb-4">
    <div class="col-lg-6 form-group">
        @php
            $attribute = $attributes->where('name', 'rstarts_dev_phase_tech')->first();
            $selectedValue = $attribute->getValue() ?? old($attribute->name);
        @endphp
        <label for="{{ $attribute->name }}" class="attribute-label col-form-label col-form-label-sm font-12 font-weight-normal">{!! $attribute->label !!}</label>
        <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control form-control-sm @error($attribute->name) is-invalid @enderror">
            <option value="0" @if( $selectedValue == 0) selected @endif>Izaberite...</option>
            @foreach($attribute->getOptions() as $key => $value)
                <option value="{{$key}}" @if($key == $selectedValue) selected @endif>{{$value}}</option>
            @endforeach
        </select>
        @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
    </div>
    <div class="col-lg-6 form-group">
        @php
            $attribute = $attributes->where('name', 'rstarts_dev_phase_bussines')->first();
            $selectedValue = $attribute->getValue() ?? old($attribute->name);
        @endphp
        <label for="{{ $attribute->name }}" class="attribute-label col-form-label col-form-label-sm font-12 font-weight-normal">{!! $attribute->label !!}</label>
        <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control form-control-sm @error($attribute->name) is-invalid @enderror">
            <option value="0" @if( $selectedValue == 0) selected @endif>Izaberite...</option>
            @foreach($attribute->getOptions() as $key => $value)
                <option value="{{$key}}" @if($key == $selectedValue ) selected @endif>{{$value}}</option>
            @endforeach
        </select>
        @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'rstarts_intellectual_property')->first();
        $selectedValue = $attribute->getValue() ?? old($attribute->name);
    @endphp
    <label for="{{ $attribute->name }}" class="col-lg-5 attribute-label col-form-label col-form-label-sm">Da li ste sprovodili neke aktivnosti u cilju zaštite prava intelektualne svojine??</label>
    <div class="col-lg-7">
        <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control form-control-sm @error($attribute->name) is-invalid @enderror">
            <option value="0" @if( $selectedValue == 0) selected @endif>Izaberite...</option>
            @foreach($attribute->getOptions() as $key => $value)
                <option value="{{$key}}" @if($key == $selectedValue) selected @endif>{{$value}}</option>
            @endforeach
        </select>
        @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
    </div>
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_research')->first();
    @endphp
    <label class="attribute-label" for="{{ $attribute->name }}">Molimo vas opišite, sa najviše 50 reči, da li ste sproveli neko
        istraživanje na temu intelektualne svojine, mogućnosti zaštite intelektualne svojine ili ukoliko ste zaštitili logotip,
        patent, mali patent ili slično. Ukoliko ste zaštitili ili planirate da zaštitite neko pravo intelektualne svojine,
        navedite ko su vlasnici ili ko bi bili vlasnici te intelektualne svojine
    </label>
    <textarea class="form-control @error($attribute->name) is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() ?? old($attribute->name)}}</textarea>
    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'rstarts_innovative_area')->first();
        $selectedValue = $attribute->getValue() ?? old($attribute->name);
    @endphp
    <label for="{{ $attribute->name }}" class="col-lg-5 attribute-label col-form-label col-form-label-sm">Kojoj oblasti pripada inovativni proizvod i/ili usluga koje razvijate?</label>
    <div class="col-lg-7">
        <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control form-control-sm @error($attribute->name) is-invalid @enderror">
            <option value="0" @if( $selectedValue == 0) selected @endif>Izaberite...</option>
            @foreach($attribute->getOptions() as $key => $value)
                <option value="{{$key}}" @if($key == $selectedValue) selected @endif>{{$value}}</option>
            @endforeach
        </select>
        @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
    </div>
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_business_plan')->first();
    @endphp
    <label class="attribute-label" for="{{ $attribute->name }}">Kako vaš startap planira da zaradjuje?</label>
    <textarea class="form-control @error($attribute->name) is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() ?? old($attribute->name) }}</textarea>
    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>
