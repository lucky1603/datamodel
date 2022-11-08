<h3 class="text-center @if($mode == 'anonimous') attribute-grayed @else attribute-label @endif mt-4 mb-4">{{ $attributeGroups->where('name', 'ibitf_attachments')->first()->label }}</h3>

@php
    $attribute = $attributes->where('name', 'resenje_apr_link')->first();
    $value = $attribute->getValue() ?? old($attribute->name);
@endphp

<div class="form-group">
    <label class="@if($mode == 'anonimous') attribute-grayed @else attribute-label @endif" for="{{ $attribute->name }}">{!! $attribute->label !!}</label>
    <input
        type="text"
        class="form-control"
        id="{{ $attribute->name }}"
        name="{{$attribute->name}}"
        value="{{ $value }}" @if ($mode == 'anonimous') disabled @endif>
</div>

@php
    $attribute = $attributes->where('name', 'resenje_fajl')->first();
    $value = $attribute->getValue() ?? old($attribute->name);
@endphp

<div class="form-group">
    <label class="@if($mode == 'anonimous') attribute-grayed @else attribute-label @endif" for="{{ $attribute->name }}">{!! $attribute->label !!}</label>
    @if($value != null)
        <table class="table table-responsive">
            <tr>
                <td><a href="{{ $value['filelink'] }}" @if ($mode == 'anonimous') disabled @endif>{{ $value['filename'] }}</a></td>
            </tr>
            <tr>
                <input type="file" class="form-control" id="{{ $attribute->name }}" name="{{ $attribute->name }}" @if ($mode == 'anonimous') disabled @endif>
            </tr>
        </table>
    @else
        <input type="file" class="form-control" id="{{ $attribute->name }}" name="{{ $attribute->name }}" @if ($mode == 'anonimous') disabled @endif>
    @endif
</div>

@php
    $attribute = $attributes->where('name', 'linkedin_founders')->first();
    $value = $attribute->getValue() ?? old($attribute->name);
@endphp

<div class="form-group">
    <label class="@if($mode == 'anonimous') attribute-grayed @else attribute-label @endif" for="{{ $attribute->name }}">{!! $attribute->label !!} </label>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3" @if ($mode == 'anonimous') disabled @endif>{{ $value }}</textarea>
</div>

@php
    $attribute = $attributes->where('name', 'founders_cv')->first();
    $value = $attribute->getValue() ?? old($attribute->name);
@endphp

<div class="form-group">
    <label class="@if($mode == 'anonimous') attribute-grayed @else attribute-label @endif" for="{{ $attribute->name }}">{!! $attribute->label !!}</label>
    @if($value != null)
        <table class="table table-responsive">
            <tr>
                <td><a href="{{ $attribute->getValue()['filelink'] }}">{{ $value['filename'] }}</a></td>
            </tr>
            <tr>
                <input type="file" class="form-control" id="{{ $attribute->name }}" name="{{ $attribute->name }}" @if ($mode == 'anonimous') disabled @endif>
            </tr>
        </table>
    @else
        <input type="file" class="form-control" id="{{ $attribute->name }}" name="{{ $attribute->name }}" @if ($mode == 'anonimous') disabled @endif>
    @endif
</div>
