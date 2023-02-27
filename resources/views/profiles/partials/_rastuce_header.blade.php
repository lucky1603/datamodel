@foreach (['intention', 'company_type', 'apply_for_membership_type'] as $attname)
<div class="form-group row">
    @php
        $attribute = $attributes->where('name', $attname)->first();
        $value = $attribute->getValue() ?? old($attribute->name);
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
@endforeach


