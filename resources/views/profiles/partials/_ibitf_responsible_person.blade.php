<h4 class="text-center m-4">{{ \App\AttributeGroup::where('name', 'ibitf_responsible_person')->first()->label }}</h4>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'responsible_lastname')->first();
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}">
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'responsible_firstname')->first();
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}">
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'responsible_telephone')->first();
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}">
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'responsible_celular')->first();
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}">
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'responsible_email')->first();
    @endphp
    <label for="{{ $attribute->name }}" class="col-sm-2 col-form-label col-form-label-sm">{!! $attribute->label !!}</label>
    <div class="col-sm-10">
        <input type="email"
               class="form-control form-control-sm @error($attribute->name) is-invalid @enderror"
               id="{{ $attribute->name }}"
               name="{{$attribute->name}}"
               value="{{ $attribute->getValue() }}"
               required
               autocomplete="{{ $attribute->name }}" >
    </div>

</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'responsible_function')->first();
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}">
    </div>
</div>
