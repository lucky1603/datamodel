<h3 class="text-center attribute-label m-4">{{ \App\AttributeGroup::where('name', 'rstarts_applicant')->first()->label }}</h3>

@foreach(
    ['rstarts_startup_name' => 'name', 'rstarts_applicant_name' => 'contact_person', 'rstarts_address' => 'address'] as $key=>$val)
<div class="form-group row">
    @php
        $attribute = $attributes->where('name', $key)->first();
        $value = $attribute->getValue() ?? isset($model) ? $model->getValue($val) : old($attribute->name);
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text"
               class="mandatory-field form-control form-control-sm @error($attribute->name) is-invalid @enderror"
               id="{{ $attribute->name }}"
               name="{{ $attribute->name }}"
               value="{{ $value }}" @if(isset($model) && isset($instance_id) && $value != null ) disabled @endif>
        @if ($key == 'rstarts_address')
            <div class="text-dark font-12 mt-1">
                Ukoliko se trenutna adresa startapa razlikuje u odnosu na onu koja je registrovana kod APR-a,
                moilimo navedite i trenutnu adresu.
            </div>
        @endif
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @endif
    </div>
</div>
@endforeach

@php
    $attribute = $attributes->where('name', 'jmbg')->first();
    $value = $attribute->getValue() ?? old($attribute->name);
@endphp

<div class="form-group row">
    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">JMBG podnosioca prijave</label>
    <div class="col-sm-10">
        <input type="text"
               class="form-control form-control-sm @error($attribute->name) is-invalid @enderror mandatory-field"
               id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}" @if(isset($model) && isset($instance_id) && $value != null) disabled @endif>
        @error($attribute->name)
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

@php
    $attribute = $attributes->where('name', 'rstarts_position')->first();
    $value = $attribute->getValue() ?? old($attribute->name) ;
@endphp
<div class="form-group row">
    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text"
               class="form-control form-control-sm @error($attribute->name) is-invalid @enderror mandatory-field"
               id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}" @if(isset($model) && isset($instance_id) && $value != null) disabled @endif>
        @error($attribute->name)
        <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>



@php
    $attribute = $attributes->where('name', 'rstarts_email')->first();
    $value = $attribute->getValue() ?? isset($model) ?  $model->getValue('contact_email') : old($attribute->name) ;
@endphp
<div class="form-group row">
    <label for="{{ $attribute->name }}" class="col-lg-2 attribute-label col-form-label col-form-label-sm mandatory-label" >E-mail adresa</label>
    <div class="col-lg-10">
        <input type="email"
               class="form-control form-control-sm @error($attribute->name) is-invalid @enderror mandatory-field"
               id="{{ $attribute->name }}"
               name="{{$attribute->name}}"
               value="{{ $value }}"
               autocomplete="{{ $attribute->name }}" @if(isset($model) && isset($instance_id) && $value != null) disabled @endif >
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'rstarts_telephone')->first();
        $value = $attribute->getValue() ?? isset($model) ? $model->getValue('contact_phone') : old($attribute->name);
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">Telefon</label>
    <div class="col-sm-10">
        <input type="text"
               class="form-control form-control-sm @error($attribute->name) is-invalid @enderror mandatory-field"
               id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}" @if(isset($model) && isset($instance_id) && $value != null) disabled @endif data-toggle="input-mask" data-mask-format="000 000-0000">
        <span class="font-12 text-dark">Unesite broj telefona u formatu 0## ### - ###(#)</span>

        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'rstarts_logo')->first();
        $value = $attribute->getValue();
        if(isset($model)) {
            if($value == null || (is_array($value) && $value['filelink'] == '')) {
                $value = $model->getValue('profile_logo');
            }
        }
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">
        Dodajte svoj logo ako ga imate <i class="dripicons-information font-18" title="Datoteke moraju biti u
        formatu (.png, .jpg, .jpeg, .gif, .bmp) i njihova veličina ne sme premašivati 1MB"></i>
    </label>
    <div class="col-sm-10">
        <table class="table table-responsive">
            @if($value != null)
            <tr>
                <td><a href="{{ $value['filelink'] }}" target="_blank">{{ $value['filename'] }}</a></td>
            </tr>
            @endif
            <tr>
                <input type="file"
                       class="form-control @error('rstarts_logo') is-invalid @enderror"
                       id="{{ $attribute->name }}" name="{{ $attribute->name }}" style="width: 90%">
            </tr>
        </table>
        @error('rstarts_logo') <div class="alert alert-danger">{{ $message }}</div>@enderror
    </div>

</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'rstarts_webpage')->first();
        $value = $attribute->getValue() ?? old($attribute->name);
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text"
               class="form-control form-control-sm @error($attribute->name) is-invalid @enderror"
               id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}" >
        <div class="font-12 text-dark">Naziv web stranice mora obavezno imati prefix http:// ili https:// </div>
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

</div>

<div class="form-group row" id="rstarts_founding_date_group">
    @php
        $attribute = $attributes->where('name', 'rstarts_founding_date')->first();
        $value = $attribute->getValue() ?? old($attribute->name) ;
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="date"
               class="form-control form-control-sm @error($attribute->name) is-invalid @enderror mandatory-field"
               id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}" @if(isset($model) && isset($instance_id) && $value != null) disabled @endif>
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row" id="rstart_id_number_group">
    @php
        $attribute = $attributes->where('name', 'rstarts_id_number')->first();
        $value = $attribute->getValue() ?? old($attribute->name);
        if($value == null && isset($model)) {
            $value = $model->getValue('id_number');
        }
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text"
               class="form-control form-control-sm  @error($attribute->name) is-invalid @enderror mandatory-field"
               id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}" @if(isset($model) && isset($instance_id) && $value != null) disabled @endif>

        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row" id="rstarts_basic_registered_activity_group">
    @php
        $attribute = $attributes->where('name', 'rstarts_basic_registered_activity')->first();
        $value = $attribute->getValue() ?? old($attribute->name);
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text"
               class="form-control form-control-sm @error($attribute->name) is-invalid @enderror mandatory-field"
               id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}" @if(isset($model) && isset($instance_id) && $value != null) disabled @endif>
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_short_ino_desc')->first();
        $value = $attribute->getValue() ?? old($attribute->name);
    @endphp
    <label class="attribute-label mandatory-label" for="{{ $attribute->name }}">{!! $attribute->label !!} </label>
    <textarea class="form-control @error($attribute->name) is-invalid @enderror mandatory-field"
              id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3" @if(isset($model) && isset($instance_id) && $value != null) disabled @endif>{{ $value }}</textarea>
    @error($attribute->name)
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'rstarts_product_type')->first();
        $value = $attribute->getValue() ?? old($attribute->name);
    @endphp
    <label for="{{ $attribute->name }}"
           class="col-lg-2 attribute-label col-form-label col-form-label-sm mandatory-label">{!! $attribute->label !!}</label>
    <div class="col-lg-10">
        <select id="{{$attribute->name}}"
                name="{{$attribute->name}}"
                class="form-control form-control-sm @error($attribute->name) is-invalid @enderror mandatory-field" @if(isset($model) && $value != null) disabled @endif>
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



