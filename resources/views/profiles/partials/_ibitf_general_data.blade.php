<h3 class="text-center attribute-label m-4">{{ \App\AttributeGroup::where('name', 'ibitf_general')->first()->label }}</h3>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'program_name_or_company')->first();
        $value = $attribute->getValue() ?? $model->getAttribute('name')->getValue();
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}">
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'date_of_establishment')->first();
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-4">
        <input type="date" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}">
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'legal_status')->first();
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}">
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'business_branch')->first();
        $attvalue = $attribute->getValue() ?? $model->getAttribute('business_branch')->getValue();
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{!! $attribute->label !!}</label>
    <div class="col-sm-10">
        <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control form-control-sm">
            <option value="0" @if( $attvalue == 0) selected @endif>Choose...</option>
            @foreach($attribute->getOptions() as $key => $value)
                <option value="{{$key}}" @if($key == $attvalue) selected @endif>{{$value}}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'pib')->first();
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}">
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'id_number')->first();
        $value = $attribute->getValue() ?? $model->getAttribute('id_number')->getValue();
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}">
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'address')->first();
        $value = $attribute->getValue() ?? $model->getAttribute('address')->getValue();
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}">
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'number_of_participants')->first();
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}">
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'telephone_number')->first();
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}">
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'email')->first();
        $value = $attribute->getValue() ?? $model->getAttribute('contact_email')->getValue();
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}">
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'web')->first();
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}">
    </div>
</div>
