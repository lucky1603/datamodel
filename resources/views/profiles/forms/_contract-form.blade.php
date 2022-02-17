<div class="container h-100">
    @php
        $profile_status = $model->getValue('profile_status');
        $document  = $contract->getValue('contract_document');
        $signed_at = $contract->getValue('signed_at');
        $can_sign = $signed_at != null && $document != null && $document != ['filename' => '', 'filelink' => ''];
    @endphp
    <form id="myFormContract" method="POST" enctype='multipart/form-data' action="" class="h-100 pl-3 pr-3">
        <div class="row" >
            <div class="col-12 h-100 ">
                <h3 class="text-center">{{ __('Contract') }}</h3>
                <hr>
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
                               @if($attribute->getValue() != null) value="{{ $attribute->getValue() }}" @endif @if($profile_status == 4) disabled @endif>
                    </div>

                    @php
                        $attribute = $attributes->where('name', 'signed_at')->first();
                    @endphp

                    <label for="{{ $attribute->name }}" class="col-sm-3 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control form-control-sm" id="{{ $attribute->name }}"
                               name="{{ $attribute->name }}"
                               @if($attribute->getValue() != null) value="{{ $attribute->getValue() }}" @endif @if($profile_status == 4) disabled @endif>
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
                               @if($attribute->getValue() != null) value="{{ $attribute->getValue() }}" @endif @if($profile_status == 4) disabled @endif>
                    </div>
                    @php
                        $attribute = $attributes->where('name', 'currency')->first();
                        $value = $attribute->getValue() ?? 0;
                    @endphp
                    <label for="{{ $attribute->name }}" class="col-sm-3 attribute-label col-form-label col-form-label-sm">{!! $attribute->label !!}</label>
                    <div class="col-sm-3">
                        <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control" @if($profile_status == 4) disabled @endif>
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
                               name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" @if($profile_status == 4) disabled @endif>
                    </div>

                    <!-- Jedinica trajanja -->
                    @php
                        $attribute = $attributes->where('name', 'duration_unit')->first();
                        $value = $attribute->getValue() ?? 0;
                    @endphp
                    <label for="{{ $attribute->name }}" class="col-sm-3 attribute-label col-form-label col-form-label-sm">{!! $attribute->label !!}</label>
                    <div class="col-sm-3">
                        <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control" @if($profile_status == 4) disabled @endif>
                            <option value="0" @if( $attribute->getValue() == 0) selected @endif>Choose...</option>
                            @foreach($attribute->getOptions() as $key => $value)
                                <option value="{{$key}}" @if($key == $attribute->getValue()) selected @endif>{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    @php
                        $attribute = $attributes->where('name', 'contract_document')->first();
                    @endphp

                    @if($attribute->getValue() != null && $attribute->getValue() != ['filelink' => '', 'filename' => ''])
                        <div class="row">
                            <label class="col-sm-3 attribute-label mt-2" for="{{ $attribute->name }}">{!! $attribute->label !!}</label>
                            <div class="col-sm-9 mt-0 pt-0">
                                <a
                                    @if($profile_status < 4) style="position: relative; top: -2px"
                                    @else style="position: relative; top: 10px" @endif
                                    href="{{ $attribute->getValue()['filelink'] }}">{{ $attribute->getValue()['filename'] }}</a>
                                <i id="iconDeleteContract" class="mdi mdi-delete font-24 attribute-label ml-2 @if($profile_status == 4) d-none @endif " role="button" title="Obriši dokument"></i>
                            </div>
                        </div>
                    @endif
                    @if($attribute->getValue() == null || $attribute->getValue() == ['filelink' => '', 'filename' => ''])
                        <label class="col-form-label col-form-label-sm attribute-label mt-2">Priloži dokument ugovora</label>
                        <input type="file" class="form-control @if($profile_status == 4) d-none @endif" id="{{ $attribute->name }}" name="{{ $attribute->name }}" >
                    @endif

                </div>
                <div class="form-group @if($profile_status == 4) d-none @endif">
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


        <div class=" @if($profile_status == 4) d-none @else d-flex align-items-center justify-content-center @endif" >
                <button type="button" id="btnSaveContract" class="btn btn-sm btn-primary ml-1" @if($status != $validStatus) disabled @endif>{{__('gui.save')}}</button>
                <button type="button" id="btnCS" class="btn btn-sm btn-success btnNext ml-2" @if($status != $validStatus || !$can_sign) disabled @endif>
                    <span id="button_spinner_contract_ok" class="spinner-border spinner-border-sm ml-1" role="status" aria-hidden="true" hidden></span>
                    <span id="button_text">Na program</span>
                </button>
        </div>
    </form>

</div>


