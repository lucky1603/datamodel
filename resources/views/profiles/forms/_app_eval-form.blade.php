<div class="container h-100">
    <form id="myAppEvalForm" method="POST" enctype='multipart/form-data' action="" class="pl-2 pr-2 h-100 evalForm" >
        @csrf
        <div class="row" style="height: 10%">
            <div class="col-12 h-100">
                <h3 class="text-center">{{ $model->getDisplayName() }}</h3>
            </div>
        </div>
        <div class="row overflow-auto" style="height: 75%">
            <div class="col-12 pt-3">
                <input type="hidden" id="id" name="id" value="{{ $id }}">
                <input type="hidden" id="profile" name="profile" value="{{ $profile }}">

                <div class="form-group row">
                    @php
                        $attribute = $attributes->where('name', 'assertion_date')->first();
                        $value = $attribute->getValue() ?? date('Y-m-d');
                    @endphp

                    <label for="{{ $attribute->name }}" class="col-lg-3 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                    <div class="col-lg-3">
                        <input
                            type="date" class="form-control form-control-sm"
                            id="{{ $attribute->name }}"
                            name="{{ $attribute->name }}"
                            value="{{ $value }}">
                    </div>

                    @php
                        $attribute = $attributes->where('name', 'passed')->first();
                        $value = $attribute->getValue() ?? 0;
                    @endphp
                    <input type="hidden" id="{{ $attribute->name }}Hidden" name="{{$attribute->name}}" value="off">

                    <div class="col-lg-3">
                        <label for="passed" class="col-form-label col-form-label-sm mr-2">{{ $attribute->label }}</label>
                        <input type="checkbox" id="{{$attribute->name}}" name="{{$attribute->name}}"
                               @if($value) checked @endif onclick="
                            if(document.getElementsById('{{ $attribute->name }}').checked) {
                            document.getElementById('{{$attribute->name}}Hidden').disabled = true;
                            } else {
                            document.getElementById('{{ $attribute->name }}Hidden').disabled = false;
                            }
                            ">
                    </div>
                </div>
                <div class="form-group">
                    @php
                        $attribute = $attributes->where('name', 'note')->first();
                        $value = $attribute->getValue() ?? null;
                    @endphp
                    <label for="{{ $attribute->name }}" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $value }}</textarea>
                </div>

            </div>

        </div>

        <div class="row text-center " style="height: 15%; display: flex; flex-direction: row; justify-content: center; align-items: center">
            <button type="button" id="btnSaveDecision" class="btn btn-sm btn-primary h-50 w-15 ml-1"  @if($status != $validStatus) disabled @endif>{{__('gui.save')}}</button>
            <button type="button" id="btnEvalDecision" class="btn btn-sm btn-success h-50 w-15 ml-1 btnNext"  @if($status != $validStatus) disabled @endif>
                <span id="button_spinner_ok" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                <span id="button_text">{{__('gui.accept')}}</span>
            </button>
        </div>
    </form>
</div>



<?php

