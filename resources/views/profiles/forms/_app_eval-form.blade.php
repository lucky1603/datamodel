<div class="container h-100">
    <form id="myAppEvalForm" method="POST" enctype='multipart/form-data' action="" class="pl-2 pr-2 h-100 evalForm" >
        @csrf
        <div class="row" >
            <div class="col-12 h-100">
                <h3 class="text-center">{{ $model->getDisplayName() }}</h3>
                <hr>
            </div>
        </div>
        <div class="row overflow-auto" >
            <div class="col-12 pt-3">
                <input type="hidden" id="id" name="id" value="{{ $id }}">
                <input type="hidden" id="programId" name="programId" value="{{ $program->getId() }}">

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

        <div class="row text-center " style="display: flex; flex-direction: row; justify-content: center; align-items: center">
            <button type="button" id="btnSaveDecision" class="btn btn-sm btn-primary ml-1"  @if($status != $validStatus) disabled @endif>{{__('gui.save')}}</button>
            <button type="button" id="btnEvalDecision" class="btn btn-sm btn-success ml-1 btnNext"  @if($status != $validStatus) disabled @endif>
                <span id="button_spinner_ok" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                <span id="button_text">{{__('gui.accept')}}</span>
            </button>
            <button type="button" id="btnRejectDecision" class="btn btn-sm btn-danger ml-1 btnNext"  @if($status != $validStatus) disabled @endif>
                <span id="button_spinner_reject" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                <span id="button_text">{{__('gui.reject')}}</span>
            </button>
        </div>
    </form>
</div>



<?php

