<form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="myForm" class="mt-4">
    @csrf


    <div class="row">
        <div id="nameCol" class="col-lg-6">
            @if(isset($profile))
                <input type="hidden" id="profileid" name="profileid" value="{{ $profile->getId() }}">
            @endif
            <div class="form-group">
                @php
                    $attribute = $attributes->where('name', 'name')->first();
                @endphp
                <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() ?? old($attribute->name) }}"
                       class="form-control form-control-sm @error('name') is-invalid @enderror">
                @error('name') <div class="alert alert-danger">{{ $message }}</div>@enderror
            </div>
        </div>
        <div id="idNumberCol" class="col-lg-6">
            <div class="form-group" id="id_number_group">
                @php
                    $attribute = $attributes->where('name', 'id_number')->first();
                @endphp
                <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() ?? old($attribute->name)}}"
                       class="form-control form-control-sm @error($attribute->name) is-invalid @enderror">
                @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <div class="form-group">
        @php
            $attribute = $attributes->where('name', 'is_company')->first();
        @endphp

        <input id="{{ $attribute->name }}Hidden" type="hidden" name="{{ $attribute->name }}" value="off">
        <span class="attribute-label mr-1">{!! $attribute->label !!}  </span>
        <input
            class="checkbox-aligned"
            type="checkbox"
            id="{{ $attribute->name }}"
            name="{{$attribute->name}}"
            @if($attribute->getValue()  ?? old($attribute->name)) checked @endif style="padding-top: 10px"
            onclick="
                if(document.getElementById('{{ $attribute->name }}').checked)
                {
                document.getElementById('{{ $attribute->name }}Hidden').disabled = true
                } else {
                document.getElementById('{{ $attribute->name }}Hidden').disabled = false;
                }
                ">
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="form-group">
                @php
                    $attribute = $attributes->where('name', 'contact_person')->first();
                @endphp
                <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() ?? old($attribute->name) }}"
                       class="form-control form-control-sm @error($attribute->name) is-invalid @enderror">
                @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror

            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                @php
                    $attribute = $attributes->where('name', 'contact_email')->first();
                @endphp
                <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                <input type="email"
                       class="form-control form-control-sm @error($attribute->name) is-invalid @enderror"
                       id="{{ $attribute->name }}"
                       name="{{$attribute->name}}"
                       value="{{ $attribute->getValue() ?? old($attribute->name) }}"
                       autocomplete="{{ $attribute->name }}" >
                @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="col-lg-4">
            <div class="form-group">
                @php
                    $attribute = $attributes->where('name', 'contact_phone')->first();
                @endphp
                <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() ?? old($attribute->name)}}"
                       class="form-control form-control-sm @error($attribute->name) is-invalid @enderror">
                @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <div class="form-group">
        @php
            $attribute = $attributes->where('name', 'address')->first();
        @endphp
        <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
        <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() ?? old($attribute->name) }}"
               class="form-control form-control-sm @error($attribute->name) is-invalid @enderror">
        @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        @php
            $attribute = $attributes->where('name', 'profile_webpage')->first();
        @endphp
        <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
        <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() ?? old($attribute->name) }}"
               class="form-control form-control-sm @error($attribute->name) is-invalid @enderror">
        @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        @php
            $attribute = $attributes->where('name', 'profile_logo')->first();
        @endphp
        <label for="{{$attribute->name}}" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
        <input type="file" id="{{ $attribute->name }}" name="{{ $attribute->name }}"
               class="form-control form-control-file @error($attribute->name) is-invalid @enderror">
        @if($attribute->getValue() != null && $attribute->getValue()['filelink'] != '')
            <a href="{{ $attribute->getValue()['filelink'] }}" target="_blank">
                {{ $attribute->getValue()['filename'] }}
            </a
        @endif
        @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        @php
            $attribute = $attributes->where('name', 'profile_background')->first();
        @endphp
        <label for="{{$attribute->name}}" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
        <input type="file" id="{{ $attribute->name }}" name="{{ $attribute->name }}" class="form-control form-control-file">
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="form-group">
                @php
                    $attribute = $attributes->where('name', 'university')->first();
                    $selectedValue = $attribute->getValue() ?? old($attribute->name);
                @endphp
                <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control @error($attribute->name) is-invalid @enderror">
                    <option value="0" @if($selectedValue == 0) selected @endif>Choose...</option>
                    @foreach($attribute->getOptions() as $key => $value)
                        <option value="{{$key}}" @if($selectedValue == $key) selected @endif>{{$value}}</option>
                    @endforeach
                </select>
                @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group">
                @php
                    $attribute = $attributes->where('name', 'business_branch')->first();
                    $selectedValue = $attribute->getValue() ?? old($attribute->name);
                @endphp
                <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
                <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control @error($attribute->name) is-invalid @enderror">
                    <option value="0" @if($selectedValue == 0) selected @endif>Choose...</option>
                    @foreach($attribute->getOptions() as $key => $value)
                        <option value="{{$key}}" @if($selectedValue == $key) selected @endif>{{$value}}</option>
                    @endforeach
                </select>
                @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
            </div>
        </div>
    </div>

    <div class="form-group">
        @php
            $attribute = $attributes->where('name', 'short_ino_desc')->first();
        @endphp
        <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
        <textarea class="form-control @error($attribute->name) is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3"></textarea>
        @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
    </div>

    <div class="form-group">
        @php
            $attribute = $attributes->where('name', 'reason_contact')->first();
            $selectedValue = $attribute->getValue() ?? old($attribute->name);
        @endphp
        <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
        <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control @error($attribute->name) is-invalid @enderror">
            <option value="0" @if($selectedValue == 0) selected @endif>Choose...</option>
            @foreach($attribute->getOptions() as $key => $value)
                <option value="{{$key}}" @if($selectedValue == $key) selected @endif>{{$value}}</option>
            @endforeach
        </select>
        @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div>@enderror
    </div>
    <div class="form-group">
        @php
            $attribute = $attributes->where('name', 'note')->first();
        @endphp
        <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
        <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3"></textarea>
    </div>

    @if(\Illuminate\Support\Facades\Auth::user() == null)
        <div class="mt-4" style="display: flex">
            <input
                type="checkbox"
                id="gdpr"
                name="gdpr"
                style="position: relative; top:4px"
                class="@error('gdpr') is-invalid @enderror"
                @if(old('gdpr') == 'on') checked @endif>
            <span class="ml-1 attribute-label">
                    Slažem se sa
                    <a href="https://ntpark.rs/wp-content/uploads/2020/01/Obavestenje-o-obradi-podataka-o-licnosti.pdf" target="_blank">
                        uslovima obrade podataka o ličnosti.
                    </a>
                </span>
        </div>
        @error('gdpr') <div class="alert alert-danger">{{ $message }}</div> @enderror

        <div class="row mt-4">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <div class="captcha">
                    <span>{!! captcha_img('ntp') !!}</span>
                    <button type="button" id="refresh" class="btn btn-sm btn-success text-light"><i class="mdi mdi-refresh font-18" id="refresh"></i></button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4"></div>
            <div class="form-group col-md-4">
                <input id="captcha" type="text" class="form-control @error($attribute->name) is-invalid @enderror" placeholder="Unesite karaktere sa slike" name="captcha"></div>

        </div>
        @error('captcha') <div class="alert alert-danger text-center">{{ $message }}</div>@enderror
    @endif

    @if(!isset($profile))
        <div class="text-center mt-4" ref="submitButtons" id="submitButtons">
            <button type="submit" id="save" class="btn btn-sm btn-primary m-1" >
                {{ __('Create') }}
            </button>

            <button id="cancel" type="button" class="btn btn-sm btn-light m-1">{{ __('Cancel') }}</button>
        </div>
    @endif
</form>





