<h3 class="text-center attribute-label mt-4 mb-4">{{ $attributeGroups->where('name', 'ibitf_attachments')->first()->label }}</h3>

@php
    $attribute = $attributes->where('name', 'resenje_apr_link')->first();
@endphp

<div class="form-group">
    <label class="attribute-label" for="{{ $attribute->name }}">{!! $attribute->label !!}</label>
    <input
        type="text"
        class="form-control"
        id="{{ $attribute->name }}"
        name="{{$attribute->name}}"
        value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
</div>

@php
    $attribute = $attributes->where('name', 'resenje_fajl')->first();
@endphp

<div class="form-group">
    <label class="attribute-label" for="{{ $attribute->name }}">{!! $attribute->label !!}</label>
    @if($attribute->getValue() != null)
        <table class="table table-responsive">
            <tr>
                <td><a href="{{ $attribute->getValue()['filelink'] }}" @if ($mode == 'anonimous') disabled @endif>{{ $attribute->getValue()['filename'] }}</a></td>
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
@endphp

<div class="form-group">
    <label class="attribute-label" for="{{ $attribute->name }}">{!! $attribute->label !!} </label>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3" @if ($mode == 'anonimous') disabled @endif>{{ $attribute->getValue() }}</textarea>
</div>

@php
    $attribute = $attributes->where('name', 'founders_cv')->first();
@endphp

<div class="form-group">
    <label class="attribute-label" for="{{ $attribute->name }}">{!! $attribute->label !!}</label>
    @if($attribute->getValue() != null)
        <table class="table table-responsive">
            <tr>
                <td><a href="{{ $attribute->getValue()['filelink'] }}">{{ $attribute->getValue()['filename'] }}</a></td>
            </tr>
            <tr>
                <input type="file" class="form-control" id="{{ $attribute->name }}" name="{{ $attribute->name }}" @if ($mode == 'anonimous') disabled @endif>
            </tr>
        </table>
    @else
        <input type="file" class="form-control" id="{{ $attribute->name }}" name="{{ $attribute->name }}" @if ($mode == 'anonimous') disabled @endif>
    @endif
</div>
