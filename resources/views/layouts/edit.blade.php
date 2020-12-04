@extends('layouts.app')

@section('scripts')
    <!-- Any additional scripts here -->
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @yield('title')
        </div>
        <form method="post" enctype="multipart/form-data" action="{{ $action }}" >
            @csrf
            @foreach($model->getAttributeGroups()->sortBy('sort_order') as $attributeGroup)
                <h3 style="text-align: center">{{ $attributeGroup->label }}</h3>
                @foreach($model->getAttributesForGroup($attributeGroup)->sortBy('sort_order') as $attribute)
                    @if($attribute->name == 'status')
                        @continue
                    @endif
                    @if($attribute->type === 'varchar' && !isset($attribute->extra))
                        <div class="form-group">
                            <label for="{{ $attribute->name }}">{!! $attribute->label !!}</label>
                            <input
                                type="text"
                                class="form-control"
                                id="{{ $attribute->name }}"
                                name="{{$attribute->name}}"
                                value="{{ $attribute->getValue() }}">
                        </div>
                    @endif
                    @if(isset($attribute->extra))
                        @if($attribute->type === 'varchar' && json_decode($attribute->extra)->ui === 'email')
                            <div class="form-group">
                                <label for="{{ $attribute->name }}" >{!! $attribute->label !!}</label>
                                <input type="email"
                                       class="form-control @error($attribute->name) is-invalid @enderror"
                                       id="{{ $attribute->name }}"
                                       name="{{$attribute->name}}"
                                       value="{{ $attribute->getValue() }}"
                                       required
                                       autocomplete="{{ $attribute->name }}" >
                            </div>
                        @endif
                    @endif
                    @if($attribute->type === 'integer' || $attribute->type === 'double')
                        <div class="form-group">
                            <label for="{{ $attribute->name }}">{!! $attribute->label !!} </label>
                            <input
                                type="text"
                                class="form-control"
                                id="{{ $attribute->name }}"
                                name="{{$attribute->name}}"
                                value="{{ $attribute->getValue() }}">
                        </div>
                    @endif
                    @if($attribute->type === 'datetime')
                        <div class="form-group">
                            <label for="{{ $attribute->name }}">{!! $attribute->label !!}</label>
                            <input
                                type="date"
                                class="form-control"
                                id="{{$attribute->name}}"
                                name="{{$attribute->name}}"
                                value="{{ $attribute->getValue() }}">
{{--                            <input type="text"--}}
{{--                                   class="form-control"--}}

{{--                                   id="{{ $attribute->name }}"--}}
{{--                                   name="{{ $attribute->name }}--}}
{{--                                   value="{{ $attribute->getValue() }}">--}}
                        </div>
                    @endif
                    @if($attribute->type === 'bool')
                        <div class="form-group">
                            <input id="{{ $attribute->name }}Hidden" type="hidden" name="{{ $attribute->name }}" value="off">
                            {!! $attribute->label !!}
                            <input
                                type="checkbox"
                                id="{{ $attribute->name }}"
                                name="{{$attribute->name}}"
                                @if($attribute->getValue()) checked @endif style="padding-top: 10px"
                                onclick="
                                    if(document.getElementById('{{ $attribute->name }}').checked)
                                    {
                                        document.getElementById('{{ $attribute->name }}Hidden').disabled = true
                                    } else {
                                        document.getElementById('{{ $attribute->name }}Hidden').disabled = false;
                                    }
                                    ">
                        </div>
                    @endif
                    @if($attribute->type === 'select')
                        @if(isset($attribute->extra) && $attribute->extra === 'multiselect')
                            <div class="form-group">
                                <label for="{{ $attribute->name }}">{!! $attribute->label !!}</label>
                                <select id="{{$attribute->name}}[]" name="{{$attribute->name}}[]" class="form-control" multiple>
                                    @foreach($attribute->getOptions() as $key => $value)
                                        <option value="{{$key}}" @if(in_array($key, $attribute->getValue())) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <div class="form-group">
                                <label for="{{ $attribute->name }}">{!! $attribute->label !!}</label>
                                <select id="{{$attribute->name}}" name="{{$attribute->name}}" class="form-control">
                                    <option value="0" @if( $attribute->getValue() == 0) selected @endif>Choose...</option>
                                    @foreach($attribute->getOptions() as $key => $value)
                                        <option value="{{$key}}" @if($key == $attribute->getValue()) selected @endif>{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif
                    @endif
                    @if($attribute->type === 'text')
                        <div class="form-group">
                            <label for="{{ $attribute->name }}">{!! $attribute->label !!}</label>
                            <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() }}</textarea>
                        </div>
                    @endif
                    @if($attribute->type === 'file')
                        <div class="form-group">
                            <label for="{{ $attribute->name }}">{!! $attribute->label !!}</label>
                            @if($attribute->getValue() != null)
                                <table class="table table-responsive">
                                    <tr>
                                        <td><a href="{{ $attribute->getValue()['filelink'] }}">{{ $attribute->getValue()['filename'] }}</a></td>
                                    </tr>
                                    <tr>
                                        <input type="file" class="form-control" id="{{ $attribute->name }}" name="{{ $attribute->name }}">
                                    </tr>
                                </table>
                            @else
                                <input type="file" class="form-control" id="{{ $attribute->name }}" name="{{ $attribute->name }}">
                            @endif
                        </div>
                    @endif
                @endforeach
            @endforeach

            <div class="form-group row">
                @if(auth()->user()->isAdmin())
                    <div class="col-sm-4" style="text-align: right">
                        <button type="submit" class="btn btn-primary">Prihvati</button>
                    </div>
                    <div class="col-sm-4" style="text-align: center">
                        <a href="#" class="btn btn-primary">Promeni lozinku</a>
                    </div>
                    <div class="col-sm-4" style="text-align: left">
                        @yield('back')
                    </div>
                @else
                    <div class="col-sm-6" style="text-align: right">
                        <button type="submit" class="btn btn-primary">Prihvati</button>
                    </div>
                    <div class="col-sm-6" style="text-align: left">
                        @yield('back')
                    </div>
                @endif
            </div>
        </form>
    </div>
@endsection
