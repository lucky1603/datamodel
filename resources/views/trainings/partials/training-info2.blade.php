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
                    <h4 class="mt-0 p-1 border border-secondary shadow ">{{ $training->getData()['training_name'] }}</h4>
                </div>
                <div class="row">
                    <div class="form-group mt-3 @if(\Illuminate\Support\Facades\Auth::user()->isAdmin()) col-lg-5 @else col-lg-6 @endif">
                        <label class="attribute-label font-italic">{{__('When and where')}}</label>
                        <div class="p-1 border border-secondary shadow" style="display: flex; flex-wrap: wrap" >
                                <div class="w-25" title="datum">
                                    <i class="mdi mdi-calendar mr-1 font-16 attribute-label"></i>
                                    <span>{{ $training->getAttribute('training_start_date')->getText() }}</span>
                                </div>
                                <div class="w-25" title="Kad počinje">
                                    <i class="mdi mdi-clock-alert-outline mr-1 font-16 attribute-label"></i>
                                    <span>{{ $training->getAttribute('training_start_time')->getText() }}</span>
                                </div>
                                <div class="w-25" title="Koliko traje">
                                    <i class="mdi mdi-timer mr-1 font-16 attribute-label"></i>
                                    <span>{{ $training->getAttribute('training_duration')->getText() }}</span>
                                    <span>{{ $training->getAttribute('training_duration_unit')->getText() }}</span>
                                </div>
                                <div class="w-25" title="Lokacija">
                                    <i class="dripicons-location mr-2 attribute-label font-16"></i><span>{{ $training->getAttribute('location')->getText() }}</span>
                                </div>
                            </div>
                    </div>
                    <div class="form-group mt-3 @if(\Illuminate\Support\Facades\Auth::user()->isAdmin()) col-lg-5 @else col-lg-6 @endif">
                        <label class="attribute-label font-italic">{{ $training->getAttribute('training_host')->label }}</label>
                        <p class="mt-0 p-1 border border-secondary shadow" >{{ $training->getData()['training_host'] }}</p>
                    </div>
                    @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
                        <div class="form-group mt-3 col-lg-2">
                            @php
                                $attribute = $training->getAttributes()->where('name', 'event_status')->first();
                                $options = $attribute->getOptions();
                            @endphp
                            <label class="attribute-label font-italic" for="event_status">{{ __('Event Status') }}</label>
                            <select id="event_status" name="event_status" class="form-control">
                                <option value="0" @if($attribute->getValue() == 0) selected @endif>Izaberite ...</option>
                                @foreach($options as $key=>$value)
                                    <option value="{{ $key }}" @if($attribute->getValue() === $key) selected @endif>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                </div>

                <div class="form-group">
                    <label class="attribute-label font-italic">{{ $training->getAttribute('training_short_note')->label }}</label>
                    <p class="p-1 h-75  border border-secondary shadow">{{ $training->getData()['training_short_note'] }}</p>
                </div>
            </div>
        </div>
        <div class="row" style="height: 35%">
            <div class="col-lg-12">
                <div class="form-group h-75">
                    <label class="attribute-label font-italic">{{ $training->getAttribute('training_description')->label }}</label>
                    <div id="trainingDescription" hidden>{{ $training->getAttribute('training_description')->getValue() }}</div>
                    <div id="trainingDescriptionHtml" class="p-2 overflow-auto border border-secondary shadow" style="height: 95%"></div>
                </div>
            </div>
        </div>
        <div class="row" style="height: 15%">
            <div class="col-lg-12 h-100">
                <div class="form-group">
                    @if($training->hasFiles())
                        <label class="attribute-label font-italic">{{ __('Attached Files') }}:</label>
                        <div style="display: flex; flex-wrap: wrap; width: 100%; height: 100%" class="p-2 border border-secondary shadow">
                            @php
                                $counter = 1;
                            @endphp
                            @while($training->getAttribute('file_'.$counter) != null)
                                <div style="display: flex; background-color: #efefef; height: 45px" class="border border rounded p-1 mt-1 mr-1">
                                    @php
                                        $ext = pathinfo( $training->getValue('file_'.$counter)['filename'],PATHINFO_EXTENSION);
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
                                        <span class="w-100 font-12 font-weight-normal file-name m-auto">{{ $training->getValue('file_'.$counter)['filename'] }}</span>
                                    </div>
                                    <a href="{{ $training->getValue('file_'.$counter)['filelink'] }}" target="_blank" title="{{__('Download')}}"><div style="display: flex; background-color: white; align-items: center; height: 100%" class="float-right border rounded pl-2 pr-2"><i class="m-auto dripicons-download font-18 text-muted text-center" ></i></div></a>
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

</div>

@section('training-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            var content = $('#trainingDescription').first().text();
            $('#trainingDescriptionHtml').html(content);

        });
    </script>
@endsection
