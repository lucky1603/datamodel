<h3 class="text-center attribute-label m-4">{{ \App\AttributeGroup::where('name', 'ibitf_responsible_person')->first()->label }}</h3>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'responsible_lastname')->first();
        $responsible_lastname = $attribute->getValue() ?? explode(' ', $model->getAttribute('contact_person')->getValue())[1];

    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $responsible_lastname }}">
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'responsible_firstname')->first();
        $responsible_name = $attribute->getValue() ?? explode(' ', $model->getAttribute('contact_person')->getValue())[0];
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $responsible_name }}">
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'responsible_telephone')->first();
        $phone = $attribute->getValue() ?? $model->getAttribute('contact_phone')->getValue();
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $phone }}">
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'responsible_cellular')->first();
        $phone = $attribute->getValue() ?? $model->getAttribute('contact_phone')->getValue();
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $phone }}">
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'responsible_email')->first();
        $email = $attribute->getValue() ?? $model->getAttribute('contact_email')->getValue();
    @endphp
    <label for="{{ $attribute->name }}" class="col-sm-2 col-form-label col-form-label-sm">{!! $attribute->label !!}</label>
    <div class="col-sm-10">
        <input type="email"
               class="form-control form-control-sm @error($attribute->name) is-invalid @enderror"
               id="{{ $attribute->name }}"
               name="{{$attribute->name}}"
               value="{{ $email }}"
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
