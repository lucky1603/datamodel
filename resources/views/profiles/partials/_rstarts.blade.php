@if(isset($model) && count($errors))
    <div class="alert alert-danger">Promene nisu sačuvane zbog validacionih grešaka. Prekontrolišite formu. Polja sa porgrešnim unosima su označena crvenom bojom.</div>
@endif

@if(!isset($model))
<div class="bg-light attribute-label font-14 m-1 p-4 shadow" style="display: flex; align-items: center; justify-content: center; flex-direction: column;">
    <p>U cilju boljeg razumevanja Prijavnog formulara, obe kategorije se u daljem tekstu nazivaju “startap”.</p>
    <p>Obavezna polja su označena zvezdicom (<span class="text-danger">*</span>) i različitom pozadinom.</p>
</div>
@endif
<div class="form-group row mt-2">
    @php
        $attribute = $attributes->where('name', 'app_type')->first();
        $value = $attribute->getValue() ?? old($attribute->name);
    @endphp
    <label for="{{ $attribute->name }}" class="col-lg-2 attribute-label col-form-label col-form-label-sm mandatory-label">{!! $attribute->label !!}</label>
    <div class="col-lg-10">
        <select id="{{$attribute->name}}" name="{{$attribute->name}}"
                class="form-control form-control-sm mandatory-field"
                @error($attribute->name) is-error @enderror
                @if(isset($model)) disabled @endif>
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
    <label for="{{ $attribute->name }}" class="col-lg-2 attribute-label col-form-label col-form-label-sm mandatory-label">Naučno-tehnološki park u kojem aplicirate za Raising Starts program:</label>
    <div class="col-lg-10">
        <select id="{{$attribute->name}}"
                name="{{$attribute->name}}"
                class="form-control form-control-sm mandatory-field"
                @error($attribute->name) is-error @enderror
                @if(isset($model)) disabled @endif>
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
@if(auth()->user() == null)
    @include('profiles.partials._rstarts_izjave')
@endif

