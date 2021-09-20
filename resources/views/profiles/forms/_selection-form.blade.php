<div class="container h-100">
    <form id="myFormSelection" method="POST" enctype='multipart/form-data' action="" class="p-2 h-100">
        <div class="row" style="height: 10%">
            <div class="col-12">
                <h3 class="text-center">{{ __('Selection') }}</h3>
            </div>
        </div>
        <div class="row overflow-auto" style="height: 75%">
            <div class="col-12">
                @csrf
                <input type="hidden" id="selectionId" name="id" value="{{ $id }}">

                <!-- Datum selekcije -->
                <div class="form-group row">
                    @php
                        $attribute = $attributes->where('name', 'selection_date')->first();
                    @endphp

                    <label for="{{ $attribute->name }}" class="col-sm-3 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control form-control-sm" id="{{ $attribute->name }}"
                               name="{{ $attribute->name }}"
                               @if($attribute->getValue() != null) value="{{ $attribute->getValue() }}" @endif>
                    </div>
                </div>

                <!-- Beleske sa sastanka -->
                <div class="form-group">
                    @php
                        $attribute = $attributes->where('name', 'meeting_notes')->first();
                        $value = $attribute->getValue() ?? null;
                    @endphp
                    <label for="{{ $attribute->name }}" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $value }}</textarea>
                </div>

                <div class="form-group row">
                    <!-- Stepen ispunjenosti -->
                    @php
                        $attribute = $attributes->where('name', 'fulfillment_grade')->first();
                        $value = $attribute->getValue() ?? 0;
                    @endphp
                    <label for="{{ $attribute->name }}" class="col-sm-3 attribute-label col-form-label col-form-label-sm">{!! $attribute->label !!}</label>
                    <div class="col-sm-3">
                        <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control">
                            <option value="0" @if( $attribute->getValue() == 0) selected @endif>Choose...</option>
                            @foreach($attribute->getOptions() as $key => $value)
                                <option value="{{$key}}" @if($key == $attribute->getValue()) selected @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Prosecna ocena -->
                    @php
                        $attribute = $attributes->where('name', 'average_mark_selection')->first();
                    @endphp

                    <label for="{{ $attribute->name }}" class="col-sm-3 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}"
                               name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}">
                    </div>
                </div>
            </div>
        </div>


        <div class="row text-center" style="height: 15%; display: flex; flex-direction: row; justify-content: center; align-items: center">
            <button type="button" id="btnNotifyClientSelection" class="btn btn-sm btn-warning h-50 w-15" @if($status != 5) disabled @endif>{{__('gui.selection-notify')}}</button>
            <button type="button" id="btnSaveSelection" class="btn btn-sm btn-primary h-50 w-15 ml-1" @if($status != 5) disabled @endif>{{__('gui.selection-save')}}</button>
            <button type="button" id="btnSelectionPassed" class="btn btn-sm btn-success h-50 w-15 ml-1" @if($status != 5) disabled @endif>
                <span id="button_spinner_sel_ok" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                <span id="button_text">{{__('gui.selection-accept')}}</span>
            </button>
            <button type="button" id="btnSelectionFailed" class="btn btn-sm btn-danger h-50 w-15 ml-1" @if($status != 5) disabled @endif>
                <span id="button_spinner_sel_cancel" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                <span id="button_text">{{__('gui.selection-reject')}}</span>
            </button>
        </div>
    </form>
</div>


