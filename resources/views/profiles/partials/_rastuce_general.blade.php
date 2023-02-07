<h3 class="text-center attribute-label m-4">{{ mb_strtoupper(__('Opšti podaci')) }}</h3>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'company_name')->first();
        $value = $attribute->getValue() ?? isset($model) ? $model->getValue($attribute->name) : old($attribute->name);
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text"
               class="mandatory-field form-control form-control-sm @error($attribute->name) is-invalid @enderror"
               id="{{ $attribute->name }}"
               name="{{ $attribute->name }}"
               value="{{ $value }}" @if(isset($model) && isset($instance_id) && $value != null ) disabled @endif>
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @endif
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'id_number')->first();
        $value = $attribute->getValue() ?? isset($model) ? $model->getValue($attribute->name) : old($attribute->name);
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text"
               class="mandatory-field form-control form-control-sm @error($attribute->name) is-invalid @enderror"
               id="{{ $attribute->name }}"
               name="{{ $attribute->name }}"
               value="{{ $value }}" @if(isset($model) && isset($instance_id) && $value != null ) disabled @endif>
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @endif
    </div>
</div>

<div class="form-group row" id="dateRow">
    @php
        $attribute = $attributes->where('name', 'founding_date')->first();
        $value = $attribute->getValue() ?? isset($model) ? $model->getValue($attribute->name) : old($attribute->name);;
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm @if($mode == 'anonimous') mandatory-label @endif">{{ $attribute->label }}</label>
    <div class="col-sm-4">
        <input type="date" class="form-control form-control-sm @error($attribute->name) is-invalid @enderror" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}">
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'webpage')->first();
        $value = $attribute->getValue() ?? isset($model) ? $model->getValue($attribute->name) : old($attribute->name);;
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text"
               class="mandatory-field form-control form-control-sm @error($attribute->name) is-invalid @enderror"
               id="{{ $attribute->name }}"
               name="{{ $attribute->name }}"
               value="{{ $value }}" @if(isset($model) && isset($instance_id) && $value != null ) disabled @endif>
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @endif
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'business_branch')->first();
        $value = $attribute->getValue() ?? isset($model) ? $model->getValue($attribute->name) : old($attribute->name);;
    @endphp
    <label for="{{ $attribute->name }}"
           class="col-lg-2 attribute-label col-form-label col-form-label-sm mandatory-label">{!! $attribute->label !!}</label>
    <div class="col-lg-10">
        <select id="{{$attribute->name}}"
                name="{{$attribute->name}}"
                class="form-control form-control-sm @error($attribute->name) is-invalid @enderror mandatory-field" @if(isset($model) && $value != null) disabled @endif>
            <option value="0" @if( $value == 0) selected @endif>Izaberite...</option>
            @foreach($attribute->getOptions() as $key => $val)
                <option value="{{$key}}" @if($key == $value) selected @endif>{{$val}}</option>
            @endforeach
        </select>
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'responsible_person')->first();
        $value = $attribute->getValue() ?? isset($model) ? $model->getValue($attribute->name) : old($attribute->name);;
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text"
               class="mandatory-field form-control form-control-sm @error($attribute->name) is-invalid @enderror"
               id="{{ $attribute->name }}"
               name="{{ $attribute->name }}"
               value="{{ $value }}" @if(isset($model) && isset($instance_id) && $value != null ) disabled @endif>
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @endif
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'responsible_person_email')->first();
        $value = $attribute->getValue() ?? isset($model) ? $model->getValue($attribute->name) : old($attribute->name);;
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text"
               class="mandatory-field form-control form-control-sm @error($attribute->name) is-invalid @enderror"
               id="{{ $attribute->name }}"
               name="{{ $attribute->name }}"
               value="{{ $value }}" @if(isset($model) && isset($instance_id) && $value != null ) disabled @endif>
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @endif
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'responsible_person_phone')->first();
        $value = $attribute->getValue() ?? isset($model) ? $model->getValue($attribute->name) : old($attribute->name);;
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text"
               class="mandatory-field form-control form-control-sm @error($attribute->name) is-invalid @enderror"
               id="{{ $attribute->name }}"
               name="{{ $attribute->name }}"
               value="{{ $value }}" @if(isset($model) && isset($instance_id) && $value != null ) disabled @endif>
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @endif
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'address')->first();
        $value = $attribute->getValue() ?? isset($model) ? $model->getValue($attribute->name) : old($attribute->name);;
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text"
               class="mandatory-field form-control form-control-sm @error($attribute->name) is-invalid @enderror"
               id="{{ $attribute->name }}"
               name="{{ $attribute->name }}"
               value="{{ $value }}" @if(isset($model) && isset($instance_id) && $value != null ) disabled @endif>
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @endif
    </div>
</div>


<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'innovative_product')->first();
        $value = $attribute->getValue() ?? isset($model) ? $model->getValue($attribute->name) : old($attribute->name);;
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text"
               class="mandatory-field form-control form-control-sm @error($attribute->name) is-invalid @enderror"
               id="{{ $attribute->name }}"
               name="{{ $attribute->name }}"
               value="{{ $value }}" @if(isset($model) && isset($instance_id) && $value != null ) disabled @endif>
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @endif
    </div>
</div>

