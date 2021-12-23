<div class="row h-100" >
    <div class="col-lg-12 h-100">
        <div class="row h-50 overflow-hidden">
            <div class="col-lg-2" style="height: 95%">
                @switch($training->getData()['training_type'])
                    @case(1)
                    <img src="/images/custom/workshop1.png" class="shadow-sm p-2 pb-5 w-100"/>
                    <p class="text-center attribute-label font-weight-bold" style="position: relative; top: -45px">
                        {{ __('Workshop') }}</p>
                    @break
                    @case(2)
                    <img src="/images/custom/training.png" class="shadow-sm p-2 pb-5 m-2 w-100"/>
                    <p class="text-center attribute-label font-weight-bold" style="margin-top: -45px">
                        {{ __('Training') }}</p>
                    @break
                    @case(3)
                    <img src="/images/custom/meeting.png" class="shadow-sm p-2 pb-5 m-2 w-100"/>
                    <p class="text-center attribute-label font-weight-bold" style="margin-top: -45px">
                        {{ __('Event') }}</p>
                    @break
                @endswitch

            </div>
            <div class="col-lg-10 h-100">
                <div class="form-group">
                    <label class="attribute-label font-italic">{{ $training->getAttribute('training_name')->label }}</label>
                    <h4 class="mt-0 p-2 event-entry border">{{ $training->getData()['training_name'] }}</h4>
                </div>
                <div class="row">
                    <div class="form-group mt-3 col-lg-5">
                        <label class="attribute-label font-italic">{{__('When and where')}}</label>
                        <div class="p-1 border event-entry" style="display: flex; flex-wrap: wrap" >
                                <div class="mr-3" title="datum">
                                    <i class="mdi mdi-calendar mr-1 font-16 attribute-label"></i>
                                    <span>{{ $training->getAttribute('training_start_date')->getText() }}</span>
                                </div>
                                <div class="mr-3" title="Kad počinje">
                                    <i class="mdi mdi-clock-alert-outline mr-1 font-16 attribute-label"></i>
                                    <span>{{ $training->getAttribute('training_start_time')->getText() }}</span>
                                </div>
                                <div class="mr-3" title="Koliko traje">
                                    <i class="mdi mdi-timer mr-1 font-16 attribute-label"></i>
                                    <span>{{ $training->getAttribute('training_duration')->getText() }}</span>
                                    <span>{{ $training->getAttribute('training_duration_unit')->getText() }}</span>
                                </div>
                                <div class="mr-3" title="Lokacija">
                                    <i class="dripicons-location mr-2 attribute-label font-16"></i><span>{{ $training->getAttribute('location')->getText() }}</span>
                                </div>
                            </div>
                    </div>
                    <div class="form-group mt-3 col-lg-5 ">
                        <label class="attribute-label font-italic">{{ $training->getAttribute('training_host')->label }}</label>
                        <p class="mt-0 p-1 border event-entry" >{{ $training->getData()['training_host'] }}</p>
                    </div>

                    <div class="form-group mt-3 col-lg-2">
                        @php
                            $attribute = $training->getAttributes()->where('name', 'event_status')->first();
                            $options = $attribute->getOptions();
                        @endphp
                        <label class="attribute-label font-italic" for="event_status">{{ __('Event Status') }}</label>
                        @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                            <select id="event_status" name="event_status" class="form-control">
                                <option value="0" @if($attribute->getValue() == 0) selected @endif>Izaberite ...</option>
                                @foreach($options as $key=>$value)
                                    <option value="{{ $key }}" @if($attribute->getValue() === $key) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        @else
                            <span class="form-control">
                                {{ $attribute->getText() }}
                                <i class="@switch($attribute->getValue())
                                @case(1)
                                    dripicons-checklist
                                    @break
                                @case(2)
                                    dripicons-hourglass
                                    @break
                                @case(3)
                                    dripicons-checkmark
                                    @break
                                @default
                                    dripicons-trash
                                    @break
                                         @endswitch ml-2"></i>
                            </span>
                        @endif
                    </div>

                </div>

                <div class="form-group">
                    <label class="attribute-label font-italic">{{ $training->getAttribute('training_short_note')->label }}</label>
                    <p class="p-1 h-75  border event-entry">{{ $training->getData()['training_short_note'] }}</p>
                </div>
            </div>
        </div>
        <div class="row" style="height: 35%">
            <div class="col-lg-12">
                <div class="form-group h-75">
                    <label class="attribute-label font-italic">{{ $training->getAttribute('training_description')->label }}</label>
                    <div id="trainingDescription" hidden>{{ $training->getAttribute('training_description')->getValue() }}</div>
                    <div id="trainingDescriptionHtml" class="p-2 overflow-auto border event-entry" style="height: 95%"></div>
                </div>
            </div>
        </div>
        <div class="row" style="height: 15%">
            <div class="col-lg-12 h-100">
                <div class="form-group">
                    @if($training->hasFiles())
                        <label class="attribute-label font-italic">{{ __('Attached Files') }}:</label>
                        <div style="display: flex; flex-wrap: wrap; width: 100%; height: 100%" class="p-2 border event-entry">
                            @php
                                $counter = 1;
                                $files = $training->getValue('files');
                            @endphp

                            @foreach($files as $file)
                                <div style="display: flex; background-color: #efefef; height: 45px" class="border border rounded p-1 mt-1 mr-1">
                                    @php
                                        $ext = pathinfo( $file['filename'],PATHINFO_EXTENSION);
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

                                    <div style="width: 45px; height:30px; align-items: center; display: flex; background-color: {{ $color }}"
                                         class="text-light float-left font-12 rounded text-center">
                                        <span class="m-auto file-ext">.{{ $ext }}</span>
                                    </div>
                                    <div style="display: flex; flex-direction: column; margin: 0 15px" class="flex-fill">
                                        <span class="w-100 font-12 font-weight-normal file-name m-auto">{{ $file['filename'] }}</span>
                                    </div>
                                    <a href="{{ $file['filelink'] }}" target="_blank" title="{{__('Download')}}"><div style="display: flex; background-color: white; align-items: center; height: 100%" class="float-right border rounded pl-2 pr-2"><i class="m-auto dripicons-download font-18 text-muted text-center" ></i></div></a>
                                </div>
                            @endforeach

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>

@section('training-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var content = $('#trainingDescription').first().text();
            $('#trainingDescriptionHtml').html(content);

        });
    </script>
@endsection
