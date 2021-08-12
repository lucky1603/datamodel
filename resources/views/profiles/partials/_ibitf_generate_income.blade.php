<h3 class="text-center attribute-label mt-4">{{ $attributeGroups->where('name', 'ibitf_generate_income')->first()->label }}</h3>
<p>Obrazložite : Koji je model prihodovanja (prodaja proizvoda, licenci, usluga, članarina ili sl.). Kako ćete generisati
    prihode? Koji izvor finansiranja će podići Vašu kompaniju. Popunite tabelu ispod.</p>

<table class="w-100">
    <thead class="bg-dark text-light table-bordered text-center">
        <tr>
            <th rowspan="2">Raspoloživa sredstva</th>
            <th rowspan="2">Potrebna sredstva</th>
            <th colspan="2">Izvori finansiranja</th>
        </tr>
        <tr>
            <th>Sopstvena sredstva</th>
            <th>Krediti/drugi izvori</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                @php
                    $attribute = $attributes->where('name', 'available_assets')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}">
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'needed_assets')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}">
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'own_assets')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}">
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'credits')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}">
            </td>
        </tr>
    </tbody>
</table>
