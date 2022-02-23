<div class="container h-100">
    @php
        $profile = \App\Business\Profile::find($profileId);
        $profile_status = $profile->getValue('profile_status');
    @endphp
    <form id="myFaza1Form" method="POST" enctype='multipart/form-data' action="" class="pl-2 pr-2 h-100" >
        <div class="row">
            <div class="col-12 h-100">
                <h3 class="text-center">Faza 1</h3>
                <hr>
            </div>
        </div>

        <div class="row overflow-auto" >
            <div class="col-12 pt-3">
                @csrf
                <input type="hidden" id="id" name="id" value="{{ $id }}">
                <input type="hidden" id="profile" name="profile" value="{{ $profileId }}">
                @if($phase->getValue('due_date') != NULL)
                    <div class="form-group row">
                        @php
                            $attribute = $attributes->where('name', 'due_date')->first();
                        @endphp

                        <label for="{{ $attribute->name }}" class="col-lg-3 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                        <div class="col-lg-4">
                            <input type="date" class="form-control form-control-sm" id="{{ $attribute->name }}"
                                   name="{{ $attribute->name }}" @if($profile_status == 4) disabled @endif
                                   @if($attribute->getValue() != null) value="{{ $attribute->getValue() }}" @endif>
                        </div>

                    </div>
                    <div class="form-group row">
                        @php
                            $attribute = $attributes->where('name', 'short_note')->first();
                            $value = $attribute->getValue() ?? null;
                        @endphp
                        <div class="col-lg-12">
                            <label for="{{ $attribute->name }}" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                            <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3" @if($profile_status == 4) disabled @endif>{{ $value }}</textarea>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-12">
                            <label class="col-form-label col-form-label-sm attribute-label">Datoteke koje je poslao klijent</label>
                            @php
                                $filesSent = $attributes->where('name', 'files_sent')->first();
                            @endphp
                            @if($filesSent->getValue())
                                <div class="mt-1">
                                    @php
                                        $requested_files = $attributes->where('name','requested_files')->first();
                                        $files = $requested_files->getValue();
                                    @endphp
                                    @if($requested_files->extra != 'multiple')
{{--                                        <a href="{{ $files['filelink'] }}" target="_blank">{{$files['filename']}}</a>--}}
                                        <file-item filename="{{ $file['filename'] }}" filelink="{{ $file['filelink'] }}" :fontsize="14"></file-item>
                                    @else
                                        @foreach($files as $file)
{{--                                            <a href="{{ $file['filelink'] }}" target="_blank" class="mr-2">{{ $file['filename'] }}</a>--}}
                                            <file-item filename="{{ $file['filename'] }}" filelink="{{ $file['filelink'] }}" :fontsize="14"></file-item>
                                        @endforeach
                                    @endif
                                </div>
                            @else
                                <div class="text-center mb-4">
                                    <h5>Klijent još nije poslao datoteke.</h5>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <p class="mt-2 mb-4">
                        Odredite datum do kojeg je potrebno poslati fajlove. Kada podesite i sačuvate vrednost datuma,
                        stranka će biti obaveštena o fajlovima i događajima kojima je neophodno prisustvovati kako bi
                        se zadovoljili svi uslovi.
                    </p>
                    <div class="form-group row mb-4">
                        @php
                            $attribute = $attributes->where('name', 'due_date')->first();
                        @endphp
                        <input type="hidden" name="passed" value="off">
                        <label for="{{ $attribute->name }}" class="col-lg-3 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                        <div class="col-lg-4">
                            <input type="date" class="form-control form-control-sm" id="{{ $attribute->name }}"
                                   name="{{ $attribute->name }}"
                                   @if($attribute->getValue() != null) value="{{ $attribute->getValue() }}" @endif>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="row text-center @if($profile_status < 4) d-flex align-items-center justify-content-center @else d-none @endif" >
            <button type="button" id="btnSaveFaza1" class="btn btn-sm btn-primary ml-1"  @if($status != $validStatus) disabled @endif>{{__('gui.save')}}</button>
            <button type="button" id="btnFaza1Passed" class="btn btn-sm btn-success ml-1"  @if($status != $validStatus || !$phase->isValid()) disabled @endif>
                <span id="button_spinner_ok" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                <span id="button_text">{{__('gui.accept')}}</span>
            </button>
            <button type="button" id="btnFaza1Rejected" class="btn btn-sm btn-danger ml-1 btnNext"  @if($status != $validStatus) disabled @endif>
                <span id="button_spinner_reject" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                <span id="button_text">{{__('gui.reject')}}</span>
            </button>
        </div>
    </form>
</div>



<?php
