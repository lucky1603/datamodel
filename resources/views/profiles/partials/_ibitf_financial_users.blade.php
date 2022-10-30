<h3 class="text-center attribute-label m-4">{{ \App\AttributeGroup::where('name', 'ibitf_financial_users')->first()->label }}</h3>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'institution_name')->first();
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 @if($mode == 'anonimous') attribute-grayed @else attribute-label @endif col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'purpose')->first();
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 @if($mode == 'anonimous') attribute-grayed @else attribute-label @endif col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'amount_din')->first();
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 @if($mode == 'anonimous') attribute-grayed @else attribute-label @endif col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
    </div>
</div>

