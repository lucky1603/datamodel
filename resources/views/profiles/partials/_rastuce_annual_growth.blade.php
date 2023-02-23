<h3 class="text-center attribute-label m-4">{{ mb_strtoupper(__('Rast kompanije na godišnjem nivou')) }}</h3>

<table class="table table-bordered">
    <thead class="bg-dark text-white">
        <tr>
            <th colspan="7">
                Tabela 1. Navedite broj članova tima u prethodnom periodu poslovanja (do tri godine), kao i plan rasta članova tima
            </th>
        </tr>
        <tr>
            <th class="w-50">Pokazatelj</th>
            <th>t-2</th>
            <th>t-1</th>
            <th>Tekuća godina</th>
            <th>t+1</th>
            <th>t+2</th>
            <th>t+3</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="py-0">Broj stalno zaposlenih</td>
            @foreach(['2t', '1t', 't', 't1', 't2', 't3'] as $extension)
                <td class="p-0">
                    @php
                        $attribute = $attributes->where('name', 'stalno_zaposleni_'.$extension)->first();
                        $value = $attribute->getValue() ?? old($attribute->name);
                    @endphp
                    <input
                        type="text"
                        id="{{ $attribute->name }}"
                        name="{{ $attribute->name }}"
                        class="w-100"
                        @if ($mode == "anonimous")
                            disabled
                        @endif
                        value="{{ $value }}">
                </td>
            @endforeach
        </tr>
        <tr>
            <td class="py-0">Broj angažovanih</td>
            @foreach(['2t', '1t', 't', 't1', 't2', 't3'] as $extension)
                <td class="p-0">
                    @php
                        $attribute = $attributes->where('name', 'angazovani_'.$extension)->first();
                        $value = $attribute->getValue() ?? old($attribute->name);
                    @endphp
                    <input
                        type="text"
                        id="{{ $attribute->name }}"
                        name="{{ $attribute->name }}"
                        class="w-100"
                        @if ($mode == "anonimous")
                            disabled
                        @endif
                        value="{{ $value }}">
                </td>
            @endforeach
        </tr>
        <tr>
            <td class="py-0">Broj praktikanata</td>
            @foreach(['2t', '1t', 't', 't1', 't2', 't3'] as $extension)
                <td class="p-0">
                    @php
                        $attribute = $attributes->where('name', 'praktikanti_'.$extension)->first();
                        $value = $attribute->getValue() ?? old($attribute->name);
                    @endphp
                    <input
                        type="text"
                        id="{{ $attribute->name }}"
                        name="{{ $attribute->name }}"
                        class="w-100"
                        @if ($mode == "anonimous")
                            disabled
                        @endif
                        value="{{ $value }}">
                </td>
            @endforeach
        </tr>
        <tr>
            <td colspan="7" class="bg-light">
                * U slučaju da je u pitanju novoosnovana kompanija ili kompanija koja posluje manje od tri godine,
                popunjavaju se podaci za godine poslovanja kompanije i planirani rast.
            </td>
        </tr>

    </tbody>

</table>

<table class="table table-bordered">
    <thead class="bg-dark text-white">
        <tr>
            <th colspan="7">
                Tabela 2: Navedite broj članova tima  matične kompanije  u prethodnom  periodu poslovanja  (do tri godine),
                kao i plan rasta članova tima:
            </th>
        </tr>
        <tr>
            <th class="w-50">Pokazatelj</th>
            <th>t-2</th>
            <th>t-1</th>
            <th>Tekuća godina</th>
            <th>t+1</th>
            <th>t+2</th>
            <th>t+3</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="py-0">Broj stalno zaposlenih</td>
            @foreach(['2t', '1t', 't', 't1', 't2', 't3'] as $extension)
                <td class="p-0">
                    @php
                        $attribute = $attributes->where('name', 'maticna_stalno_zaposleni_'.$extension)->first();
                        $value = $attribute->getValue() ?? old($attribute->name);
                    @endphp
                    <input
                        type="text"
                        id="{{ $attribute->name }}"
                        name="{{ $attribute->name }}"
                        class="w-100"
                        @if ($mode == "anonimous")
                            disabled
                        @endif
                        value="{{ $value }}">
                </td>
            @endforeach
        </tr>
        <tr>
            <td class="py-0">Broj angažovanih</td>
            @foreach(['2t', '1t', 't', 't1', 't2', 't3'] as $extension)
                <td class="p-0">
                    @php
                        $attribute = $attributes->where('name', 'maticna_angazovani_'.$extension)->first();
                        $value = $attribute->getValue() ?? old($attribute->name);
                    @endphp
                    <input
                        type="text"
                        id="{{ $attribute->name }}"
                        name="{{ $attribute->name }}"
                        class="w-100"
                        @if ($mode == "anonimous")
                            disabled
                        @endif
                        value="{{ $value }}">
                </td>
            @endforeach
        </tr>
        <tr>
            <td class="py-0">Broj praktikanata</td>
            @foreach(['2t', '1t', 't', 't1', 't2', 't3'] as $extension)
                <td class="p-0">
                    @php
                        $attribute = $attributes->where('name', 'maticna_praktikanti_'.$extension)->first();
                        $value = $attribute->getValue() ?? old($attribute->name);
                    @endphp
                    <input
                        type="text"
                        id="{{ $attribute->name }}"
                        name="{{ $attribute->name }}"
                        class="w-100"
                        @if ($mode == "anonimous")
                            disabled
                        @endif
                        value="{{ $value }}">
                </td>
            @endforeach
        </tr>
        <tr>
            <td colspan="7" class="bg-light">
                * U slučaju da  konkurišete kao matična kompanija koja uspostavlja razvojne aktivnosti u NTP Beograd.
            </td>
        </tr>

    </tbody>

</table>

<table class="table table-bordered">
    <thead class="bg-dark text-white">
        <tr>
            <th colspan="7">
                Tabela 3: Navedite iznos ukupnih prihoda i izvoza u prethodnom poslovanju kao i planirani rast
            </th>
        </tr>
        <tr>
            <th class="w-50">Pokazatelj</th>
            <th>t-2</th>
            <th>t-1</th>
            <th>Tekuća godina</th>
            <th>t+1</th>
            <th>t+2</th>
            <th>t+3</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="py-0">Ukupni prihodi (u 000 EUR)</td>
            @foreach(['2t', '1t', 't', 't1', 't2', 't3'] as $extension)
                <td class="p-0">
                    @php
                        $attribute = $attributes->where('name', 'total_income_'.$extension)->first();
                        $value = $attribute->getValue() ?? old($attribute->name);
                    @endphp
                    <input
                        type="text"
                        id="{{ $attribute->name }}"
                        name="{{ $attribute->name }}"
                        class="w-100"
                        @if ($mode == "anonimous")
                            disabled
                        @endif
                        value="{{ $value }}">
                </td>
            @endforeach
        </tr>
        <tr>
            <td class="py-0">Ukupni prihodi od komercijalizacije inovativnog proizvoda (u 000 EUR)</td>
            @foreach(['2t', '1t', 't', 't1', 't2', 't3'] as $extension)
                <td class="p-0">
                    @php
                        $attribute = $attributes->where('name', 'total_income_commercialization_'.$extension)->first();
                        $value = $attribute->getValue() ?? old($attribute->name);
                    @endphp
                    <input
                        type="text"
                        id="{{ $attribute->name }}"
                        name="{{ $attribute->name }}"
                        class="w-100"
                        @if ($mode == "anonimous")
                            disabled
                        @endif
                        value="{{ $value }}">
                </td>
            @endforeach
        </tr>
        <tr>
            <td class="py-0">Ukupni izvoz (u 000 EUR)</td>
            @foreach(['2t', '1t', 't', 't1', 't2', 't3'] as $extension)
                <td class="p-0">
                    @php
                        $attribute = $attributes->where('name', 'total_export_'.$extension)->first();
                        $value = $attribute->getValue() ?? old($attribute->name);
                    @endphp
                    <input
                        type="text"
                        id="{{ $attribute->name }}"
                        name="{{ $attribute->name }}"
                        class="w-100"
                        @if ($mode == "anonimous")
                            disabled
                        @endif
                        value="{{ $value }}">
                </td>
            @endforeach
        </tr>
        <tr>
            <td colspan="7" class="bg-light">
                * U slučaju da je u pitanju novoosnovana kompanija ili kompanija koja posluje manje od tri godine, popunjavaju se podaci za godine poslovanja kompanije i planirani rast.
            </td>
        </tr>

    </tbody>

</table>

<table class="table table-bordered">
    <thead class="bg-dark text-white">
        <tr>
            <th colspan="7">
                Tabela 4: Navedite iznos ukupnih prihoda i izvoza u prethodnom poslovanju matične kompanije kao i planirani rast.
            </th>
        </tr>
        <tr>
            <th class="w-50">Pokazatelj</th>
            <th>t-2</th>
            <th>t-1</th>
            <th>Tekuća godina</th>
            <th>t+1</th>
            <th>t+2</th>
            <th>t+3</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="py-0">Ukupni prihodi (u 000 EUR)</td>
            @foreach(['2t', '1t', 't', 't1', 't2', 't3'] as $extension)
                <td class="p-0">
                    @php
                        $attribute = $attributes->where('name', 'total_income_maticna_'.$extension)->first();
                        $value = $attribute->getValue() ?? old($attribute->name);
                    @endphp
                    <input
                        type="text"
                        id="{{ $attribute->name }}"
                        name="{{ $attribute->name }}"
                        class="w-100"
                        @if ($mode == "anonimous")
                            disabled
                        @endif
                        value="{{ $value }}">
                </td>
            @endforeach
        </tr>
        <tr>
            <td class="py-0">Ukupni izvoz (u 000 EUR)</td>
            @foreach(['2t', '1t', 't', 't1', 't2', 't3'] as $extension)
                <td class="p-0">
                    @php
                        $attribute = $attributes->where('name', 'total_export_maticna_'.$extension)->first();
                        $value = $attribute->getValue() ?? old($attribute->name);
                    @endphp
                    <input
                        type="text"
                        id="{{ $attribute->name }}"
                        name="{{ $attribute->name }}"
                        class="w-100"
                        @if ($mode == "anonimous")
                            disabled
                        @endif
                        value="{{ $value }}">
                </td>
            @endforeach
        </tr>
        <tr>
            <td colspan="7" class="bg-light">
                * U slučaju da  konkurišete kao matična kompanija koja uspostavlja razvojne aktivnosti u NTP Beograd.
            </td>
        </tr>

    </tbody>

</table>
