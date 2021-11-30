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
                        @if($attributeGroup->name == 'rstarts_tim')
                            @php
                                $teamMembers = $model->getActiveProgram()->getTeamMembers();
                                $founders = $model->getActiveProgram()->getFounders();
                            @endphp
                            @if($teamMembers->count() > 0)
                                <h5 class="text-center">Članovi tima</h5>
                                <table class="table table-bordered">
                                    <thead class="bg-primary text-light align-items-center">
                                    <tr>
                                        <th class="w-25">Ime, prezime i zvanje</th>
                                        <th class="w-25">Obrazovanje, iskustvo</th>
                                        <th class="w-25">Uloga u razvoju startapa, vreme posvećeno razvoju startapa</th>
                                        <th class="w-25">Drugi posao</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($teamMembers as $teamMember)
                                            <tr>
                                                <td>{{ $teamMember->getValue('team_member_name') }}</td>
                                                <td>{{ $teamMember->getValue('team_education') }}</td>
                                                <td>{{ $teamMember->getValue('team_role') }}</td>
                                                <td>{{ $teamMember->getValue('team_other_job') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                            @if($founders->count() > 0)
                                <h5 class="text-center">Osnivači</h5>
                                <table class="table table-bordered">
                                    <thead class="bg-primary text-light">
                                        <tr >
                                            <th class="w-75">Ime i prezime</th>
                                            <th class="w-25">Udeo [%]</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($founders as $founder)
                                            <tr>
                                                <td>{{ $founder->getValue('founder_name') }}</td>
                                                <td>{{ $founder->getValue('founder_part') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                            <h5 class="text-center">Ostali podaci</h5>
                            <table class="w-100 table table-sm table-bordered font-12">
                                <tbody>
                                @foreach($attributes as $attribute)
                                    <tr style="height: 40px; width: 100%; border: 1px solid red">
                                        <td class="w-25 bg-primary text-light text-center" >
                                            {{ $attribute->label }}
                                        </td>
                                        <td class="w-75 @if($attribute->type == 'text') text-left @else text-center @endif" >
                                            <div style="display: flex; flex-wrap: wrap; width: 100%">
                                                @if($attribute->name == 'rstarts_founder_cvs')
                                                    @php
                                                        $cvs = $attribute->getValue();
                                                    @endphp
                                                    @if($cvs != null && count($cvs) > 0)
                                                        @foreach($cvs as $cv)
                                                            @if(is_array($cv))
                                                            <a href="{{ $cv['filelink'] }}" target="_blank" class="mr-3">{{ $cv['filename'] }}</a>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                @else
                                                    @if(!is_array($attribute->getValue()))
                                                        {{ $attribute->getText() }}
                                                    @elseif($attribute->type == 'varchar' && $attribute->extra == 'multiple')
                                                        <div style="display: flex; flex-wrap: wrap; width: 100%">
                                                            @foreach($attribute->getValue() as $link)
                                                                @php
                                                                    if(!str_contains('http://', $link))
                                                                        $link = "http://".$link;
                                                                @endphp
                                                                <a href="{{$link}}" target="_blank" class="ml-1">{{ $link }}</a>
                                                            @endforeach
                                                        </div>
                                                    @elseif($attribute->type == 'varchar' && $attribute->extra == 'link')
                                                        <a href="{{ $attribute->getValue() }}" target="_blank">{{ $attribute->getValue() }}</a>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
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
                                            @if($attribute->name == 'rstarts_logo')
                                                @if($attribute->getValue()['filelink'] != '')
                                                    <img src="{{ $attribute->getValue()['filelink'] }}" style="height: 100px">
                                                @else
                                                    <img src="/images/custom/nophoto2.png" style="height: 100px">
                                                @endif
                                            @elseif($attribute->type == 'varchar' && $attribute->extra == 'multiple')
                                                @php
                                                    $links = $attribute->getValue();
                                                    if(!is_array($links))
                                                        $links = [$links];
                                                @endphp
                                                <div style="display: flex; flex-wrap: wrap; width: 100%">
                                                    @foreach($links as $link)
                                                        @php
                                                            if(!str_contains($link, 'http://') && !str_contains($link, 'https://'))
                                                                $link = "http://".$link;
                                                        @endphp
                                                        <a href="{{ $link }}" target="_blank" class="mr-2">{!! $link !!}</a>
                                                    @endforeach
                                                </div>
                                            @elseif($attribute->type == 'varchar' && $attribute->extra == 'link')
                                                @php
                                                    $link = $attribute->getValue();
                                                    if($link != null && !str_contains($link, 'http://') && !str_contains($link, 'https' ))
                                                        $link = "http://".$link;
                                                @endphp
                                                @if($link != null)
                                                    <a href="{{ $link }}" target="_blank">{!! $link !!}</a>
                                                @endif
                                            @elseif($attribute->type == 'file' && $attribute->extra == 'multiple')
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
                                            @else
                                                {{ $attribute->getText() }}
                                            @endif
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
