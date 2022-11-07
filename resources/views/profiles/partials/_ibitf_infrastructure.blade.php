<h3 class="text-center @if($mode == 'anonimous') attribute-grayed @else attribute-label @endif mt-4">{{ $attributeGroups->where('name', 'ibitf_infrastructure')->first()->label }}</h3>
<p class="text-right font-italic">(odgovarajuće polje označite sa X)</p>
<table class="w-100 table-bordered">
    <tr>
        <td rowspan="5" class="w-25 bg-dark text-light text-center">Usluge stanarima inkubatora</td>
        <td class="w-50">Kancelarijski poslovni prostor –navedite m ²</td>
        <td class="w-25">
            @php
                $attribute = $attributes->where('name', 'office_space')->first();
            @endphp
            <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
        </td>
    </tr>
    <tr>
        <td>Administrativne usluge </td>
        <td class="text-center">
            @php
                $attribute = $attributes->where('name', 'administrative_services')->first();
            @endphp
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
                    " @if ($mode == 'anonimous') disabled @endif>
        </td>
    </tr>
    <tr>
        <td>Knjigovodstvene usluge </td>
        <td class="text-center">
            @php
                $attribute = $attributes->where('name', 'bookkeeping_services')->first();
            @endphp
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
                    " @if ($mode == 'anonimous') disabled @endif>
        </td>
    </tr>
    <tr>
        <td>Pravne usluge </td>
        <td class="text-center">
            @php
                $attribute = $attributes->where('name', 'legal_services')->first();
            @endphp
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
                    " @if ($mode == 'anonimous') disabled @endif>
        </td>
    </tr>
    <tr>
        <td>Ostale usluge, navedite koje: </td>
        <td>
            @php
                $attribute = $attributes->where('name', 'other_services')->first();
            @endphp
            <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
        </td>
    </tr>
    <tr>
        <td rowspan="4" class="bg-dark text-light text-center">Ostale usluge</td>
        <td>Konsalting usluge, trening i mentoring program </td>
        <td class="text-center">
            @php
                $attribute = $attributes->where('name', 'consulting_services')->first();
            @endphp
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
                    " @if ($mode == 'anonimous') disabled @endif>
        </td>
    </tr>
    <tr>
        <td>Navedite specifične potrebe ukoliko imate: </td>
        <td>
            @php
                $attribute = $attributes->where('name', 'specific_needs')->first();
            @endphp
            <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
        </td>
    </tr>
    <tr>
        <td>Usluge promocije </td>
        <td class="text-center">
            @php
                $attribute = $attributes->where('name', 'promotion_services')->first();
            @endphp
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
                    " @if ($mode == 'anonimous') disabled @endif>
        </td>
    </tr>
    <tr>
        <td>Usluge povezivanja i umrežavanja </td>
        <td class="text-center">
            @php
                $attribute = $attributes->where('name', 'connection_services')->first();
            @endphp
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
                    " @if ($mode == 'anonimous') disabled @endif>
        </td>
    </tr>
</table>
