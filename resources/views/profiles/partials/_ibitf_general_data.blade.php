<h3 class="text-center attribute-label m-4">{{ \App\AttributeGroup::where('name', 'ibitf_general')->first()->label }}</h3>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'program_name_or_company')->first();
        $value = $attribute->getValue() ?? isset($model) ? $model->getAttribute('name')->getValue() : old($attribute->name);
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm @error($attribute->name) is-invalid @enderror" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}">
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row mt-2">
    @php
        $attribute = $attributes->where('name', 'legal_status')->first();
        $value = $attribute->getValue() ?? old($attribute->name);
    @endphp
    <label for="legal_status" class="col-lg-2 attribute-label col-form-label col-form-label-sm mandatory-label">{{ __('gui-select.legal_status_title') }}</label>
    <div class="col-lg-10">
        <select id="{{ $attribute->name }}" name="{{ $attribute->name}}"
                class="form-control form-control-sm mandatory-field @error($attribute->name) is-invalid @enderror">
            <option value="0">{{ __('gui.choose') }}</option>
            @foreach($attribute->getOptions() as $key => $val)
                <option value="{{$key}}" @if($key == $value) selected @endif>{{$val}}</option>
            @endforeach
        </select>
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>


<div class="form-group row" id="dateRow">
    @php
        $attribute = $attributes->where('name', 'date_of_establishment')->first();
        $value = $attribute->getValue() ?? old($attribute->name);
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">{{ $attribute->label }}</label>
    <div class="col-sm-4">
        <input type="date" class="form-control form-control-sm @error($attribute->name) is-invalid @enderror" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}">
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>


<div class="form-group row" id="pibRow">
    @php
        $attribute = $attributes->where('name', 'pib')->first();
        $value = $attribute->getValue() ?? old($attribute->name) ;
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm @error($attribute->name) is-invalid @enderror" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}">
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row" id="idNumberRow">
    @php
        $attribute = $attributes->where('name', 'id_number')->first();
        $value = $attribute->getValue() ?? old($attribute->name) ;
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm @error($attribute->name) is-invalid @enderror" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}">
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'business_branch')->first();
        $attvalue = $attribute->getValue() ?? isset($model) ? $model->getAttribute('business_branch')->getValue() : old($attribute->name);
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label">{{ __('gui.incubation_form_business_branch') }}</label>
    <div class="col-sm-10">
        <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control form-control-sm @error($attribute->name) is-invalid @enderror">
            <option value="0" @if( $attvalue == 0) selected @endif>Choose...</option>
            @foreach($attribute->getOptions() as $key => $value)
                <option value="{{$key}}" @if($key == $attvalue) selected @endif>{{$value}}</option>
            @endforeach
        </select>
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'address')->first();
        $value = $attribute->getValue() ?? isset($model) ? $model->getAttribute('address')->getValue() : old($attribute->name);
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm mandatory-label @error($attribute->name) is-invalid @enderror">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}">
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>

{{-- <div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'number_of_participants')->first();
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}">
    </div>
</div> --}}

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'web')->first();
        $value = $attribute->getValue() ?? old($attribute->name);
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ __('gui.incubation_form_web_address') }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}">
        <div class="font-12 text-dark">Naziv web stranice mora obavezno imati prefix http:// ili https:// </div>
        @error($attribute->name)
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
</div>
