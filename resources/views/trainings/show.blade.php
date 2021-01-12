@extends('layouts.hyper-vertical')

@section('content')
    <div style="width: 100%" class="shadow-sm">
        <div class="pt-1 pb-1 pl-2 pr-2 bg-white mb-0 attribute-label" style="display: table; width: 100%">
            <h4 style="display: table-column; float: left">
                @switch($training->getData()['training_type'])
                    @case(1)
                        {{ strtoupper(__('1 on 1 session'))}}
                        @break
                    @case(2)
                        {{ strtoupper(__('Workshop'))}}
                        @break
                    @case(1)
                        {{  strtoupper( __('Event'))}}
                        @break
                @endswitch
            </h4>
            <a href="{{ route('trainings') }}" class="btn btn-sm btn-dark" style="display: table-column; float: right">< {{ __('Go Back') }}</a>
            <button type="submit" class="btn btn-sm btn-success mr-1" style="display: table-column; float: right">{{ __('Save') }}</button>
        </div>
    </div>
    <div style="background-color: white; position: absolute; left: 270px; right: 10px; top: 150px; bottom: 70px; overflow-y: auto" class="shadow-sm">
        <div class="container-fluid pt-1">
            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-xl-4 text-center">
                            @switch($training->getData()['training_type'])
                                @case(1)
                                    <img src="/images/custom/oneonone.png" width="180px" class="shadow-sm p-2 pb-5 m-2"/>
                                    <p class="text-center attribute-label font-weight-bold" style="margin-top: -45px">
                                        {{ __('1 on 1 session') }}</p>
                                    @break
                                @case(2)
                                    <img src="/images/custom/workshop.png" width="180px" class="shadow-sm p-2 pb-5 m-2 "/>
                                    <p class="text-center attribute-label font-weight-bold" style="margin-top: -45px">
                                        {{ __('Workshop') }}</p>
                                    @break
                                @case(3)
                                    <img src="/images/custom/event.png" width="180px" class="shadow-sm p-2 pb-5 m-2"/>
                                    <p class="text-center attribute-label font-weight-bold" style="margin-top: -45px">
                                        {{ __('Event') }}</p>
                                    @break
                            @endswitch

                        </div>
                        <div class="col-xl-8">
                            <div class="form-group">
                                <label class="attribute-label font-italic">{{ $training->getAttribute('training_name')->label }}</label>
                                <h4 class="mt-0">{{ $training->getData()['training_name'] }}</h4>
                            </div>
                            <div class="form-group mt-3">
                                <label class="attribute-label font-italic">{{ $training->getAttribute('training_host')->label }}</label>
                                <p class="mt-0">{{ $training->getData()['training_host'] }}</p>
                            </div>
                            <div class="form-group mt-3">
                                <label class="attribute-label font-italic">{{__('When and where')}}</label>
                                <div style="display: flex; justify-content: left" >
                                    <div style="width: 30%; align-items: flex-start">
                                        <i class="mdi mdi-calendar mr-1 font-16 attribute-label"></i>
                                        <span>{{ $training->getAttribute('training_start_date')->getText() }}</span>
                                    </div>
                                    <div style="width: 30%" class="pl-1">
                                        <i class="mdi mdi-clock-alert-outline mr-1 font-16 attribute-label"></i>
                                        <span>{{ $training->getAttribute('training_start_time')->getText() }}</span>
                                    </div>
                                    <div style="width: 40%" class="pl-1">
                                        <i class="mdi mdi-timer mr-1 font-16 attribute-label"></i>
                                        <span>{{ $training->getAttribute('training_duration')->getText() }}</span>
                                        <span>{{ $training->getAttribute('duration_unit')->getText() }}</span>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <i class="dripicons-location mr-2 attribute-label font-16"></i><span>{{ $training->getAttribute('location')->getText() }}</span>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="attribute-label font-italic">{{ $training->getAttribute('training_short_note')->label }}</label>
                                <p class="mt-0">{{ $training->getData()['training_short_note'] }}</p>
                            </div>
                            <div class="form-group mt-3">
                                <label class="attribute-label font-italic">{{ $training->getAttribute('training_description')->label }}</label>
                                <div id="trainingDescription" hidden>{{ $training->getAttribute('training_description')->getValue() }}</div>
                                <div id="trainingDescriptionHtml" class="border rounded shadow-sm p-2"></div>
                            </div>
                            <div class="form-group">
                                @if($training->hasFiles())
                                    <label class="attribute-label font-italic">{{ __('Attached Files') }}:</label>
                                    <div style="display: flex; flex-wrap: wrap; width: 100%">
                                        @php
                                            $counter = 1;
                                        @endphp
                                        @while($training->getAttribute('file_'.$counter) != null)
                                            <div style="display: flex; background-color: #efefef" class="border border rounded p-1 mt-1 mr-1 file-info">
                                                @php
                                                    $ext = pathinfo( $training->getData()['file_'.$counter]['filename'],PATHINFO_EXTENSION);
                                                    $color = 'transparent';
                                                    switch($ext) {
                                                        case 'xlsx':
                                                            $color = 'green';
                                                            break;
                                                        case 'docx':
                                                            $color = 'darkblue';
                                                            break;
                                                        case 'pdf':
                                                            $color = 'red';
                                                            break;
                                                        default:
                                                            $color = 'gray';
                                                            break;
                                                    }

                                                @endphp
                                                <div style="width: 45px; height:40px; align-items: center; display: flex; background-color: {{ $color }}"
                                                     class="text-light float-left font-18 rounded text-center">
                                                    <span class="m-auto file-ext">.{{ $ext }}</span>
                                                </div>
                                                <div style="display: flex; flex-direction: column; margin: 0 15px" class="flex-fill">
                                                    <span class="w-100 font-18 font-weight-bold file-name m-auto">{{ $training->getData()['file_'.$counter]['filename'] }}</span>
                                                </div>
                                                <a href="{{ $training->getData()['file_'.$counter]['filelink'] }}" target="_blank" title="{{__('Download')}}"><div style="display: flex; background-color: white; align-items: center; height: 100%" class="float-right border rounded pl-2 pr-2"><i class="m-auto dripicons-download font-18 text-muted text-center" ></i></div></a>
                                            </div>
                                            @php
                                                $counter ++;
                                            @endphp

                                        @endwhile

                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6" style="position: relative;">
                    <div>
                        <h3 class="text-center">{{ __('Attendees') }}</h3>
                    </div>
                    @if($training->getData()['training_type'] != 1)
                    <p>
                        <b>{{__('TARGET GROUP')}}  :  </b>
                        @if($training->getData()['interests'] == 0)
                            {{__("EVERYONE")}}
                        @else
                            {{ $training->getAttribute('interests')->getText() }}
                        @endif
                    </p>
                    @endif
                    <table id="myTable" class="table table-sm table-bordered shadow" style="height: 300px">
                        <thead class="bg-dark text-light">
                            <tr>
                                  <th>{{__('Client')}}</th>
                                  <th class="text-center">{{__('Status')}}</th>
                                  <th class="text-center">{{__('Has feedback')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($training->getClients() as $client)
                            <tr>
                                <td><img src="{{ $client->getData()['logo']['filelink'] }}" class="mr-1 img-fluid avatar-xs rounded-circle">{{ $client->getData()['name'] }}</td>
                                <td class="text-center">
                                    <span class="badge badge-pill @switch($client->attendance)
                                        @case(1) badge-secondary-lighten @break
                                        @case(2) badge-danger-lighten @break
                                        @case(3) badge-success-lighten @break
                                        @case(4) badge-danger-lighten @break @endswitch">
                                        {{ $client->getAttendanceText() }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    @if($client->has_feedback == 0)
                                        <img src="/images/custom/user-no-feedback.png" class="img-fluid avatar-xs">
                                    @else
                                        <img src="/images/custom/user-feedback.png" class="img-fluid avatar-xs">
                                    @endif

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var content = $('#trainingDescription').first().text();
            $('#trainingDescriptionHtml').html(content);

            $('#myTable').dataTable({
                sorting: false,
            });
        });
    </script>
@endsection

@section('sidemenu')
    <li class="side-nav-item">
        <a href="{{ route('trainings') }}" class="side-nav-link">
            <i class="uil-laptop-cloud"></i>
            <span>{{ strtoupper(__('Back to Sessions')) }}</span>
        </a>
    </li>
@endsection
