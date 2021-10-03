<div class="container h-100">
    <form id="myDemoDayForm" method="POST" enctype='multipart/form-data' action="" class="pl-2 pr-2 h-100" >
        <div class="row" style="height: 10%">
            <div class="col-12 h-100">
                <h3 class="text-center">{{ __('Demo Day') }}</h3>
            </div>
        </div>
        <div class="row overflow-auto" style="height: 75%">
            <div class="col-12 pt-3">
                @csrf
                <input type="hidden" id="id" name="id" value="{{ $id }}">
                <input type="hidden"
                       id="demoday_client_notified"
                       name="demoday_client_notified"
                       @if($notified) value="true" @else value="false" @endif>

                <div class="form-group row">
                    @php
                        $attribute = $attributes->where('name', 'demoday_date')->first();
                    @endphp

                    <label for="{{ $attribute->name }}" class="col-lg-3 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                    <div class="col-lg-4">
                        <input type="date" class="form-control form-control-sm" id="{{ $attribute->name }}"
                               name="{{ $attribute->name }}"
                               @if($attribute->getValue() != null) value="{{ $attribute->getValue() }}" @endif>
                    </div>


                </div>
                <div class="form-group">
                    @php
                        $attribute = $attributes->where('name', 'demoday_note')->first();
                        $value = $attribute->getValue() ?? null;
                    @endphp
                    <label for="{{ $attribute->name }}" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $value }}</textarea>
                </div>


            </div>
            <span class="h5 mt-2">Datoteke koje je poslao klijent</span>
            <div style="display: flex; flex-wrap: wrap; width: 100%">
                @php
                    $attribute = $attributes->where('name', 'demoday_files')->first();
                    $files = $attribute->getValue();
                @endphp
                @if($files != null)
                    @if(!isset($file['filelink']))
                        @foreach($files as $file)
                            <a href="{{ $file['filelink'] }}" target="_blank" class="mr-1">{{ $file['filename'] }}</a>
                        @endforeach
                    @else
                        <a href="{{ $files['filelink'] }}" target="_blank" class="mr-1">{{ $files['filename'] }}</a>
                    @endif
                @endif
            </div>
        </div>

        <div class="row text-center " style="height: 15%; display: flex; flex-direction: row; justify-content: center; align-items: center">
            @if(!$notified)
                <button type="button" id="btnNotifyClientDemoDay" class="btn btn-sm btn-warning h-50 w-15" @if($status != 5) disabled @endif>{{__('gui.notify')}}</button>
            @endif

            <button type="button" id="btnSaveDemoDay" class="btn btn-sm btn-primary h-50 w-15 ml-1"  @if($status != 5) disabled @endif>{{__('gui.save')}}</button>
            <button type="button" id="btnDemoDayPassed" class="btn btn-sm btn-success h-50 w-15 ml-1"  @if($status != 5) disabled @endif>
                <span id="button_spinner_ok" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                <span id="button_text">{{__('gui.accept')}}</span>
            </button>

            <button type="button" id="btnDemoDayFailed" class="btn btn-sm btn-danger h-50 w-15 ml-1"  @if($status != 5) disabled @endif>
                <span id="button_spinner_cancel" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                <span id="button_text">{{__('gui.reject')}}</span>
            </button>

        </div>


    </form>
</div>



