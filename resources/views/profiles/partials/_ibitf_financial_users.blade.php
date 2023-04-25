<h3 class="text-center @if($mode == 'anonimous') attribute-grayed @else attribute-label @endif m-4">{{ \App\AttributeGroup::where('name', 'ibitf_financial_users')->first()->label }}</h3>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'institution_name')->first();
        $value = $attribute->getValue() ?? old($attribute->name);
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 @if($mode == 'anonimous') attribute-grayed @else attribute-label @endif col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}" @if ($mode == 'anonimous') disabled @endif>
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'purpose')->first();
        $value = $attribute->getValue() ?? old($attribute->name);
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 @if($mode == 'anonimous') attribute-grayed @else attribute-label @endif col-form-label col-form-label-sm">{{ __('gui.incubation_form_project') }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}" @if ($mode == 'anonimous') disabled @endif>
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'amount_din')->first();
        $value = $attribute->getValue() ?? old($attribute->name);
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 @if($mode == 'anonimous') attribute-grayed @else attribute-label @endif col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}" @if ($mode == 'anonimous') disabled @endif>
    </div>
</div>

