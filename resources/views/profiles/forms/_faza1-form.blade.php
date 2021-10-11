<div class="container h-100">
    <form id="myFaza1Form" method="POST" enctype='multipart/form-data' action="" class="pl-2 pr-2 h-100" >
        <div class="row" style="height: 10%">
            <div class="col-12 h-100">
                <h3 class="text-center">Faza 1</h3>
            </div>
        </div>
        <div class="row overflow-auto" style="height: 75%">
            <div class="col-12 pt-3">
                @csrf
                <input type="hidden" id="id" name="id" value="{{ $id }}">
                <input type="hidden" id="profile" name="profile" value="{{ $profile }}">

                <div class="form-group row">
                    @php
                        $attribute = $attributes->where('name', 'due_date')->first();
                    @endphp

                    <label for="{{ $attribute->name }}" class="col-lg-3 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                    <div class="col-lg-4">
                        <input type="date" class="form-control form-control-sm" id="{{ $attribute->name }}"
                               name="{{ $attribute->name }}"
                               @if($attribute->getValue() != null) value="{{ $attribute->getValue() }}" @endif>
                    </div>
                    @php
                        $attribute = $attributes->where('name', 'passed')->first();
                        $value = $attribute->getValue() ?? false;
                    @endphp
                    <input type="hidden" id="{{ $attribute->name }}Hidden" name="{{ $attribute->name }}" value="off">
                    <label for="passed" class="col-form-label col-form-label-sm mr-2 attribute-label">{{ $attribute->label }}</label>
                    <input
                        type="checkbox"
                        id="{{ $attribute->name }}"
                        name="{{ $attribute->name }}" style="top:9px; position: relative"
                        @if($value) checked @endif
                        onclick="
                        if(document.getElementById('{{ $attribute->name }}').checked) {
                            document.getElementById('{{ $attribute->name }}Hidden').disabled = true;
                        } else {
                            document.getElementById('{{ $attribute->name }}Hidden').disabled = false;
                        }
                        ">

                </div>
                <div class="form-group row">
                    @php
                        $attribute = $attributes->where('name', 'short_note')->first();
                        $value = $attribute->getValue() ?? null;
                    @endphp
                    <div class="col-lg-12">
                        <label for="{{ $attribute->name }}" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                        <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $value }}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <label class="col-form-label col-form-label-sm attribute-label">Datoteke koje je poslao klijent</label>
                        @php
                            $filesSent = $attributes->where('name', 'files_sent')->first();
                        @endphp
                        @if($filesSent->getValue())
                            <div class="mt-1 bg-light">
                                @php
                                    $requested_files = $attributes->where('name','requested_files')->first();
                                    $files = $requested_files->getValue();
                                    $filecount = 0;
                                    if($files != null && is_array($files)) {
                                        if(count($files) == 2 && isset($files['filelink']))
                                        {
                                            $filecount = 1;
                                        }
                                        else {
                                            $filecount = count($files);
                                        }
                                    }
                                @endphp
                                @if($filecount == 1)
                                    <a href="{{ $files['filelink'] }}" target="_blank">{{$files['filename']}}</a>
                                @else
                                    @foreach($files as $file)
                                        <a href="{{ $file['filelink'] }}" target="_blank" class="mr-2">{{ $file['filename'] }}</a>
                                    @endforeach
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row text-center " style="height: 15%; display: flex; flex-direction: row; justify-content: center; align-items: center">

            <button type="button" id="btnSaveFaza1" class="btn btn-sm btn-primary h-50 w-15 ml-1"  @if($status != $validStatus) disabled @endif>{{__('gui.save')}}</button>
            <button type="button" id="btnFaza1Passed" class="btn btn-sm btn-success h-50 w-15 ml-1"  @if($status != $validStatus) disabled @endif>
                <span id="button_spinner_ok" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                <span id="button_text">{{__('gui.accept')}}</span>
            </button>

        </div>


    </form>
</div>



<?php
