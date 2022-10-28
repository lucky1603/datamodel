<h3 class="text-center attribute-label m-4">{{ mb_strtoupper(__('Dokumenti - prilozi')) }}</h3>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rastuce_financial_reports')->first();
    @endphp
    <label class="attribute-label col-form-label col-form-label-sm @if(isset($model)) mandatory-label @endif">
        {{ $attribute->label }}
        <i class="dripicons-information font-18" title="Datoteke moraju biti u
            formatu (.pdf, .docx, .xlsx) i njihova veličina ne sme premašivati 1MB. Svi fajlovi moraju biti istovremeno dodati."></i>
    </label>
    <span class="font-12 font-italic"> za prethodne tri godine ili za godine u kojima je kompanija poslovala (ukoliko je registrovana pre manje od tri godine)</span>
    <input
        type="file"
        multiple name="{{ $attribute->name }}[]"
        title="Svi fajlovi moraju biti istovremeno dodati!"
        id="{{ $attribute->name }}"
        class="form-control @error('rstarts_founder_cvs') is-invalid @enderror @if(isset($model)) mandatory-field @endif"
        {{-- @if($mode == 'anonimous') disabled @endif --}}
        >
    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
    @if($attribute != null && $attribute->getValue() != null)
        @if(isset($attribute->getValue()['filelink']))
            <a href="{{$attribute->getValue()['filelink']}}" target="_blank">{{ $attribute->getValue()['filename'] }}</a>
        @else
            <div style="display: flex">
                @foreach($attribute->getValue() as $file)
                    <a class="mr-2" href="{{$file['filelink']}}" target="_blank">{{ $file['filename'] }}</a>
                @endforeach
            </div>
        @endif
    @endif
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rastuce_cvs')->first();
    @endphp
    <label class="attribute-label col-form-label col-form-label-sm @if(isset($model)) mandatory-label @endif">
        {{ $attribute->label }}
        <i class="dripicons-information font-18" title="Datoteke moraju biti u
            formatu (.pdf, .docx, .xlsx) i njihova veličina ne sme premašivati 1MB. Svi fajlovi moraju biti istovremeno dodati."></i>
    </label>
    <span class="font-12 font-italic"> članova tima koji će sticanjem statusa člana u NTP Beograd sprovoditi predloženi poslovni program</span>
    <input
        type="file"
        multiple name="{{ $attribute->name }}[]"
        title="Svi fajlovi moraju biti istovremeno dodati!"
        id="{{ $attribute->name }}"
        class="form-control @error('rstarts_founder_cvs') is-invalid @enderror @if(isset($model)) mandatory-field @endif"
        {{-- @if($mode == 'anonimous') disabled @endif --}}
        >
    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
    @if($attribute != null && $attribute->getValue() != null)
        @if(isset($attribute->getValue()['filelink']))
            <a href="{{$attribute->getValue()['filelink']}}" target="_blank">{{ $attribute->getValue()['filename'] }}</a>
        @else
            <div style="display: flex">
                @foreach($attribute->getValue() as $file)
                    <a class="mr-2" href="{{$file['filelink']}}" target="_blank">{{ $file['filename'] }}</a>
                @endforeach
            </div>
        @endif
    @endif
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rastuce_presentation')->first();
    @endphp
    <label class="attribute-label col-form-label col-form-label-sm @if(isset($model)) mandatory-label @endif">
        {{ $attribute->label }}
        <i class="dripicons-information font-18" title="Datoteke moraju biti u
            formatu (.pdf, .docx, .xlsx) i njihova veličina ne sme premašivati 1MB. Svi fajlovi moraju biti istovremeno dodati."></i>
    </label>
    <span class="font-12 font-italic"> svih segmenata poslovnog modela: problem koji proizvod rešava, opis rešenja tj. inovativnosti proizvoda
        – sa fotografijama ili linkovima, ciljne grupe tj. profil idealnog kupca, segmentacija tržišta, reference tj. postojeće rezultate u
        pogledu partnerstava, investicija, nagrada itd, pregled prihoda i rashoda u narednom periodu i predstavljanje tima</span>
    <input
        type="file"
        name="{{ $attribute->name }}"
        title="Svi fajlovi moraju biti istovremeno dodati!"
        id="{{ $attribute->name }}"
        class="form-control @error('rstarts_founder_cvs') is-invalid @enderror @if(isset($model)) mandatory-field @endif"
        {{-- @if($mode == 'anonimous') disabled @endif --}}
        >
    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
    @if($attribute != null && $attribute->getValue() != null)
        @if(isset($attribute->getValue()['filelink']))
            <a href="{{$attribute->getValue()['filelink']}}" target="_blank">{{ $attribute->getValue()['filename'] }}</a>
        @else
            <div style="display: flex">
                @foreach($attribute->getValue() as $file)
                    <a class="mr-2" href="{{$file['filelink']}}" target="_blank">{{ $file['filename'] }}</a>
                @endforeach
            </div>
        @endif
    @endif
</div>
