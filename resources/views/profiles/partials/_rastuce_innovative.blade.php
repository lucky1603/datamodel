<h3 class="text-center attribute-label m-4">{{ mb_strtoupper(__('Razvoj inovativnog proizvoda ili tehnologije')) }}</h3>

<h4 class="text-center attribute-label m-4">
    U kojoj ste fazi razvoja inovativnog proizvoda ili tehnologije?
</h4>
<div class="font-12 font-italic mb-2">
    * Ukoliko razvijate više inovacija, označite fazu razvoja za do 3 najvažnije, naznačavajući njihove nazive
    (za višestruku selekciju, držite pritisnut "ctrl" taster na tastaturi dok birate mišem)
</div>

@for ($i = 1; $i <= 3; $i ++)
<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'innovative_product_'.$i)->first();
        $value = $attribute->getValue() ?? isset($model) ? $model->getValue($attribute->name) : old($attribute->name);;
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text"
               class="mandatory-field form-control form-control-sm @error($attribute->name) is-invalid @enderror"
               id="{{ $attribute->name }}"
               name="{{ $attribute->name }}"
               value="{{ $value }}">
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @endif
    </div>
</div>


<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'innovative_phase_'.$i)->first();
        $value = $attribute->getValue() ?? isset($model) ? $model->getValue($attribute->name) : old($attribute->name);;
    @endphp
    <label for="{{ $attribute->name }}"
           class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">{!! $attribute->label !!}</label>
    <div class="col-sm-10">
        <select id="{{$attribute->name}}"
            name="{{$attribute->name}}"
            class="form-control form-control-sm @error($attribute->name) is-invalid @enderror mandatory-field">
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
            'title' => 'product_developed',
            'subtitle' => 'Ukratko objasnite koje ste aktivnosti sa stanovišta razvoja prooizvoda ili tehnologije sprovodili do sada.'
        ],
        [
            'title' => 'innovation_grade',
            'subtitle' => '* Ukratko objasnite kako vidite nivo inovativnosti tehnologija koje implementirate u razvoju ili razvojate. Koje su vaše ključne prednosti i razlike u odnosu na postojeća tehnološka rešenja?'
        ],
        [
            'title' => 'intellectual_property_protected',
            'subtitle' => '* Navedite da li je u pitanju podneta patentna prijava,  patent, žig, industrijski dizajn, itd.'
        ]
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




