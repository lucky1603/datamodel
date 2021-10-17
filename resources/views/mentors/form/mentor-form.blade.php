<div class="container">
    @if($showTitle)
        <h1 class="text-center attribute-label">{{ $title }}</h1>
    @endif
    <form id="myMentorForm" action="{{ $action }}" method="POST" enctype="multipart/form-data" class="mb-4">
        @csrf
        @if(isset($mentor))
            <input type="hidden" id="mentorid" name="mentorid" value="{{ $mentor->getId() }}">
        @endif
        <div class="form-group">
            @php
                $attribute = $attributes->where('name', 'name')->first();
                $value = $attribute->getValue() ?? null;
            @endphp
            <label for="{{ $attribute->name }}" class="col-form-label col-form-label-sm">{{ $attribute->label }}</label>
            <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" @if($value != null) value="{{ $value }}" @endif class="form-control form-control-sm">
        </div>
        <div class="form-group">
            @php
                $attribute = $attributes->where('name', 'company')->first();
                $value = $attribute->getValue() ?? null;
            @endphp
            <label for="{{ $attribute->name }}" class="col-form-label col-form-label-sm">{{ $attribute->label }}</label>
            <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" @if($value != null) value="{{ $value }}" @endif class="form-control form-control-sm">
        </div>
        <div class="form-group">
            @php
                $attribute = $attributes->where('name', 'email')->first();
                $value = $attribute->getValue() ?? null;
            @endphp
            <label for="{{ $attribute->name }}" class="col-form-label col-form-label-sm">{{ $attribute->label }}</label>
            <input
                type="text"
                id="{{ $attribute->name }}"
                name="{{ $attribute->name }}"
                @if($value != null) value="{{ $value }}" @endif
                class="form-control form-control-sm @error($attribute->name) is-invalid @enderror"
                required
                autocomplete="{{ $attribute->name }}">
        </div>
        <div class="form-group">
            @php
                $attribute = $attributes->where('name', 'phone')->first();
                $value = $attribute->getValue() ?? null;
            @endphp
            <label for="{{ $attribute->name }}" class="col-form-label col-form-label-sm">{{ $attribute->label }}</label>
            <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" @if($value != null) value="{{ $value }}" @endif class="form-control form-control-sm">
        </div>

        <div class="form-group">
            @php
                $attribute = $attributes->where('name', 'address')->first();
                $value = $attribute->getValue() ?? null;
            @endphp
            <label for="{{ $attribute->name }}" class="col-form-label col-form-label-sm">{{ $attribute->label }}</label>
            <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" @if($value != null) value="{{ $value }}" @endif class="form-control form-control-sm">
        </div>

        <div class="row" >
            <div class="col-lg-4 border border-primary"  >
                @php
                    $attribute = $attributes->where('name', 'photo')->first();
                    $photo = $attribute->getValue() ?? null;
                @endphp
                @if($photo != null && $photo['filelink'] != '')
                    <img src="{{ $photo['filelink'] }}" id="photoPreview" style="width: 100%">
                @else
                    <img src="/images/custom/nophoto2.png" id="photoPreview" style="width: 100%">
                @endif
                <border style="border-radius: 10px; width: 50px; overflow: hidden; position:relative; top:-45px">
                    <input type="file" id="photo" name="photo" style="color: transparent;display:none">
                    <button id="textBtn" type="button" class="btn btn-sm btn-primary rounded-pill w-50 justify-content-center" >Izaberi sliku</button>
                </border>
            </div>
            <div class="col-lg-8">
                <div class="form-group" style="height: 70%">
                    @php
                        $attribute = $attributes->where('name', 'specialities')->first();
                        $value = $attribute->getValue() ?? null;
                    @endphp
                    <label for="{{ $attribute->name }}">{!! $attribute->label !!}</label>
                    <select id="{{$attribute->name}}[]" name="{{$attribute->name}}[]" class="form-control" multiple style="height: 90%">
                        @foreach($attribute->getOptions() as $key => $val)
                            <option value="{{$key}}" @if($value != null && in_array($key, $value)) selected @endif>{{ $val }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    @php
                        $attribute = $attributes->where('name', 'mentor-type')->first();
                        $value = $attribute->getValue() ?? null;
                    @endphp
                    <label for="{{ $attribute->name }}">{!! $attribute->label !!}</label>
                    <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control">
                        <option value="0" @if($value == null || $value == 0) selected @endif>Choose...</option>
                        @foreach($attribute->getOptions() as $key => $val)
                            <option value="{{$key}}" @if($value != null && $key == $value) selected @endif>{{$val}}</option>
                        @endforeach
                    </select>
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



