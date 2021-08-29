<div class="container">
    <h3 class="text-center mt-2 mb-5">{{ __('Preselection') }}</h3>

    <form id="myForm" method="POST" enctype='multipart/form-data' action=""  >
        @csrf
        <input type="hidden" id="id" name="id" value="{{ $id }}">
        <div class="form-group">
            @php
                $attribute = $attributes->where('name', 'conditions_met')->first();
                $value = $attribute->getValue() ?? false;
            @endphp

            <input id="{{ $attribute->name }}Hidden" type="hidden" name="{{ $attribute->name }}" value="off">
            <span class="attribute-label mr-1">{!! $attribute->label !!}  </span>
            <input
                class="checkbox-aligned"
                type="checkbox"
                id="{{ $attribute->name }}"
                name="{{$attribute->name}}"
                @if($value) checked @endif style="padding-top: 10px"
                onclick="
                    if(document.getElementById('{{ $attribute->name }}').checked)
                    {
                    document.getElementById('{{ $attribute->name }}Hidden').disabled = true
                    } else {
                    document.getElementById('{{ $attribute->name }}Hidden').disabled = false;
                    }
                    ">
        </div>
        <div class="form-group">
            @php
                $attribute = $attributes->where('name', 'note')->first();
                $value = $attribute->getValue() ?? null;
            @endphp
            <label for="{{ $attribute->name }}" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
            <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $value }}</textarea>
        </div>
        <div class="form-group row">
            @php
                $attribute = $attributes->where('name', 'date_of_session')->first();
            @endphp

            <label for="{{ $attribute->name }}" class="col-sm-3 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
            <div class="col-sm-3">
                <input type="date" class="form-control form-control-sm" id="{{ $attribute->name }}"
                       name="{{ $attribute->name }}"
                       @if($attribute->getValue() != null) value="{{ $attribute->getValue() }}" @endif>
            </div>

            @php
                $attribute = $attributes->where('name', 'average_mark')->first();
            @endphp

            <label for="{{ $attribute->name }}" class="col-sm-3 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
            <div class="col-sm-3">
                <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}"
                       name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}">
            </div>
        </div>
        <div class="form-group">
            @php
                $attribute = $attributes->where('name', 'additional_remark')->first();
                $value = $attribute->getValue() ?? null;
            @endphp
            <label for="{{ $attribute->name }}" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
            <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $value }}</textarea>
        </div>
        <div class="text-center" style="position: absolute; bottom: 40px; width: 90%">
            <button type="button" id="btnNotifyClientPreselection" class="btn btn-sm btn-warning presel-button" @if($status != 4) disabled @endif>{{__('gui.preselection-notify')}}</button>
            <button type="button" id="btnSavePreselection" class="btn btn-sm btn-primary presel-button"  @if($status != 4) disabled @endif>{{__('gui.preselection-save')}}</button>
            <button type="button" id="btnPreselectionPassed" class="btn btn-sm btn-success presel-button"  @if($status != 4) disabled @endif>
                <span id="button_spinner_ok" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                <span id="button_text">{{__('gui.preselection-accept')}}</span>
            </button>
            <button type="button" id="btnPreselectionFailed" class="btn btn-sm btn-danger presel-button"  @if($status != 4) disabled @endif>
                <span id="button_spinner_cancel" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                <span id="button_text">{{__('gui.preselection-reject')}}</span>
            </button>
        </div>
    </form>
</div>


