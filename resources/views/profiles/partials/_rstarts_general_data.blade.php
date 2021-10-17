<h3 class="text-center attribute-label m-4">{{ \App\AttributeGroup::where('name', 'rstarts_applicant')->first()->label }}</h3>

@foreach(
    ['rstarts_startup_name' => 'name', 'rstarts_applicant_name' => 'contact_person', 'rstarts_position' => 'position', 'rstarts_address' => 'address'] as $key=>$value)
<div class="form-group row">
    @php
        $attribute = $attributes->where('name', $key)->first();
        $value = $attribute->getValue() ?? isset($model) ? $model->getValue('name') : null;
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}">
    </div>
</div>
@endforeach

@php
    $attribute = $attributes->where('name', 'rstarts_email')->first();
    $value = $attribute->getValue() ?? isset($model) ?  $model->getValue('contact_email') : null ;
@endphp
<div class="form-group row">
    <label for="{{ $attribute->name }}" class="col-lg-2 attribute-label col-form-label col-form-label-sm" >{!! $attribute->label !!}</label>
    <div class="col-lg-10">
        <input type="email"
               class="form-control form-control-sm @error($attribute->name) is-invalid @enderror"
               id="{{ $attribute->name }}"
               name="{{$attribute->name}}"
               value="{{ $value }}"
               required
               autocomplete="{{ $attribute->name }}" >
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'rstarts_telephone')->first();
        $value = $attribute->getValue() ?? isset($model) ? $model->getValue('contact_phone') : null;
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}">
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'rstarts_logo')->first();
        $value = $attribute->getValue() ?? isset($model) ?  $model->getValue('profile_logo') : null;
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <table class="table table-responsive">
            @if($value != null)
            <tr>
                <td><a href="{{ $value['filelink'] }}" target="_blank">{{ $value['filename'] }}</a></td>
            </tr>
            @endif
            <tr>
                <input type="file" class="form-control" id="{{ $attribute->name }}" name="{{ $attribute->name }}">
            </tr>
        </table>
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'rstarts_webpage')->first();
        $value = $attribute->getValue() ;
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}">
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'rstarts_founding_date')->first();
        $value = $attribute->getValue() ;
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="date" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}">
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'rstarts_id_number')->first();
        $value = $attribute->getValue() ;
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}">
    </div>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'rstarts_basic_registered_activity')->first();
        $value = $attribute->getValue() ;
    @endphp

    <label for="{{ $attribute->name }}" class="col-sm-2 attribute-label col-form-label col-form-label-sm">{{ $attribute->label }}</label>
    <div class="col-sm-10">
        <input type="text" class="form-control form-control-sm" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $value }}">
    </div>
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_short_ino_desc')->first();
    @endphp
    <label class="attribute-label" for="{{ $attribute->name }}">{!! $attribute->label !!} </label>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() }}</textarea>
</div>

<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'rstarts_product_type')->first();
    @endphp
    <label for="{{ $attribute->name }}" class="col-lg-2 attribute-label col-form-label col-form-label-sm">{!! $attribute->label !!}</label>
    <div class="col-lg-10">
        <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control form-control-sm">
            <option value="0" @if( $attribute->getValue() == 0) selected @endif>Izaberite...</option>
            @foreach($attribute->getOptions() as $key => $value)
                <option value="{{$key}}" @if($key == $attribute->getValue()) selected @endif>{{$value}}</option>
            @endforeach
        </select>
    </div>
</div>



