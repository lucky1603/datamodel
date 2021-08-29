<div class="container">
    <h3 class="text-center mt-2 mb-5">{{ __('Selection') }}</h3>

    <form id="myFormSelection" method="POST" enctype='multipart/form-data' action="">
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

        <div class="text-center" style="position: absolute; bottom: 40px; width: 90%">
            <button type="button" id="btnNotifyClientSelection" class="btn btn-sm btn-warning presel-button" @if($status != 5) disabled @endif>{{__('gui.selection-notify')}}</button>
            <button type="button" id="btnSaveSelection" class="btn btn-sm btn-primary presel-button" @if($status != 5) disabled @endif>{{__('gui.selection-save')}}</button>
            <button type="button" id="btnSelectionPassed" class="btn btn-sm btn-success presel-button" @if($status != 5) disabled @endif>
                <span id="button_spinner_sel_ok" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                <span id="button_text">{{__('gui.selection-accept')}}</span>
            </button>
            <button type="button" id="btnSelectionFailed" class="btn btn-sm btn-danger presel-button" @if($status != 5) disabled @endif>
                <span id="button_spinner_sel_cancel" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                <span id="button_text">{{__('gui.selection-reject')}}</span>
            </button>
        </div>
    </form>
</div>


