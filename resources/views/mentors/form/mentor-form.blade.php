<div style="display: flex; align-items: center; justify-content: center" >
    <form id="myMentorForm" action="{{ $action }}" method="POST" enctype="multipart/form-data" class="mb-4 px-4 py-2" style="max-height: 600px; max-width: 700px">
        @csrf
        @if(isset($mentor))
            <input type="hidden" id="mentorid" name="mentorid" value="{{ $mentor->getId() }}">
        @endif
        <div class="form-group">
            @php
                $attribute = $attributes->where('name', 'name')->first();
                $value = $attribute->getValue() ?? old($attribute->name);
            @endphp
            <label for="{{ $attribute->name }}" class="col-form-label col-form-label-sm">{{ $attribute->label }}</label>
            <input
                type="text"
                id="{{ $attribute->name }}"
                name="{{ $attribute->name }}"
                @if($value != null) value="{{ $value }}" @endif
                class="form-control form-control-sm @error($attribute->name) is-invalid @enderror" >
            @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            @php
                $attribute = $attributes->where('name', 'company')->first();
                $value = $attribute->getValue() ?? old($attribute->name);
            @endphp
            <label for="{{ $attribute->name }}" class="col-form-label col-form-label-sm">{{ $attribute->label }}</label>
            <input type="text" id="{{ $attribute->name }}"
                   name="{{ $attribute->name }}"
                   @if($value != null) value="{{ $value }}" @endif class="form-control form-control-sm">
            <span class="text-danger error-notification" id="{{ $attribute->name }}Error" style="display: none"></span>
        </div>
        <div class="form-group">
            @php
                $attribute = $attributes->where('name', 'email')->first();
                $value = $attribute->getValue() ?? old($attribute->name);
            @endphp
            <label for="{{ $attribute->name }}" class="col-form-label col-form-label-sm">{{ $attribute->label }}</label>
            <input
                type="text"
                id="{{ $attribute->name }}"
                name="{{ $attribute->name }}"
                @if($value != null) value="{{ $value }}" @endif
                class="form-control form-control-sm @error($attribute->name) is-invalid @enderror"
                autocomplete="{{ $attribute->name }}">
            @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div> @enderror
        </div>
        <div class="form-group">
            @php
                $attribute = $attributes->where('name', 'phone')->first();
                $value = $attribute->getValue() ?? old($attribute->name);
            @endphp
            <label for="{{ $attribute->name }}" class="col-form-label col-form-label-sm">{{ $attribute->label }}</label>
            <input
                type="text"
                id="{{ $attribute->name }}"
                name="{{ $attribute->name }}"
                @if($value != null) value="{{ $value }}" @endif
                class="form-control form-control-sm @error($attribute->name) is-invalid @enderror"
{{--                data-toggle="input-mask"--}}
{{--                data-mask-format="000 000-0000">--}}
            >
            <span class="text-danger error-notification" id="{{ $attribute->name }}Error" style="display: none"></span>
{{--            <span class="font-11">Uneti br. telefona u formatu 0## ###-###(#)</span>--}}
            @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            @php
                $attribute = $attributes->where('name', 'address')->first();
                $value = $attribute->getValue() ?? old($attribute->name);
            @endphp
            <label for="{{ $attribute->name }}" class="col-form-label col-form-label-sm">{{ $attribute->label }}</label>
            <input type="text"
                   id="{{ $attribute->name }}"
                   name="{{ $attribute->name }}"
                   @if($value != null) value="{{ $value }}" @endif
                   class="form-control form-control-sm">
        </div>

        <div class="row" >
            <div class="col-lg-4 border border-primary"  >
                @php
                    $attribute = $attributes->where('name', 'photo')->first();
                    $photo = $attribute->getValue() ?? old($attribute->name);
                @endphp
                @if($photo != null && $photo['filelink'] != '')
                    <img src="{{ $photo['filelink'] }}" id="photoPreview" style="width: 100%">
                @else
                    <img src="/images/custom/nophoto2.png" id="photoPreview" style="width: 100%">
                @endif
                <border style="border-radius: 10px; width: 50px; overflow: hidden; position:relative; top:-45px">
                    <input type="file" id="photo" name="photo" style="color: transparent;display:none">
                    <button id="textBtn" type="button" class="btn btn-sm btn-primary rounded-pill w-50 justify-content-center" >Izaberi</button>
                </border>
            </div>
            <div class="col-lg-8">
                <div class="form-group" style="min-height: 150px">
                    @php
                        $attribute = $attributes->where('name', 'specialities')->first();
                        $value = $attribute->getValue() ?? old($attribute->name);
                    @endphp
                    <label for="{{ $attribute->name }}">{!! $attribute->label !!}</label>
                    <select id="{{$attribute->name}}[]" name="{{$attribute->name}}[]" class="form-control @error($attribute->name) is-invalid @enderror" multiple style="height: 120px" >
                        @foreach($attribute->getOptions() as $key => $val)
                            <option value="{{$key}}" @if($value != null && in_array($key, $value)) selected @endif>{{ $val }}</option>
                        @endforeach
                    </select>
                    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div> @enderror

                </div>
                <div class="form-group mt-2">
                    @php
                        $attribute = $attributes->where('name', 'mentor-type')->first();
                        $value = $attribute->getValue() ?? old($attribute->name);
                    @endphp
                    <label for="{{ $attribute->name }}">{!! $attribute->label !!}</label>
                    <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control @error($attribute->name) is-invalid @enderror">
                        <option value="0" @if($value == null || $value == 0) selected @endif>Choose...</option>
                        @foreach($attribute->getOptions() as $key => $val)
                            <option value="{{$key}}" @if($value != null && $key == $value) selected @endif>{{$val}}</option>
                        @endforeach
                    </select>
                    @error($attribute->name) <div class="alert alert-danger">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
        @if($showCommands)
        <div class="text-center mt-3 mb-3">
            <button type="submit" id="buttonSubmit" class="btn btn-sm btn-primary rounded-pill w-15">Prihvati</button>
            <button type="button" id="buttonClose" class="btn btn-sm btn-outline-primary rounded-pill w-15" data-dismiss="modal">Zatvori</button>
        </div>
        @endif

    </form>
</div>




