@extends('layouts.app')

@section('scripts')
    <!-- Any additional scripts here -->
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @yield('title')
        </div>
        <form method="post" enctype="multipart/form-data" action="{{ $action }}" method="post">
            @csrf
            @foreach($model->getAttributes() as $attribute)
                @if($attribute->type === 'varchar')
                    <div class="form-group row">
                        <label for="{{ $attribute->name }}" class="col-sm-2 col-form-label">{{ $attribute->label }}</label>
                        <div class="col-sm-10">
                            <input
                                type="text"
                                class="form-control"
                                id="{{ $attribute->name }}"
                                name="{{$attribute->name}}"
                                value="{{ $attribute->getValue() }}">
                        </div>
                    </div>
                @endif
                @if($attribute->type === 'integer' || $attribute->type === 'double')
                    <div class="form-group row">
                        <label for="{{ $attribute->name }}" class="col-sm-2 col-form-label">{{ $attribute->label }}</label>
                        <div class="col-sm-2">
                            <input
                                type="text"
                                class="form-control"
                                id="{{ $attribute->name }}"
                                name="{{$attribute->name}}"
                                value="{{ $attribute->getValue() }}">
                        </div>
                    </div>
                @endif
                @if($attribute->type === 'datetime')
                    <div class="form-group row">
                        <label for="{{ $attribute->name }}" class="col-sm-2 col-form-label">{{ $attribute->label }}</label>
                        <div class="col-sm-6">
                            <input
                                type="text"
                                class="form-control"
                                id="datepicker"
                                name="{{$attribute->name}}"
                                value="{{ $attribute->getValue() }}" >
                        </div>
                    </div>
                @endif
                @if($attribute->type === 'bool')
                    <div class="form-group row">
                        <div class="col-sm-2">{{ $attribute->label }}</div>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    id="{{ $attribute->name }}"
                                    name="{{$attribute->name}}"
                                    checked="{{ $attribute->getValue() == 0 ? false : true }}">
                            </div>
                        </div>
                    </div>
                @endif
                @if($attribute->type === 'select')
                    @if(isset($attribute->extra) && $attribute->extra === 'multiselect')
                        <div class="form-group row">
                            <label for="{{ $attribute->name }}" class="col-sm-2 col-form-label">{{$attribute->label}}</label>
                            <div class="col-sm-10">
                                <select id="{{$attribute->name}}[]" name="{{$attribute->name}}[]" class="form-control" multiple>
                                    @foreach($attribute->getOptions() as $key => $value)
                                        <option value="{{$key}}" @if(in_array($key, $attribute->getValue())) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    @else
                        <div class="form-group row">
                            <label for="{{ $attribute->name }}" class="col-sm-2 col-form-label">{{$attribute->label}}</label>
                            <div class="col-sm-10">
                                <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control">
                                    <option value="0" @if( $attribute->getValue() == 0) selected @endif>Choose...</option>
                                    @foreach($attribute->getOptions() as $key => $value)
                                        <option value="{{$key}}" @if($key == $attribute->getValue()) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    @endif
                @endif
                @if($attribute->type === 'text')
                    <div class="form-group row">
                        <label for="{{ $attribute->name }}" class="col-sm-2 col-form-label">{{ $attribute->label }}</label>
                        <div class="col-sm-10">
                        <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() }}</textarea>
                        </div>
                    </div>
                @endif
            @endforeach
            <div class="form-group row">
                <div class="col-sm-6" style="text-align: right">
                    <button type="submit" class="btn btn-primary">Prihvati</button>
                </div>
                <div class="col-sm-6" style="text-align: left">
                    @yield('back')
                </div>
            </div>
        </form>
    </div>
@endsection
