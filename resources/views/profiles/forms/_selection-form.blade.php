<div class="container">
    <h3 class="text-center m-2">{{ __('Selection') }}</h3>

    <form id="myForm" method="POST" enctype='multipart/form-data' action="">
        @csrf
        <input type="hidden" id="id" name="id" value="{{ $id }}">

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

        <div class="text-center mt-5">
            <button type="button" id="btnNotifyClientSelection" class="btn btn-sm btn-warning presel-button">{{__('gui.preselection-notify')}}</button>
            <button type="button" id="btnSaveSelection" class="btn btn-sm btn-primary presel-button">{{__('gui.preselection-save')}}</button>
            <button type="button" id="btnSelectionPassed" class="btn btn-sm btn-success presel-button">{{__('gui.preselection-accept')}}</button>
            <button type="button" id="btnSelectionFailed" class="btn btn-sm btn-danger presel-button">{{__('gui.preselection-reject')}}</button>
        </div>
    </form>
</div>


