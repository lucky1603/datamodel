<div class="card ribbon-box shadow-sm border-left border-success h-100 p-0" style="border-width: 5px!important;">
    <div class="card-body m-0">
        @php
            switch($training->getValue('event_status')) {
                case 1:
                    $ribbonClass = 'ribbon-two ribbon-two-warning';
                    break;
                case 2:
                    $ribbonClass = 'ribbon-two ribbon-two-info';
                    break;
                case 3:
                    $ribbonClass = 'ribbon-two ribbon-two-success';
                    break;
                default:
                    $ribbonClass = 'ribbon-two ribbon-two-secondary';
                    break;
            }
        @endphp
        <div class="{{ $ribbonClass }}">
            <span>{{ $training->getText('event_status') }}</span>
        </div>
        <div class="row" style="height: 25%">
            <div class="col-9">
                <h3>{{ $training->getData()['training_name'] }}</h3>
                <p>{{ $training->getData()['training_short_note'] }}</p>
            </div>
            <div class="col-3 text-center">
                @switch($training->getData()['training_type'])
                    @case(1)
                    <img class="shadow-lg" src="/images/custom/workshop1.png" width="50">
                    @break
                    @case(2)
                    <img class="shadow-lg" src="/images/custom/training.png" width="50">
                    @break
                    @case(3)
                    <img class="shadow-lg" src="/images/custom/meeting.png" width="50">
                @endswitch
                <p class="font-11 mt-1 attribute-label">{{ $training->getText('training_type') }}</p>
            </div>
        </div>
        <hr class="m-0 mt-1">
        <div class="row" style="height: 65%">
            <div class="col-lg-12">
                <p class="mt-4 mb-0 font-12"><i class="dripicons-user mr-2 font-16 attribute-label" role="button" title="Domaćin"></i>{{ $training->getData()['training_host'] }} </p>
                <p class="mt-0 mb-0 font-12"><i class="dripicons-location mr-2 font-16 attribute-label" role="button" title="Mesto održavanja"></i>{{ $training->getData()['location'] }}</p>
                <p class="mt-0 mb-0 font-12"><i class="dripicons-clock mr-2 font-16 attribute-label" role="button" title="Datum i vreme početka"></i>
                    {{ $training->getAttribute('training_start_date')->getText() }} {{ $training->getAttribute('training_start_time')->getText() }}
                </p>
                @if($training->getValue('training_duration') != 0)
                    <p class="mt-0 font-12"><i class="dripicons-clockwise mr-2 font-16 attribute-label" role="button" title="Trajanje"></i>
                        {{ $training->getText('training_duration') }} {{ $training->getText('training_duration_unit') }}
                    </p>
                @endif
            </div>

        </div>
        <hr class="m-0"/>
        <div class="row" style="height: 10%">
            <div class="col-6">
                @if(isset($attendance))
                    <p class="mt-1 mb-0 font-12" title="Prisustvo">{{ $attendance->getText('attendance') }}
                        <i class="@switch($attendance->getValue('attendance'))
                        @case(1)
                            dripicons-mail
                                @break
                        @case(2)
                            dripicons-preview
                            @break
                        @default
                            dripicons-tag-delete
                            @break
                        @endswitch ml-2 font-16 attribute-label" role="button"></i></p>
                @endif
            </div>
            <div class="col-6">
                @yield('select-actions')
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('trainings.delete', $training->getId()) }}"
                       id="deleteButton" class="float-right"
                       data-toggle="modal"
                       data-target="#messageBox" title="Obrisi sesiju" data-id="{{ $training->getId() }}">
                        <i class="mdi mdi-delete font-24 text-success"></i>
                    </a>
                @endif
                <a href="{{ route('trainings.show', $training->getId()) }}"
                   class="float-right mr-1" title="{{ __('Preview Details') }}">
                    <i class="mdi mdi-glasses font-24 text-success"></i>
                </a>
            </div>
        </div>
    </div>
</div>
