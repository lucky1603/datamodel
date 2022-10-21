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
                        @if($attributeGroup->name == 'ibitf_founders')

                            @php
                                $founders = $program->getFounders();
                            @endphp

                            <table class="table table-sm table-bordered font-12">
                                <thead class="bg-primary text-light">
                                <tr>
                                    <th class="w-25">{{ __('Founder') }}</th>
                                    <th class="w-50">{{ __('University') }}</th>
                                    <th class="w-25">{{ __('Share [%]') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($founders as $founder)
                                        <tr>
                                            <td>{{ $founder->getValue('founder_name') }}</td>
                                            <td>{{ $founder->getValue('founder_university')}}</td>
                                            <td>{{ $founder->getValue('founder_part')}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @elseif($attributeGroup->name == 'ibitf_expenses')
                            <table class="table table-sm table-bordered font-12">
                                <thead class="bg-primary text-light">
                                <tr>
                                    <th class="h-50"></th>
                                    <th class="h-15">{{ __('Year') }} 1</th>
                                    <th class="h-15">{{ __('Year') }} 2</th>
                                    <th class="h-15">{{ __('Year') }} 3</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $attributes->where('name','zarada_zaposleni_1_g1')->first()->label }}</td>
                                    @for($i = 1; $i <= 3; $i ++)
                                        <td>{{ $attributes->where('name', 'zarada_zaposleni_1_g'.$i)->first()->getValue() }}</td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td>{{ $attributes->where('name','zarada_zaposleni_2_g1')->first()->label }}</td>
                                    @for($i = 1; $i <= 3; $i ++)
                                        <td>{{ $attributes->where('name', 'zarada_zaposleni_2_g'.$i)->first()->getValue() }}</td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td>{{ $attributes->where('name','naknada_agazovani_1_g1')->first()->label }}</td>
                                    @for($i = 1; $i <= 3; $i ++)
                                        <td>{{ $attributes->where('name', 'naknada_agazovani_1_g'.$i)->first()->getValue() }}</td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td>{{ $attributes->where('name','naknada_agazovani_2_g1')->first()->label }}</td>
                                    @for($i = 1; $i <= 3; $i ++)
                                        <td>{{ $attributes->where('name', 'naknada_agazovani_2_g'.$i)->first()->getValue() }}</td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td>{{ $attributes->where('name','knjigovodstvo_g1')->first()->label }}</td>
                                    @for($i = 1; $i <= 3; $i ++)
                                        <td>{{ $attributes->where('name', 'knjigovodstvo_g'.$i)->first()->getValue() }}</td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td>{{ $attributes->where('name','knjigovodstvo_g1')->first()->label }}</td>
                                    @for($i = 1; $i <= 3; $i ++)
                                        <td>{{ $attributes->where('name', 'knjigovodstvo_g'.$i)->first()->getValue() }}</td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td>{{ $attributes->where('name','Advokati_g1')->first()->label }}</td>
                                    @for($i = 1; $i <= 3; $i ++)
                                        <td>{{ $attributes->where('name', 'Advokati_g'.$i)->first()->getValue() }}</td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td>{{ $attributes->where('name','zakup_kancelarije_g1')->first()->label }}</td>
                                    @for($i = 1; $i <= 3; $i ++)
                                        <td>{{ $attributes->where('name', 'zakup_kancelarije_g'.$i)->first()->getValue() }}</td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td>{{ $attributes->where('name','rezijski_troskovi_g1')->first()->label }}</td>
                                    @for($i = 1; $i <= 3; $i ++)
                                        <td>{{ $attributes->where('name', 'rezijski_troskovi_g'.$i)->first()->getValue() }}</td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td>{{ $attributes->where('name','ostali_fiksni_troskovi_g1')->first()->label }}</td>
                                    @for($i = 1; $i <= 3; $i ++)
                                        <td>{{ $attributes->where('name', 'ostali_fiksni_troskovi_g'.$i)->first()->getValue() }}</td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td>{{ $attributes->where('name','troskovi_materijala_g1')->first()->label }}</td>
                                    @for($i = 1; $i <= 3; $i ++)
                                        <td>{{ $attributes->where('name', 'troskovi_materijala_g'.$i)->first()->getValue() }}</td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td>{{ $attributes->where('name','troskovi_alata_za_rad_g1')->first()->label }}</td>
                                    @for($i = 1; $i <= 3; $i ++)
                                        <td>{{ $attributes->where('name', 'troskovi_alata_za_rad_g'.$i)->first()->getValue() }}</td>
                                    @endfor
                                </tr>
                                <tr>
                                    <td>{{ $attributes->where('name','ostali_troskovi_g1')->first()->label }}</td>
                                    @for($i = 1; $i <= 3; $i ++)
                                        <td>{{ $attributes->where('name', 'ostali_troskovi_g'.$i)->first()->getValue() }}</td>
                                    @endfor
                                </tr>
                                </tbody>
                            </table>
                        @elseif($attributeGroup->name == 'ibitf_attachments')
                            <table class="table table-sm">
                                <tbody>
                                @php
                                    $attribute = $attributes->where('name', 'resenje_apr_link')->first();
                                @endphp
                                @if($attribute != null)
                                    <tr>

                                        <td class="bg-primary text-light">{{ $attribute->label }}</td>
                                        <td><a href="{{$attribute->getValue() }}">{{ $attribute->getValue() }}</a></td>
                                    </tr>
                                @endif
                                @php
                                    $attribute = $attributes->where('name', 'resenje_fajl')->first();
                                @endphp
                                @if($attribute != null && $attribute->getValue() != null && strlen($attribute->getValue()['filename']) > 0)
                                    <tr>
                                        <td class="bg-primary text-light">{{ $attribute->label }}</td>
                                        <td>
                                            @include('layouts.controls._show_file', ['attribute' => $attribute])
                                        </td>
                                    </tr>
                                @endif
                                @php
                                    $attribute = $attributes->where('name', 'linkedin_founders')->first();
                                @endphp
                                @if($attribute != null)
                                    <tr>

                                        <td class="bg-primary text-light">{{ $attribute->label }}</td>
                                        <td><a href="{{ $attribute->getValue() }}">{{ $attribute->getValue() }}</a></td>
                                    </tr>
                                @endif
                                @php
                                    $attribute = $attributes->where('name', 'founders_cv')->first();
                                @endphp
                                @if($attribute != null && $attribute->getValue() != null && strlen($attribute->getValue()['filename']) > 0)
                                    <tr>
                                        <td class="bg-primary text-light">{{ $attribute->label }}</td>
                                        <td>
                                            @include('layouts.controls._show_file', ['attribute' => $attribute])
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        @elseif($attributeGroup->name == 'ibitf_generate_income')
                            @php
                                $attributes = $program->getAttributesForGroup($attributeGroup);
                            @endphp
                            <table class="w-100 table table-sm table-bordered font-12">
                                @php
                                    $attribute = $attributes->where('name', 'generating_income')->first();
                                @endphp
                                <tbody>
                                <tr>
                                    <td class="w-25 bg-primary text-light text-center">{{ $attribute->label }}</td>
                                    <td>{{ $attribute->getText() }}</td>
                                </tr>
                                </tbody>
                            </table>
                            <table class="table table-sm table-bordered text-center font-12">
                                <thead class="bg-primary text-light">
                                <tr>
                                    <th rowspan="2">{{__('Available Assets')}}</th>
                                    <th rowspan="2">{{__('Needed Assets') }}</th>
                                    <th colspan="2">{{__('Financing Sources')}}</th>
                                </tr>
                                <tr>
                                    <th>{{__('Own Assets')}}</th>
                                    <th>{{__('Credits/Other Way of Financing')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>{{ $attributes->where('name', 'available_assets')->first()->getValue() }} </td>
                                    <td>{{ $attributes->where('name', 'needed_assets')->first()->getValue() }} </td>
                                    <td>{{ $attributes->where('name', 'own_assets')->first()->getValue() }} </td>
                                    <td>{{ $attributes->where('name', 'credits')->first()->getValue() }} </td>
                                </tr>
                                </tbody>
                            </table>
                        @else
                            <table class="w-100 table table-sm table-bordered font-12">
                                <tbody>
                                @foreach($attributes as $attribute)
                                    <tr style="height: 40px">
                                        <td class="w-25 bg-primary text-light text-center" >
                                            {{ $attribute->label }}
                                        </td>
                                        <td class="w-75 @if($attribute->type == 'text') text-left @else text-center @endif">
                                            {{ $attribute->getText() }}
                                        </td>
                                    </tr>
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
