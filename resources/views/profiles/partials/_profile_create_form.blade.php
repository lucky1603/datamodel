<form action="{{ $action }}" method="POST" enctype="multipart/form-data" id="myForm">
    @csrf

    <div class="form-group">
        @php
            $attribute = $attributes->where('name', 'name')->first();
        @endphp
        <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
        <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" class="form-control form-control-sm">
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
            @if($attribute->getValue()) checked @endif style="padding-top: 10px"
            onclick="
                if(document.getElementById('{{ $attribute->name }}').checked)
                {
                document.getElementById('{{ $attribute->name }}Hidden').disabled = true
                } else {
                document.getElementById('{{ $attribute->name }}Hidden').disabled = false;
                }
                ">
    </div>
    <div class="form-group" id="id_number_group">
        @php
            $attribute = $attributes->where('name', 'id_number')->first();
        @endphp
        <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
        <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        @php
            $attribute = $attributes->where('name', 'contact_person')->first();
        @endphp
        <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
        <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        @php
            $attribute = $attributes->where('name', 'contact_email')->first();
        @endphp
        <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
        <input type="email"
               class="form-control form-control-sm @error($attribute->name) is-invalid @enderror"
               id="{{ $attribute->name }}"
               name="{{$attribute->name}}"
               value="{{ $attribute->getValue() }}"
               required
               autocomplete="{{ $attribute->name }}" >
    </div>
    <div class="form-group">
        @php
            $attribute = $attributes->where('name', 'password')->first();
        @endphp
        <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
        <input type="password"
               class="form-control @error($attribute->name) is-invalid @enderror"
               id="{{ $attribute->name }}"
               name="{{$attribute->name}}"
               value="{{ old($attribute->name) }}"
               required
               autocomplete="{{ $attribute->name }}">
    </div>
    <div class="form-group">
        @php
            $attribute = $attributes->where('name', 'contact_phone')->first();
        @endphp
        <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
        <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" class="form-control form-control-sm">
    </div>
    <div class="form-group">
        @php
            $attribute = $attributes->where('name', 'address')->first();
        @endphp
        <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
        <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" class="form-control form-control-sm">
    </div>

    <div class="form-group">
        @php
            $attribute = $attributes->where('name', 'university')->first();
        @endphp
        <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
        <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control">
            <option selected>Choose...</option>
            @foreach($attribute->getOptions() as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        @php
            $attribute = $attributes->where('name', 'short_ino_desc')->first();
        @endphp
        <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
        <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3"></textarea>
    </div>
    <div class="form-group">
        @php
            $attribute = $attributes->where('name', 'business_branch')->first();
        @endphp
        <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
        <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control">
            <option selected>Choose...</option>
            @foreach($attribute->getOptions() as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        @php
            $attribute = $attributes->where('name', 'reason_contact')->first();
        @endphp
        <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
        <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control">
            <option selected>Choose...</option>
            @foreach($attribute->getOptions() as $key => $value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        @php
            $attribute = $attributes->where('name', 'note')->first();
        @endphp
        <label for="name" class="attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
        <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3"></textarea>
    </div>

    <div class="text-center mt-4">
        <button type="submit" id="save" class="btn btn-primary m-1" >
            {{ __('Create') }}
        </button>

        <button id="cancel" type="button" class="btn btn-light m-1">{{ __('Cancel') }}</button>
    </div>
</form>





