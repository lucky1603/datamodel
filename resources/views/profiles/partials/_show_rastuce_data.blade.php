@if($program->getAttributeGroups()->count() > 0)
    <div id="applicationData" class="accordion" style="max-height: 400px">
        @foreach($program->getAttributeGroups() as $attributeGroup)
            <div class="card mb=0 ml-2 mr-2">
                <div class="card-header" id="heading{{ $attributeGroup->name  }}">
                    <h5 class="m-0">
                        <a class="custom-accordion-title d-block pt-2 pb-2"
                           data-toggle="collapse" href="#collapse{{ $attributeGroup->name }}"
                           aria-expanded="@if($loop->first) true @else false @endif" aria-controls="collapse{{ $attributeGroup->name }}" >
                            {{ $attributeGroup->label }}
                            <i class="mdi mdi-chevron-down accordion-arrow"></i></a>
                    </h5>
                </div>
                <div id="collapse{{ $attributeGroup->name }}" class="collapse @if($loop->first) show @endif"
                     aria-labelledby="heading{{ $attributeGroup->name }}" data-parent="#applicationData">
                    <div class="card-body">
                        @php
                            $attributes = $program->getAttributesForGroup($attributeGroup);
                        @endphp
                        @if($attributeGroup->name == 'rastuce_rast_godisnji')



                            <table class="table table-sm table-bordered font-12">
                                <thead class="bg-primary text-light">
                                    <tr>
                                        <th colspan="7">
                                            Tabela 1. Navedite broj članova tima u prethodnom periodu poslovanja (do tri godine), kao i plan rasta članova tima
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Pokazatelj</th>
                                        <td>t-2</td>
                                        <td>t-1</td>
                                        <td>Tekuca godina</td>
                                        <td>t-1</td>
                                        <td>t-2</td>
                                        <td>t-3</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Broj stalno zaposlenih</td>
                                        @foreach([
                                            "stalno_zaposleni_2t",
                                            "stalno_zaposleni_1t",
                                            "stalno_zaposleni_t",
                                            "stalno_zaposleni_t1",
                                            "stalno_zaposleni_t2",
                                            "stalno_zaposleni_t3"
                                        ] as $name)
                                            @php
                                                $attribute = $attributes->where('name', $name)->first();
                                                $value = $attribute->getValue() ?? '';
                                            @endphp
                                            <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>Broj angazovanih</td>
                                        @foreach([
                                            "angazovani_2t",
                                            "angazovani_1t",
                                            "angazovani_t",
                                            "angazovani_t1",
                                            "angazovani_t2",
                                            "angazovani_t3"
                                        ] as $name)
                                            @php
                                                $attribute = $attributes->where('name', $name)->first();
                                                $value = $attribute->getValue() ?? '';
                                            @endphp
                                            <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>Broj praktikanata</td>
                                        @foreach([
                                            "praktikanti_2t",
                                            "praktikanti_1t",
                                            "praktikanti_t",
                                            "praktikanti_t1",
                                            "praktikanti_t2",
                                            "praktikanti_t3"
                                        ] as $name)
                                            @php
                                                $attribute = $attributes->where('name', $name)->first();
                                                $value = $attribute->getValue() ?? '';
                                            @endphp
                                            <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>

                                </tbody>
                            </table>
                            <table class="table table-sm table-bordered font-12">
                                <thead class="bg-primary text-light">
                                    <tr>
                                        <th colspan="7">
                                            Tabela 2: Navedite broj članova tima matične kompanije u prethodnom periodu poslovanja (do tri godine), kao i plan rasta članova tima:
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Pokazatelj</th>
                                        <td>t-2</td>
                                        <td>t-1</td>
                                        <td>Tekuca godina</td>
                                        <td>t-1</td>
                                        <td>t-2</td>
                                        <td>t-3</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Broj stalno zaposlenih</td>
                                        @foreach([
                                            "maticna_stalno_zaposleni_2t",
                                            "maticna_stalno_zaposleni_1t",
                                            "maticna_stalno_zaposleni_t",
                                            "maticna_stalno_zaposleni_t1",
                                            "maticna_stalno_zaposleni_t2",
                                            "maticna_stalno_zaposleni_t3"
                                        ] as $name)
                                            @php
                                                $attribute = $attributes->where('name', $name)->first();
                                                $value = $attribute->getValue() ?? '';
                                            @endphp
                                            <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>Broj angazovanih</td>
                                        @foreach([
                                            "maticna_angazovani_2t",
                                            "maticna_angazovani_1t",
                                            "maticna_angazovani_t",
                                            "maticna_angazovani_t1",
                                            "maticna_angazovani_t2",
                                            "maticna_angazovani_t3"
                                        ] as $name)
                                            @php
                                                $attribute = $attributes->where('name', $name)->first();
                                                $value = $attribute->getValue() ?? '';
                                            @endphp
                                            <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>Broj praktikanata</td>
                                        @foreach([
                                            "maticna_praktikanti_2t",
                                            "maticna_praktikanti_1t",
                                            "maticna_praktikanti_t",
                                            "maticna_praktikanti_t1",
                                            "maticna_praktikanti_t2",
                                            "maticna_praktikanti_t3"
                                        ] as $name)
                                            @php
                                                $attribute = $attributes->where('name', $name)->first();
                                                $value = $attribute->getValue() ?? '';
                                            @endphp
                                            <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>

                                </tbody>
                            </table>

                            <table class="table table-sm table-bordered font-12">
                                <thead class="bg-primary text-light">
                                    <tr>
                                        <th colspan="7">
                                            Tabela 3: Navedite iznos ukupnih prihoda i izvoza u prethodnom poslovanju kao i planirani rast
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Pokazatelj</th>
                                        <td>t-2</td>
                                        <td>t-1</td>
                                        <td>Tekuca godina</td>
                                        <td>t-1</td>
                                        <td>t-2</td>
                                        <td>t-3</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Ukupno prihodi (u 000 EUR) t-2</td>
                                        @foreach([
                                            "total_income_2t",
                                            "total_income_1t",
                                            "total_income_t",
                                            "total_income_t1",
                                            "total_income_t2",
                                            "total_income_t3"
                                        ] as $name)
                                            @php
                                                $attribute = $attributes->where('name', $name)->first();
                                                $value = $attribute->getValue() ?? '';
                                            @endphp
                                            <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>Ukupni prihodi od komercijalizacije inovativnog proizvoda (u 000 EUR)</td>
                                        @foreach([
                                            "total_income_commercialization_2t",
                                            "total_income_commercialization_1t",
                                            "total_income_commercialization_t",
                                            "total_income_commercialization_t1",
                                            "total_income_commercialization_t2",
                                            "total_income_commercialization_t3"
                                        ] as $name)
                                            @php
                                                $attribute = $attributes->where('name', $name)->first();
                                                $value = $attribute->getValue() ?? '';
                                            @endphp
                                            <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <td>Ukupni izvoz (u 000 EUR)</td>
                                        @foreach([
                                            "total_export_2t",
                                            "total_export_1t",
                                            "total_export_t",
                                            "total_export_t1",
                                            "total_export_t2",
                                            "total_export_t3"
                                        ] as $name)
                                            @php
                                                $attribute = $attributes->where('name', $name)->first();
                                                $value = $attribute->getValue() ?? '';
                                            @endphp
                                            <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>

                            <table class="table table-sm table-bordered font-12">
                                <thead class="bg-primary text-light">
                                    <tr>
                                        <th colspan="7">
                                            Tabela 4: Navedite iznos ukupnih prihoda i izvoza u prethodnom poslovanju matične kompanije kao i planirani rast.
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>Pokazatelj</th>
                                        <td>t-2</td>
                                        <td>t-1</td>
                                        <td>Tekuca godina</td>
                                        <td>t-1</td>
                                        <td>t-2</td>
                                        <td>t-3</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Ukupno prihodi (u 000 EUR) t-2</td>
                                        @foreach([
                                            "total_income_maticna_2t",
                                            "total_income_maticna_1t",
                                            "total_income_maticna_t",
                                            "total_income_maticna_t1",
                                            "total_income_maticna_t2",
                                            "total_income_maticna_t3"
                                        ] as $name)
                                            @php
                                                $attribute = $attributes->where('name', $name)->first();
                                                $value = $attribute->getValue() ?? '';
                                            @endphp
                                            <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td>Ukupni izvoz (u 000 EUR)</td>
                                        @foreach([
                                            "total_export_maticna_2t",
                                            "total_export_maticna_1t",
                                            "total_export_maticna_t",
                                            "total_export_maticna_t1",
                                            "total_export_maticna_t2",
                                            "total_export_maticna_t3"
                                        ] as $name)
                                            @php
                                                $attribute = $attributes->where('name', $name)->first();
                                                $value = $attribute->getValue() ?? '';
                                            @endphp
                                            <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        @else
                            <table class="w-100 table table-sm table-bordered font-12">
                                <tbody>
                                @foreach($attributes as $attribute)
                                    @if($attribute->type == 'file')
                                        <tr style="height: 40px">
                                            <td class="w-25 bg-primary text-light text-center">{{ $attribute->label }}</td>
                                            <td class="w-75">
                                                @php
                                                    $files = $attribute->getValue();
                                                    if(!is_array($files))
                                                        $files = [$files];
                                                @endphp
                                                <div style="display: flex; flex-wrap: wrap; width: 100%">
                                                    @foreach($files as $file)
                                                        @if(is_array($file))
                                                            <a href="{{ $file['filelink'] }}" target="_blank" class="mr-2">{{ $file['filename'] }}</a>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                    @else
                                        <tr style="height: 40px">
                                            <td class="w-25 bg-primary text-light text-center" >
                                                {{ $attribute->label }}
                                            </td>
                                            <td class="w-75 @if($attribute->type == 'text') text-left @else text-center @endif">
                                                {{ $attribute->getText() }}
                                            </td>
                                        </tr>
                                        @endif
                                @endforeach
                                </tbody>
                            </table>
                        @endif

                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endif
