@extends('layouts.hyper-vertical')

@section('content')
    <div style="width: 100%" class="shadow-sm">
        <div class="pt-1 pb-1 pl-2 pr-2 bg-white mb-0" style="display: table; width: 100%">
            <h4 style="display: table-column; float: left">{{ $training->getData()['training_name'] }}</h4>
            <a href="{{ route('trainings') }}" class="btn btn-sm btn-dark" style="display: table-column; float: right">< {{ __('Go Back') }}</a>
            <button type="submit" class="btn btn-sm btn-success mr-1" style="display: table-column; float: right">{{ __('Save') }}</button>
        </div>
    </div>
    <div style="background-color: white; position: absolute; left: 270px; right: 10px; top: 150px; bottom: 70px; overflow-y: auto" class="shadow-sm">
        <div class="container-fluid pt-1">
            <div class="row">
                <div class="col-sm-6 border-right border-secondary">
                    <div class="row">
                        <div class="col-sm-4">
                            @switch($training->getData()['training_type'])
                                @case(1)
                                    <img src="/images/custom/oneonone.png" width="200px" class="shadow-sm p-2 m-2"/>
                                    @break
                                @case(2)
                                    <img src="/images/custom/workshop.png" width="200px" class="shadow-sm p-2 m-2"/>
                                    @break
                                @case(3)
                                    <img src="/images/custom/event.png" width="200px" class="shadow-sm p-2 m-2"/>
                                    @break
                            @endswitch

                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label class="attribute-label font-italic">{{ $training->getAttribute('training_name')->label }}</label>
                                <h4 class="mt-0">{{ $training->getData()['training_name'] }}</h4>
                            </div>
                            <div class="form-group mt-3">
                                <label class="attribute-label font-italic">{{ $training->getAttribute('training_host')->label }}</label>
                                <h4 class="mt-0">{{ $training->getData()['training_host'] }}</h4>
                            </div>
                            <div class="form-group mt-3">
                                <label class="attribute-label font-italic">{{__('When and where')}}</label>
                                <div style="display: flex; justify-content: left" >
                                    <div style="width: 30%; align-items: flex-start">
                                        <i class="mdi mdi-calendar mr-1 font-16 attribute-label"></i>
                                        <span class="font-weight-bold">{{ $training->getAttribute('training_start_date')->getText() }}</span>
                                    </div>
                                    <div style="width: 30%" class="pl-1">
                                        <i class="mdi mdi-clock-alert-outline mr-1 font-16 attribute-label"></i>
                                        <span class="font-weight-bold">{{ $training->getAttribute('training_start_time')->getText() }}</span>
                                    </div>
                                    <div style="width: 40%" class="pl-1">
                                        <i class="mdi mdi-timer mr-1 font-16 attribute-label"></i>
                                        <span class="font-weight-bold">{{ $training->getAttribute('training_duration')->getText() }}</span>
                                        <span class="font-weight-bold">{{ $training->getAttribute('duration_unit')->getText() }}</span>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <i class="dripicons-location mr-2 attribute-label font-16"></i><span class="font-weight-bold">{{ $training->getAttribute('location')->getText() }}</span>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="attribute-label font-italic">{{ $training->getAttribute('training_short_note')->label }}</label>
                                <h4 class="mt-0">{{ $training->getData()['training_short_note'] }}</h4>
                            </div>
                            <div class="form-group mt-3">
                                <label class="attribute-label font-italic">{{ $training->getAttribute('training_description')->label }}</label>
                                <div id="trainingDescription" hidden>{{ $training->getAttribute('training_description')->getValue() }}</div>
                                <div id="trainingDescriptionHtml" class="border rounded shadow-sm p-2"></div>
                            </div>
                            <div class="form-group">
                                <label class="attribute-label font-italic">{{ __('Attached Files:') }}</label>
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

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">

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
        });
    </script>
@endsection
