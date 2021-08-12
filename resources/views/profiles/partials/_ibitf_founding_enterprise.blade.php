<h4 class="text-center m-4">{{ \App\AttributeGroup::where('name', 'ibitf_founding_enterprise')->first()->label }}</h4>

<div class="form-group row">
    <div class="col-sm-4">
        @php
            $attribute = $attributes->where('name', 'founding_complany_planned')->first();
        @endphp

        <input id="{{ $attribute->name }}Hidden" type="hidden" name="{{ $attribute->name }}" value="off">
        <span class="attribute-label mr-1">{!! $attribute->label !!}  </span>
        <input
            class="checkbox-aligned"
            type="checkbox"
            id="{{ $attribute->name }}"
            name="{{$attribute->name}}"
            @if($attribute->getValue()) checked @endif style="padding-top: 10px"
            onclick="
                if(document.getElementById('{{ $attribute->name }}').checked)
                {
                document.getElementById('{{ $attribute->name }}Hidden').disabled = true
                } else {
                document.getElementById('{{ $attribute->name }}Hidden').disabled = false;
                }
                ">
    </div>
    <div class="col-sm-4">
        @php
            $attribute = $attributes->where('name', 'founding_act_prepared')->first();
        @endphp

        <input id="{{ $attribute->name }}Hidden" type="hidden" name="{{ $attribute->name }}" value="off">
        <span class="attribute-label mr-1">{!! $attribute->label !!} </span>
        <input
            class="checkbox-aligned"
            type="checkbox"
            id="{{ $attribute->name }}"
            name="{{$attribute->name}}"
            @if($attribute->getValue()) checked @endif style="padding-top: 10px"
            onclick="
                if(document.getElementById('{{ $attribute->name }}').checked)
                {
                document.getElementById('{{ $attribute->name }}Hidden').disabled = true
                } else {
                document.getElementById('{{ $attribute->name }}Hidden').disabled = false;
                }
                ">
    </div>
    <div class="col-sm-4">
        @php
            $attribute = $attributes->where('name', 'founding_act_in_preparation')->first();
        @endphp

        <input id="{{ $attribute->name }}Hidden" type="hidden" name="{{ $attribute->name }}" value="off">
        <span class="attribute-label mr-1">{!! $attribute->label !!}  </span>
        <input
            class="checkbox-aligned"
            type="checkbox"
            id="{{ $attribute->name }}"
            name="{{$attribute->name}}"
            @if($attribute->getValue()) checked @endif style="padding-top: 10px"
            onclick="
                if(document.getElementById('{{ $attribute->name }}').checked)
                {
                document.getElementById('{{ $attribute->name }}Hidden').disabled = true
                } else {
                document.getElementById('{{ $attribute->name }}Hidden').disabled = false;
                }
                ">
    </div>

</div>
