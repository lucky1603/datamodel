<div class="container h-100">
    <form id="myForm" method="POST" enctype='multipart/form-data' action="" class="pl-2 pr-2 h-100" >
        <div class="row" style="height: 10%">
            <div class="col-12 h-100">
                <h3 class="text-center">{{ __('Preselection') }}</h3>
            </div>
        </div>
        <div class="row overflow-auto" style="height: 75%">
            <div class="col-12 pt-3">
                @csrf
                <input type="hidden" id="id" name="id" value="{{ $id }}">
                <input type="hidden" id="profile" name="profile" value="{{ $profile }}">

                <div class="form-group">
                    @php
                        $attribute = $attributes->where('name', 'passed')->first();
                        $value = $attribute->getValue() ?? false;
                    @endphp

                    <input id="{{ $attribute->name }}Hidden" type="hidden" name="{{ $attribute->name }}" value="off">
                    <span class="attribute-label mr-1">{!! $attribute->label !!}  </span>

                    <!-- Bool Switch-->
                    <input type="checkbox" id="{{ $attribute->name }}" name="{{ $attribute->name }}" @if($value) checked @endif data-switch="primary"
                    onclick="if(document.getElementById('{{ $attribute->name }}').checked) {
                        document.getElementById('{{$attribute->name}}Hidden').disabled = true;
                    } else {
                        document.getElementById('{{$attribute->name}}Hidden').disabled = false;
                    }" >
                    <label for="{{ $attribute->name }}" data-on-label="Da" data-off-label="Ne" style="top: 15px"></label>
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
            </div>




        </div>

        <div class="row text-center " style="height: 15%; display: flex; flex-direction: row; justify-content: center; align-items: center">

                <button type="button" id="btnNotifyClientPreselection" class="btn btn-sm btn-warning h-50 w-15" @if($status != $validStatus) disabled @endif>{{__('gui.notify')}}</button>

                <button type="button" id="btnSavePreselection" class="btn btn-sm btn-primary h-50 w-15 ml-1"  @if($status != $validStatus) disabled @endif>{{__('gui.save')}}</button>

                <button type="button" id="btnNext" class="btn btn-sm btn-success h-50 w-15 ml-1 btnNext"  @if($status != $validStatus) disabled @endif>
                    <span id="button_spinner_ok" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                    <span id="button_text">{{__('gui.accept')}}</span>
                </button>

        </div>


    </form>
</div>


