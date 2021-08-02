@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="justify-content-center">
            @yield('title')
        </div>

        <form method="post" enctype="multipart/form-data" action="{{ $action }}" method="post">
            @csrf
            @foreach($attributes as $attribute)
                @if(strpos($attribute->name, 'status') != false)
                    @continue
                @endif
                <div class="form-group" id="{{ $attribute->name }}_group">
                @if($attribute->type === 'varchar' && !isset($attribute->extra))

                        <label for="{{ $attribute->name }}">{{ $attribute->label }}</label>
                        <input type="text" class="form-control" id="{{ $attribute->name }}" name="{{$attribute->name}}">

                @endif
                @if(isset($attribute->extra) )
                    @if($attribute->type === 'varchar' && json_decode($attribute->extra)->ui === 'email')

                            <label for="{{ $attribute->name }}" >{{ $attribute->label }}</label>
                            <input type="email"
                                   class="form-control @error($attribute->name) is-invalid @enderror"
                                   id="{{ $attribute->name }}"
                                   name="{{$attribute->name}}"
                                   value="{{ old($attribute->name) }}"
                                   required
                                   autocomplete="{{ $attribute->name }}" >

                    @endif
                    @if($attribute->type === 'varchar' && json_decode($attribute->extra)->ui === 'password')

                            <label for="{{ $attribute->name }}">{{ $attribute->label }}</label>
                            <input type="password"
                                   class="form-control @error($attribute->name) is-invalid @enderror"
                                   id="{{ $attribute->name }}"
                                   name="{{$attribute->name}}"
                                   value="{{ old($attribute->name) }}"
                                   required
                                   autocomplete="{{ $attribute->name }}">

                    @endif
                @endif

                @if($attribute->type === 'integer' || $attribute->type === 'double')

                        <label for="{{ $attribute->name }}">{{ $attribute->label }}</label>
                        <input type="text" class="form-control" id="{{ $attribute->name }}" name="{{$attribute->name}}">

                @endif
                @if($attribute->type === 'datetime')

                        <label for="{{ $attribute->name }}" >{{ $attribute->label }}</label>
                        <input type="date" class="form-control" name="{{$attribute->name}}" id="{{ $attribute->name }}">
{{--                        <input type="text" class="form-control datepicker" id="{{ $attribute->name }}" name="{{ $attribute->name }}" >--}}
{{--                        <input type="text" class="form-control date" id="{{ $attribute->name }}" name="{{ $attribute->name }}" data-toggle="date-picker" data-single-date-picker="true">--}}
{{--                        <input type="text" class="form-control" data-provide="datepicker" data-date-format="d-M-yyyy" id="{{ $attribute->name }}" name="{{ $attribute->name }}">--}}


                @endif
                @if($attribute->type === 'bool')


{{--                        <label>{{ $attribute->label }}</label>--}}
{{--                    --}}
{{--                    <div class="mt-1">--}}

{{--                        <input type="checkbox" id="switch1" name="{{$attribute->name}}" checked data-switch="bool" value="is_company"/>--}}
{{--                        <label for="switch1" data-on-label="Da" data-off-label="Ne"></label>--}}
{{--                    </div>--}}
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="true">
                            <label class="custom-control-label" for="{{ $attribute->name }}">Check this custom checkbox</label>
                        </div>

                @endif
                @if($attribute->type === 'select')
                    @if(isset($attribute->extra) && $attribute->extra === 'multiselect')

                                <label for="{{ $attribute->name }}" >{{$attribute->label}}</label>
                                <select id="{{$attribute->name}}[]" name="{{$attribute->name}}[]" class="form-control" multiple>
                                    @foreach($attribute->getOptions() as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>

                    @else

                            <label for="{{ $attribute->name }}">{{$attribute->label}}</label>

                                <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control">
                                    <option selected>Choose...</option>
                                    @foreach($attribute->getOptions() as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>



                    @endif
                @endif
                @if($attribute->type === 'text')

                        <label for="{{ $attribute->name }}">{{ $attribute->label }}</label>
                        <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3"></textarea>

                @endif
                @if($attribute->type === 'file')

                        <label for="{{ $attribute->name }}">{{ $attribute->label }}</label>
                        <input type="file" class="form-control" id="{{ $attribute->name }}" name="{{$attribute->name}}">

                @endif
                </div>
            @endforeach

            <div class="form-group row">
                <div class="col-sm-6" style="text-align: right">
                    <button type="submit" class="btn btn-primary">Dodaj</button>
                </div>
                <div class="col-sm-6" style="text-align: left">
                    <a href="{{route('clients.index')}}" class="btn btn-secondary">Nazad</a>
                </div>
            </div>
        </form>
    </div>
@endsection
