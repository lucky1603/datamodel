@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @yield('title')
        </div>

        <form method="post" enctype="multipart/form-data" action="{{ $action }}" method="post">
            @csrf
            @foreach($attributes as $attribute)
                @if($attribute->type === 'varchar')
                    <div class="form-group row">
                        <label for="{{ $attribute->name }}" class="col-sm-2 col-form-label">{{ $attribute->label }}</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="{{ $attribute->name }}" name="{{$attribute->name}}">
                        </div>
                    </div>
                @endif
                @if($attribute->type === 'bool')
                    <div class="form-group row">
                        <div class="col-sm-2">{{ $attribute->label }}</div>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="{{ $attribute->name }}" name="{{$attribute->name}}">
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
                                            <option value="{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                    @else
                        <div class="form-group row">
                            <label for="{{ $attribute->name }}" class="col-sm-2 col-form-label">{{$attribute->label}}</label>
                            <div class="col-sm-10">
                                <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control">
                                    <option selected>Choose...</option>
                                    @foreach($attribute->getOptions() as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
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
                            <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3"></textarea>
                        </div>
                    </div>
                @endif
                @if($attribute->type === 'file')
                    <div class="form-group row">
                        <label for="{{ $attribute->name }}" class="col-sm-2 col-form-label">{{ $attribute->label }}</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="{{ $attribute->name }}" name="{{$attribute->name}}">
                        </div>
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
