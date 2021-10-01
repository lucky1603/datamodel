<div class="container h-100">
    <form id="myFormContract" method="POST" enctype='multipart/form-data' action="" class="h-100 pl-3 pr-3">
        <div class="row" style="height: 10%">
            <div class="col-12 h-100 ">
                <h3 class="text-center">{{ __('Contract') }}</h3>
            </div>
        </div>
        <div class="row overflow-auto" style="height: 75%;">
            <div class="col-12 pt-3">
                @csrf
                <input type="hidden" id="contractId" name="id" value="{{ $id }}">

                <!-- Contract Number -->
                <div class="form-group row">
                    @php
                        $attribute = $attributes->where('name', 'contract_number')->first();
                    @endphp

                    <label for="{{ $attribute->name }}" class="col-sm-3 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}"
                               name="{{ $attribute->name }}"
                               @if($attribute->getValue() != null) value="{{ $attribute->getValue() }}" @endif>
                    </div>

                    @php
                        $attribute = $attributes->where('name', 'signed_at')->first();
                    @endphp

                    <label for="{{ $attribute->name }}" class="col-sm-3 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control form-control-sm" id="{{ $attribute->name }}"
                               name="{{ $attribute->name }}"
                               @if($attribute->getValue() != null) value="{{ $attribute->getValue() }}" @endif>
                    </div>
                </div>

                <div class="form-group row">
                    @php
                        $attribute = $attributes->where('name', 'amount')->first();
                    @endphp
                    <label for="{{ $attribute->name }}" class="col-sm-3 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}"
                               name="{{ $attribute->name }}"
                               @if($attribute->getValue() != null) value="{{ $attribute->getValue() }}" @endif>
                    </div>
                    @php
                        $attribute = $attributes->where('name', 'currency')->first();
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
                </div>

                <div class="form-group row">
                    <!-- Trajanje -->
                    @php
                        $attribute = $attributes->where('name', 'duration')->first();
                    @endphp

                    <label for="{{ $attribute->name }}" class="col-sm-3 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}"
                               name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}">
                    </div>

                    <!-- Jedinica trajanja -->
                    @php
                        $attribute = $attributes->where('name', 'duration_unit')->first();
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
                </div>
                <div class="form-group row">
                    @php
                        $attribute = $attributes->where('name', 'contract_document')->first();
                    @endphp
                    <label for="{{ $attribute->name }}">{!! $attribute->label !!}</label>
                    @if($attribute->getValue() != null)
                        <table class="table table-responsive">
                            <tr>
                                <td><a href="{{ $attribute->getValue()['filelink'] }}">{{ $attribute->getValue()['filename'] }}</a></td>
                            </tr>
                            <tr>
                                <input type="file" class="form-control" id="{{ $attribute->name }}" name="{{ $attribute->name }}">
                            </tr>
                        </table>
                    @else
                        <input type="file" class="form-control" id="{{ $attribute->name }}" name="{{ $attribute->name }}">
                    @endif
                </div>
            </div>
        </div>


        <div class="row text-center" style="height: 15%; display: flex; flex-direction: row; justify-content: center; align-items: center">
            <button type="button" id="btnNotifyClientContract" class="btn btn-sm btn-warning w-15 h-50" @if( $status != 7) disabled @endif>{{__('gui.contract-notify')}}</button>
            <button type="button" id="btnSaveContract" class="btn btn-sm btn-primary w-15 h-50 ml-1" @if($status != 7) disabled @endif>{{__('gui.contract-save')}}</button>
            <button type="button" id="btnContractSigned" class="btn btn-sm btn-success w-15 h-50 ml-1" @if($status != 7) disabled @endif>
                <span id="button_spinner_contract_ok" class="spinner-border spinner-border-sm ml-1" role="status" aria-hidden="true" hidden></span>
                <span id="button_text">{{__('gui.contract-sign')}}</span>
            </button>
        </div>
    </form>

</div>


