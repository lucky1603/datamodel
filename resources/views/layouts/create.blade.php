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
                @if($attribute->type === 'varchar' && !isset($attribute->extra))
                    <div class="form-group">
                        <label for="{{ $attribute->name }}">{{ $attribute->label }}</label>
                        <input type="text" class="form-control" id="{{ $attribute->name }}" name="{{$attribute->name}}">
                    </div>
                @endif
                @if(isset($attribute->extra) )
                    @if($attribute->type === 'varchar' && json_decode($attribute->extra)->ui === 'email')
                        <div class="form-group">
                            <label for="{{ $attribute->name }}" >{{ $attribute->label }}</label>
                            <input type="email"
                                   class="form-control @error($attribute->name) is-invalid @enderror"
                                   id="{{ $attribute->name }}"
                                   name="{{$attribute->name}}"
                                   value="{{ old($attribute->name) }}"
                                   required
                                   autocomplete="{{ $attribute->name }}" >
                        </div>
                    @endif
                    @if($attribute->type === 'varchar' && json_decode($attribute->extra)->ui === 'password')
                        <div class="form-group">
                            <label for="{{ $attribute->name }}">{{ $attribute->label }}</label>
                            <input type="password"
                                   class="form-control @error($attribute->name) is-invalid @enderror"
                                   id="{{ $attribute->name }}"
                                   name="{{$attribute->name}}"
                                   value="{{ old($attribute->name) }}"
                                   required
                                   autocomplete="{{ $attribute->name }}">
                        </div>
                    @endif
                @endif

                @if($attribute->type === 'integer' || $attribute->type === 'double')
                    <div class="form-group">
                        <label for="{{ $attribute->name }}">{{ $attribute->label }}</label>
                        <input type="text" class="form-control" id="{{ $attribute->name }}" name="{{$attribute->name}}">
                    </div>
                @endif
                @if($attribute->type === 'datetime')
                    <div class="form-group">
                        <label for="{{ $attribute->name }}" >{{ $attribute->label }}</label>
                        <input type="date" class="form-control" name="{{$attribute->name}}" id="{{ $attribute->name }}">
{{--                        <input type="text" class="form-control datepicker" id="{{ $attribute->name }}" name="{{ $attribute->name }}" >--}}
{{--                        <input type="text" class="form-control date" id="{{ $attribute->name }}" name="{{ $attribute->name }}" data-toggle="date-picker" data-single-date-picker="true">--}}
{{--                        <input type="text" class="form-control" data-provide="datepicker" data-date-format="d-M-yyyy" id="{{ $attribute->name }}" name="{{ $attribute->name }}">--}}

                    </div>
                @endif
                @if($attribute->type === 'bool')
                    <div class="form-group">
                        {{ $attribute->label }}
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="{{ $attribute->name }}" name="{{$attribute->name}}">
                            </div>
                    </div>
                @endif
                @if($attribute->type === 'select')
                    @if(isset($attribute->extra) && $attribute->extra === 'multiselect')
                            <div class="form-group">
                                <label for="{{ $attribute->name }}" >{{$attribute->label}}</label>
                                <select id="{{$attribute->name}}[]" name="{{$attribute->name}}[]" class="form-control" multiple>
                                    @foreach($attribute->getOptions() as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                    @else
                        <div class="form-group">
                            <label for="{{ $attribute->name }}">{{$attribute->label}}</label>

                                <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control">
                                    <option selected>Choose...</option>
                                    @foreach($attribute->getOptions() as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>


                        </div>
                    @endif
                @endif
                @if($attribute->type === 'text')
                    <div class="form-group">
                        <label for="{{ $attribute->name }}">{{ $attribute->label }}</label>
                        <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3"></textarea>
                    </div>
                @endif
                @if($attribute->type === 'file')
                    <div class="form-group row">
                        <label for="{{ $attribute->name }}">{{ $attribute->label }}</label>
                        <input type="file" class="form-control" id="{{ $attribute->name }}" name="{{$attribute->name}}">
                    </div>
                @endif
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
