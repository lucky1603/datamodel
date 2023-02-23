<h3 class="text-center attribute-label m-4">{{ mb_strtoupper(__('Razvoj tržišta i komercijalizacija')) }}</h3>

<h4 class="text-center attribute-label m-4">
    U kojoj ste fazi komercijalizacije inovativnog proizvoda ili tehnologije?
</h4>
<div class="font-12 font-italic mb-2">
    * Ukoliko razvijate više inovacija, označite fazu komercijalizacije za do 3 najvažnije, naznačavajući njihove nazive
    (za višestruku selekciju, držite pritisnut "ctrl" taster na tastaturi dok birate mišem)
</div>

@for ($i = 1; $i <= 3; $i ++)
    <div class="form-group row">
        @php
            $attribute = $attributes->where('name', 'product_commercialization_'.$i)->first();
            $value = $attribute->getValue() ?? ( isset($model) ? $model->getValue($attribute->name) : old($attribute->name) );
        @endphp

        <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">{{ $attribute->label }}</label>
        <div class="col-sm-10">
            <input type="text"
                class="mandatory-field form-control form-control-sm @error($attribute->name) is-invalid @enderror"
                id="{{ $attribute->name }}"
                name="{{ $attribute->name }}"
                value="{{ $value }}" @if($mode == 'anonimous') disabled  @endif>
            @error($attribute->name)
                <div class="alert alert-danger">{{ $message }}</div>
            @endif
        </div>
    </div>


    <div class="form-group row">
        @php
            $attribute = $attributes->where('name', 'commercialization_phase_'.$i)->first();
            $value = $attribute->getValue() ?? ( isset($model) ? $model->getValue($attribute->name) : old($attribute->name) );
        @endphp
        <label for="{{ $attribute->name }}"
            class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">{!! $attribute->label !!}</label>
        <div class="col-sm-10">
            <select id="{{$attribute->name}}"
                name="{{$attribute->name}}"
                class="form-control form-control-sm @error($attribute->name) is-invalid @enderror mandatory-field"
                @if($mode == 'anonimous') disabled @endif>
                <option value="0">{{ __('Izaberite ...') }}</option>
                @foreach($attribute->getOptions() as $key => $val)
                    <option value="{{$key}}" @if($key == $value) selected @endif>{{$val}}</option>
                @endforeach
            </select>
            @error($attribute->name)
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
    </div>
@endfor

@php
    $labels = [
        [
            'title' => 'problem_desc',
            'subtitle' => ''
        ],
        [
            'title' => 'solution_advantage',
            'subtitle' => '*Ukoliko razvijate više inovativnih rešenja opišite do 3 najrelevantnija.'
        ],
        [
            'title' => 'product_commercialized',
            'subtitle' => '*Opišite ko su vaši kupci, koliko do sada kupaca imate,  kao i na kojim tržištima.
                Ukoliko proizvod još uvek nije komercijalizovan navedite ko su potencijalni kupci vašeg proizvoda.'
        ],
        [
            'title' => 'market_description',
            'subtitle' => '*Opišite veličinu  tržišta, tržišnu  segmentaciju  i tome sl. i  opišite strategiju rasta i  izlaska na  ciljna tržišta.'
        ],

    ]
@endphp

@foreach($labels as $label)
<div class="form-group mt-2">
    @php
        $attribute = $attributes->where('name', $label['title'])->first();
    @endphp
    <label for="{{ $attribute->name }}" class="attribute-label">{!! $attribute->label !!}</label><br/>
    <span class='font-12 font-italic'>{{ $label['subtitle'] }}</span>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="4" @if ($mode == 'anonimous') disabled @endif>{{ $attribute->getValue() }}</textarea>
</div>
@endforeach

<h3 class="text-center bg-dark text-white p-2">Sva naredna polja popunjavaju samo kompanije koje apliciraju za puno članstvo</h3>
<h4 class="attribute-label">Izvori finansiranja kompanije:</h4>
@php
    $labels = [
        [
            'title' => 'investment_got',
            'subtitle' => '* Navedite iznos investicije kao i tip investicije (grant, akcelerator,
                            VC,  biznis anđeli, donacije, vaučeri, finansiranje matične kompanije novoosnovanoj
                            kćerki kompaniji i sl.), kao i naziv institucije/entiteta koji je obezbedio investiciju.'
        ],
        [
            'title' => 'financing_development',
            'subtitle' => '*Navedite na koji način je kompanija do sada i kako planira da dalje finansira svoj razvoj
                            i ulaganje u inovaciju (u naredne 3 godine)..'
        ],

    ]
@endphp

@foreach($labels as $label)
<div class="form-group mt-2">
    @php
        $attribute = $attributes->where('name', $label['title'])->first();
    @endphp
    <label for="{{ $attribute->name }}" class="attribute-label">{!! $attribute->label !!}</label><br/>
    <span class='font-12 font-italic'>{{ $label['subtitle'] }}</span>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="4" @if ($mode == 'anonimous') disabled @endif>{{ $attribute->getValue() }}</textarea>
</div>
@endforeach


