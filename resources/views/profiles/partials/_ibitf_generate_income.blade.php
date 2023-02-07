<h3 class="text-center @if($mode == 'anonimous') attribute-grayed @else attribute-label @endif mt-4">{{ mb_strtoupper(__('Generisanje prihoda'))  }}</h3>
<p class="@if($mode != 'anonimous') mandatory-label @endif">Obrazložite: Koji je model prihodovanja (prodaja proizvoda, licenci, usluga, članarina ili sl.). Kako ćete generisati
    prihode? Koji izvor finansiranja će podići Vašu kompaniju. Popunite tabelu ispod.</p>
@php
    $attribute = $attributes->where('name', 'generating_income')->first();
    $value = $attribute->getValue() ?? old($attribute->name);
@endphp
<textarea class="form-control mb-2" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3" @if ($mode == 'anonimous') disabled @endif>{{ $value }}</textarea>
<table class="w-100">
    <thead class="bg-dark text-light table-bordered text-center">
        <tr>
            <th rowspan="2" class="@if($mode != 'anonimous') mandatory-label @endif">Raspoloživa sredstva</th>
            <th rowspan="2" class="@if($mode != 'anonimous') mandatory-label @endif">Potrebna sredstva</th>
            <th colspan="2">Izvori finansiranja</th>
        </tr>
        <tr>
            <th  class="@if($mode != 'anonimous') mandatory-label @endif">Sopstvena sredstva</th>
            <th  class="@if($mode != 'anonimous') mandatory-label @endif">Krediti/drugi izvori</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                @php
                    $attribute = $attributes->where('name', 'available_assets')->first();
                    $value = $attribute->getValue() ?? old($attribute->name);
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'needed_assets')->first();
                    $value = $attribute->getValue() ?? old($attribute->name);
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'own_assets')->first();
                    $value = $attribute->getValue() ?? old($attribute->name);
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'credits')->first();
                    $value = $attribute->getValue() ?? old($attribute->name);
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
        </tr>
    </tbody>
</table>

@php
    $attribute = $attributes->where('name', 'income_expectations')->first();
    $value = $attribute->getValue() ?? old($attribute->name);
@endphp
<div class="form-group mt-2">
    <label for="{{ $attribute->name }}" class="@if($mode == 'anonimous') attribute-grayed @else attribute-label mandatory-label @endif">{!! $attribute->label !!}</label><br/>
    <span class="mt-0" style="font-size: 12px; position: relative; top: -10px">Odgovorite tekstualno sa obrazloženjem ili u vidu cash flow ili dijagrama.</span>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3" @if ($mode == 'anonimous') disabled @endif>{{ $value }}</textarea>
</div>

@php
    $attribute = $attributes->where('name', 'intellectual_property')->first();
    $value = $attribute->getValue() ?? old($attribute->name);
@endphp
<div class="form-group mt-2">
    <label for="{{ $attribute->name }}" class="@if($mode == 'anonimous') attribute-grayed @else attribute-label mandatory-label @endif">{!! $attribute->label !!}</label><br/>
    <span class="mt-0" style="font-size: 12px; position: relative; top: -10px">Da li imate zaštićen patent? Da li ste razmišljali o zaštiti intelektualne svojine i ako jeste, da li ste proverili mogućnosti?</span>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3" @if ($mode == 'anonimous') disabled @endif>{{ $value }}</textarea>
</div>
