@extends('layouts.hyper-vertical-profile')

@section('profile-content')
    <div class="card" style="height: 100%;">
        <div class="card-header">

            <ul class="nav page-title" >
                <li class="nav-item"><label style="margin-top: 8px"><strong>{{ __('EVENT FILTER') }}:</strong></label></li>
                <li class="nav-item" style="margin-left: 40px">
                    <div class="input-group input-group-sm" style="margin-top: 2px">
                        <div class="input-group-prepend">
                            <span class="input-group-text small">{{ __('By Type') }}</span>
                        </div>
                        <select name="clientStatus" id="clientStatus" class="form-control form-control-sm">
                            <option value="1">{{ __('Workshop') }}</option>
                            <option value="2">{{ __('Training') }}</option>
                            <option value="3">{{ __('Event') }}</option>
                        </select>
                    </div>
                </li>
                <li class="nav-item" style="margin-left: 20px">
                    <div class="input-group input-group-sm" style="margin-top: 2px;">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{ __('By Name') }}</span>
                        </div>
                        <input type="text" id="profileSearch" name="profileSearch" class="form-control" placeholder="{{ __('Search...') }}" >
                        {{--                        <span class="mdi mdi-search-web" style="font-size: 22px;position: absolute; left:90px; top:0px; color: lightgray; z-index: 9"></span>--}}
                        <div class="input-group-append">
                            <span class="mdi mdi-search-web input-group-text"></span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="card-body" style="overflow: auto">
            @php
                $attendances = $model->getActiveProgram()->getAttendances();
            @endphp

            @foreach($attendances as $attendance)
                @php
                    $training = $attendance->getTraining();
                @endphp

                @if($loop->iteration % 4 == 1)
                    <div class="row" style="height: 50%">
                @endif

                        <div class="col-md-3 h-100">
                            <div class="card shadow-sm border-left border-success h-100" style="border-width: 5px!important;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-9">
                                            <h3>{{ $training->getData()['training_name'] }}</h3>
                                            <p>{{ $training->getData()['training_short_note'] }}</p>
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
                                    <hr/>
                                    <div class="row">
                                        <div class="col-12">
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
                        </div>

                @if($loop->iteration % 4 == 0 || $loop->iteration == $attendances->count())
                    </div>
                @endif

            @endforeach

        </div>
    </div>
@endsection
@section ('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.side-nav-item').each(function(index) {
                if($(this).attr('id') == 'navTrainings' && !$(this).hasClass('mm_active')) {
                    $(this).addClass('mm_active');
                } else if($(this).attr('id') != 'navReports' && $(this).hasClass('mm_active')) {
                    $(this).removeClass('mm_active');
                }
            });
        });
    </script>
@endsection
