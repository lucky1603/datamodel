<h3 class="text-center @if($mode == 'anonimous') attribute-grayed @else attribute-label @endif m-4">{{ \App\AttributeGroup::where('name', 'ibitf_founding_enterprise')->first()->label }}</h3>

<div class="form-group row">
    <div class="col-sm-4">
        @php
            $attribute = $attributes->where('name', 'founding_company_planned')->first();
            $value = $attribute->getValue() ?? old($attribute->name);
        @endphp

        <input id="{{ $attribute->name }}Hidden" type="hidden" name="{{ $attribute->name }}" value="off" @if ($mode == 'anonimous') disabled @endif>
        <span class="@if($mode == 'anonimous') attribute-grayed @else attribute-label @endif mr-1">{!! $attribute->label !!}  </span>
        <input
            class="checkbox-aligned"
            type="checkbox"
            id="{{ $attribute->name }}"
            name="{{$attribute->name}}"
            @if($value) checked @endif style="padding-top: 10px"
            onclick="
                if(document.getElementById('{{ $attribute->name }}').checked)
                {
                document.getElementById('{{ $attribute->name }}Hidden').disabled = true
                } else {
                document.getElementById('{{ $attribute->name }}Hidden').disabled = false;
                }
                " @if ($mode == 'anonimous') disabled @endif>
    </div>
    <div class="col-sm-4">
        @php
            $attribute = $attributes->where('name', 'founding_act_prepared')->first();
            $value = $attribute->getValue() ?? old($attribute->name);
        @endphp

        <input id="{{ $attribute->name }}Hidden" type="hidden" name="{{ $attribute->name }}" value="off" @if ($mode == 'anonimous') disabled @endif>
        <span class="@if($mode == 'anonimous') attribute-grayed @else attribute-label @endif mr-1">{!! $attribute->label !!} </span>
        <input
            class="checkbox-aligned"
            type="checkbox"
            id="{{ $attribute->name }}"
            name="{{$attribute->name}}"
            @if($value) checked @endif style="padding-top: 10px"
            onclick="
                if(document.getElementById('{{ $attribute->name }}').checked)
                {
                document.getElementById('{{ $attribute->name }}Hidden').disabled = true
                } else {
                document.getElementById('{{ $attribute->name }}Hidden').disabled = false;
                }
                " @if ($mode == 'anonimous') disabled @endif>
    </div>
    <div class="col-sm-4">
        @php
            $attribute = $attributes->where('name', 'founding_act_in_preparation')->first();
            $value = $attribute->getValue() ?? old($attribute->name);
        @endphp

        <input id="{{ $attribute->name }}Hidden" type="hidden" name="{{ $attribute->name }}" value="off" @if ($mode == 'anonimous') disabled @endif>
        <span class="@if($mode == 'anonimous') attribute-grayed @else attribute-label @endif mr-1">{!! $attribute->label !!}  </span>
        <input
            class="checkbox-aligned"
            type="checkbox"
            id="{{ $attribute->name }}"
            name="{{$attribute->name}}"
            @if($value) checked @endif style="padding-top: 10px"
            onclick="
                if(document.getElementById('{{ $attribute->name }}').checked)
                {
                document.getElementById('{{ $attribute->name }}Hidden').disabled = true
                } else {
                document.getElementById('{{ $attribute->name }}Hidden').disabled = false;
                }
                " @if ($mode == 'anonimous') disabled @endif>
    </div>

</div>
