<div class="text-center mt-4 mb-4">
    <h1 class="attribute-label">PRIJAVA</h1>
</div>
<div class="bg-light attribute-label mb-2" style="height: 50px; display: flex; align-items: center; justify-content: center">
    ** U cilju boljeg razumevanja Prijavnog formulara, obe kategorije se u daljem tekstu nazivaju “startap”. U prvom delu prijave, odgovorite na pitanja koja se odnose na vas.
</div>
<div class="form-group row">
    @php
        $attribute = $attributes->where('name', 'app_type')->first();
        $value = $attribute->getValue() ?? old($attribute->name);
    @endphp
    <label for="{{ $attribute->name }}" class="col-lg-2 attribute-label col-form-label col-form-label-sm">{!! $attribute->label !!}</label>
    <div class="col-lg-10">
        <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control form-control-sm" required @error($attribute->name) is-error @enderror>
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
<div class="row form-group mt-2">
    @php
        $attribute = $attributes->where('name', 'ntp')->first();
        $value = $attribute->getValue() ?? old($attribute->name);
    @endphp
    <label for="{{ $attribute->name }}" class="col-lg-2 attribute-label col-form-label col-form-label-sm">{!! $attribute->label !!}</label>
    <div class="col-lg-10">
        <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control form-control-sm" required @error($attribute->name) is-error @enderror>
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

@include('profiles.partials._rstarts_general_data')
@include('profiles.partials._rstarts_team')
@include('profiles.partials._rstarts_business_model')
@include('profiles.partials._rstarts_startup_story')
@include('profiles.partials._rstarts_additional_doc')
@include('profiles.partials._rstarts_izjave')

