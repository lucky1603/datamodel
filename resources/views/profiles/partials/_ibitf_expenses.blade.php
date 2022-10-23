<h3 class="text-center attribute-label mt-4">{{ $attributeGroups->where('name', 'ibitf_expenses')->first()->label }}</h3>
<p>Potrudite se da realno sagledate troškove za naredne 3 godine i prikažite ih u
    priloženoj tabeli. Fiksni (troškovi koji su stalni i ne zavise od obima prodaje
    i proizvodnje) i varijabilni troškovi ( troškovi metarijala i ostali troškovi v
    ezani za proizvodnju i rad).</p>

<table class="w-100 table-bordered mt-4">
    <thead class="bg-dark text-light text-center">
        <tr>
            <th class="w-50"></th>
            <th class="w-15">Godina 1</th>
            <th class="w-15">Godina 2</th>
            <th class="w-15">Godina 3</th>
        </tr>
    </thead>
    <tbody>
        <tr class="bg-light">
            <td><strong>Fiksni troskovi ukupno</strong></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Zarade zaposlenih 1</td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'zarada_zaposleni_1_g1')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'zarada_zaposleni_1_g2')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'zarada_zaposleni_1_g3')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
        </tr>
        <tr>
            <td>Zarade zaposlenih 2</td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'zarada_zaposleni_2_g1')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'zarada_zaposleni_2_g2')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'zarada_zaposleni_2_g3')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
        </tr>
        <tr>
            <td>Naknada angažovani 1</td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'naknada_agazovani_1_g1')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'naknada_agazovani_1_g2')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'naknada_agazovani_1_g3')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
        </tr>
        <tr>
            <td>Naknada angažovani 2</td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'naknada_agazovani_2_g1')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'naknada_agazovani_2_g2')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'naknada_agazovani_2_g3')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
        </tr>
        <tr>
            <td>Knjigovodstvo</td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'knjigovodstvo_g1')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'knjigovodstvo_g2')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'knjigovodstvo_g3')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
        </tr>
        <tr>
            <td>Advokat</td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'Advokati_g1')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'Advokati_g2')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'Advokati_g3')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
        </tr>
        <tr>
            <td>Zakup kancelarije</td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'zakup_kancelarije_g1')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'zakup_kancelarije_g2')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'zakup_kancelarije_g3')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
        </tr>
        <tr>
            <td>Režijski troškovi</td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'rezijski_troskovi_g1')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'rezijski_troskovi_g2')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'rezijski_troskovi_g3')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
        </tr>
        <tr>
            <td>Ostali fiksni troškovi</td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'ostali_fiksni_troskovi_g1')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'ostali_fiksni_troskovi_g2')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'ostali_fiksni_troskovi_g3')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
        </tr>
        <tr class="bg-light">
            <td><strong>Varijabilni troskovi ukupno</strong></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Troškovi materijala</td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'troskovi_materijala_g1')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'troskovi_materijala_g2')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'troskovi_materijala_g3')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
        </tr>
        <tr>
            <td>Troškovi alata za rad</td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'troskovi_alata_za_rad_g1')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'troskovi_alata_za_rad_g2')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'troskovi_alata_za_rad_g3')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
        </tr>
        <tr>
            <td>Ostali troškovi</td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'ostali_troskovi_g1')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'ostali_troskovi_g2')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
            <td>
                @php
                    $attribute = $attributes->where('name', 'ostali_troskovi_g3')->first();
                @endphp
                <input class="w-100" type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if ($mode == 'anonimous') disabled @endif>
            </td>
        </tr>
    </tbody>
</table>
