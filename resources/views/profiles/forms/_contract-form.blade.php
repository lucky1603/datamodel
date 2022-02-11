<div class="container h-100">
    @php
        $status = $model->getValue('profile_status');
    @endphp
    <form id="myFormContract" method="POST" enctype='multipart/form-data' action="" class="h-100 pl-3 pr-3">
        <div class="row" >
            <div class="col-12 h-100 ">
                <h3 class="text-center">{{ __('Contract') }}</h3>
            </div>
        </div>
        <div class="row overflow-auto" >
            <div class="col-12 pt-3">
                @csrf
                <input type="hidden" id="contractId" name="id" value="{{ $id }}">
                <input type="hidden" id="profile" name="profile" value="{{$profile}}">

                <!-- Contract Number -->
                <div class="form-group row">
                    @php
                        $attribute = $attributes->where('name', 'contract_number')->first();
                    @endphp

                    <label for="{{ $attribute->name }}" class="col-sm-3 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}"
                               name="{{ $attribute->name }}"
                               @if($attribute->getValue() != null) value="{{ $attribute->getValue() }}" @endif disabled="{{ $status == 4 }}">
                    </div>

                    @php
                        $attribute = $attributes->where('name', 'signed_at')->first();
                    @endphp

                    <label for="{{ $attribute->name }}" class="col-sm-3 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control form-control-sm" id="{{ $attribute->name }}"
                               name="{{ $attribute->name }}"
                               @if($attribute->getValue() != null) value="{{ $attribute->getValue() }}" @endif disabled="{{ $status == 4 }}">
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
                               @if($attribute->getValue() != null) value="{{ $attribute->getValue() }}" @endif disabled="{{ $status == 4 }}">
                    </div>
                    @php
                        $attribute = $attributes->where('name', 'currency')->first();
                        $value = $attribute->getValue() ?? 0;
                    @endphp
                    <label for="{{ $attribute->name }}" class="col-sm-3 attribute-label col-form-label col-form-label-sm">{!! $attribute->label !!}</label>
                    <div class="col-sm-3">
                        <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control" disabled="{{ $status == 4 }}">
                            <option value="0" @if( $attribute->getValue() == 0) selected @endif >Choose...</option>
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
                               name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" disabled="{{ $status == 4 }}">
                    </div>

                    <!-- Jedinica trajanja -->
                    @php
                        $attribute = $attributes->where('name', 'duration_unit')->first();
                        $value = $attribute->getValue() ?? 0;
                    @endphp
                    <label for="{{ $attribute->name }}" class="col-sm-3 attribute-label col-form-label col-form-label-sm">{!! $attribute->label !!}</label>
                    <div class="col-sm-3">
                        <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control" disabled="{{ $status == 4 }}">
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
                                <input type="file" class="form-control @if($status == 4) d-none @endif" id="{{ $attribute->name }}" name="{{ $attribute->name }}" >
                            </tr>
                        </table>
                    @else
                        <input type="file" class="form-control @if($status == 4) d-none @endif" id="{{ $attribute->name }}" name="{{ $attribute->name }}">
                    @endif
                </div>
                <div class="form-group @if($status == 4) d-none @endif">
                    @php
                        $attribute = $attributes->where('name', 'passed')->first();
                        $value = $attribute->getValue() ?? false;
                    @endphp

                    <input id="{{ $attribute->name }}Hidden" type="hidden" name="{{ $attribute->name }}" value="off">
                    <span class="attribute-label mr-1">Za potpis </span>
                    <input type="checkbox" id="checkSignContract" name="{{ $attribute->name }}" @if($value) checked @endif data-switch="primary"
                     onclick="if(document.getElementById('checkSignContract').checked)
                                document.getElementById('{{ $attribute->name }}Hidden').disabled = true;
                              else
                                document.getElementById('{{ $attribute->name }}Hidden').disabled = false;
                              ">
                    <label for="checkSignContract" data-on-label="Da" data-off-label="Ne" style="top:15px"></label>
                </div>
            </div>
        </div>


        <div class="row text-center @if($status == 4) d-none @endif" >
            <div class="col-lg-6 offset-lg-4 row">
                <div class="col-lg-4">
                    <button type="button" id="btnNotifyClientContract" class="btn btn-sm btn-warning" style="width: 120px" @if( $status != $validStatus) disabled @endif>{{__('gui.notify')}}</button>
                </div>
                <div class="col-lg-4">
                    <button type="button" id="btnSaveContract" class="btn btn-sm btn-primary ml-1" @if($status != $validStatus) disabled @endif>{{__('gui.save')}}</button>
                </div>
                <div class="col-lg-4">
                    <button type="button" id="btnCS" class="btn btn-sm btn-success btnNext" @if($status != $validStatus) disabled @endif>
                        <span id="button_spinner_contract_ok" class="spinner-border spinner-border-sm ml-1" role="status" aria-hidden="true" hidden></span>
                        <span id="button_text">Na program</span>
                    </button>
                </div>
            </div>
        </div>
    </form>

</div>


