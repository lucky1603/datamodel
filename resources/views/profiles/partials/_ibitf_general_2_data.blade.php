@php
    $attribute = $attributes->where('name', 'program_project_name')->first();
@endphp
<div class="form-group mt-4">
    <label for="{{ $attribute->name }}" class="@if($mode == 'anonimous') attribute-grayed @else attribute-label mandatory-label @endif">{!! $attribute->label !!}</label>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3" @if ($mode == 'anonimous') disabled @endif>{{ $attribute->getValue() }}</textarea>
</div>

@php
    $attribute = $attributes->where('name', 'program_project_description')->first();
@endphp
<div class="form-group mt-2">
    <label for="{{ $attribute->name }}" class="@if($mode == 'anonimous') attribute-grayed @else attribute-label mandatory-label @endif">{!! $attribute->label !!}</label><br/>
    <span class="mt-0" style="font-size: 12px; position: relative; top: -10px">Jasna poruka kojom objašnjavate šta radite. Zašto ste jedinstveni? Šta nudite korisniku/kupcu?</span>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3" @if ($mode == 'anonimous') disabled @endif>{{ $attribute->getValue() }}</textarea>
</div>

@php
    $attribute = $attributes->where('name', 'problem_solving')->first();
@endphp
<div class="form-group mt-2">
    <label for="{{ $attribute->name }}" class="@if($mode == 'anonimous') attribute-grayed @else attribute-label mandatory-label @endif">{!! $attribute->label !!}</label><br/>
    <span class="mt-0" style="font-size: 12px; position: relative; top: -10px">Opišite koji problem/e svojim proizvodom/uslugom rešavate.
        Pokušajte da navedete najvažnija 3 problema koja rešavate za potencijalne kupce/korisnike. Na koji način potencijalni kupci/korisnici
        sada rešavaju te probleme? Navedite bar jednog konkretnog konkurenta i koja je vaša prednost u odnosu na njega. Koji proizvodi
        postoje kao alternativa onome što Vi nudite.</span>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3" @if ($mode == 'anonimous') disabled @endif>{{ $attribute->getValue() }}</textarea>
</div>

@php
    $attribute = $attributes->where('name', 'solutions')->first();
@endphp
<div class="form-group mt-2">
    <label for="{{ $attribute->name }}" class="@if($mode == 'anonimous') attribute-grayed @else attribute-label mandatory-label @endif">{!! $attribute->label !!}</label><br/>
    <span class="mt-0" style="font-size: 12px; position: relative; top: -10px">Navedite 3 najvažnija rešenja koja nudite potencijalnom
        korisniku/kupcu. Definišite elemente vaše usluge/proizvoda i šta je to što ga čini važnim alatom za korisnikove potrebe.</span>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3" @if ($mode == 'anonimous') disabled @endif>{{ $attribute->getValue() }}</textarea>
</div>

@php
    $attribute = $attributes->where('name', 'development_phase')->first();
@endphp
<div class="form-group mt-2">
    <label for="{{ $attribute->name }}" class="@if($mode == 'anonimous') attribute-grayed @else attribute-label mandatory-label @endif">{!! $attribute->label !!}</label><br/>
    <span class="mt-0" style="font-size: 12px; position: relative; top: -10px">Da li je proizvod/usluga razvijen?
        Da li ste testirali proizvod/uslugu? Ukoliko proizvod/usluga nije razvijen, šta je potrebno da bi se
        stekli uslovi za razvoj prototipa.</span>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3" @if ($mode == 'anonimous') disabled @endif>{{ $attribute->getValue() }}</textarea>
</div>

@php
    $attribute = $attributes->where('name', 'team')->first();
@endphp
<div class="form-group mt-2">
    <label for="{{ $attribute->name }}" class="@if($mode == 'anonimous') attribute-grayed @else attribute-label mandatory-label @endif">{!! $attribute->label !!}</label><br/>
    <span class="mt-0" style="font-size: 12px; position: relative; top: -10px">Ko čini vaš tim? Koja je kvalifikaciona struktura tima,
        uloga u timu. Planirano novo zapošljavanje u naredne 3 godine - u brojevima. </span>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3" @if ($mode == 'anonimous') disabled @endif>{{ $attribute->getValue() }}</textarea>
</div>

@php
    $attribute = $attributes->where('name', 'target_groups')->first();
@endphp
<div class="form-group mt-2">
    <label for="{{ $attribute->name }}" class="@if($mode == 'anonimous') attribute-grayed @else attribute-label mandatory-label @endif">{!! $attribute->label !!}</label><br/>
    <span class="mt-0" style="font-size: 12px; position: relative; top: -10px">Ko su vaši potencijalni kupci? Identifikujte 3-4 potencijalna
        korisnika i opišite ih. Na koji način ćete doći do potencijalnih kupaca (kanali prodaje) - onlajn marketing, B2B, sajmovi, itd.</span>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3" @if ($mode == 'anonimous') disabled @endif>{{ $attribute->getValue() }}</textarea>
</div>

@php
    $attribute = $attributes->where('name', 'market')->first();
@endphp
<div class="form-group mt-2">
    <label for="{{ $attribute->name }}" class="@if($mode == 'anonimous') attribute-grayed @else attribute-label mandatory-label @endif">{!! $attribute->label !!}</label><br/>
    <span class="mt-0" style="font-size: 12px; position: relative; top: -10px">Da li ste identifikovali
        ciljno tržište? Gde bi plasirali proizvod/uslugu? Da li ste izvozno orijentisani?</span>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3" @if ($mode == 'anonimous') disabled @endif>{{ $attribute->getValue() }}</textarea>
</div>
