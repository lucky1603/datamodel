@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="row justify-content-center">
                    <p>Pregled situacije za <strong>{{ $parent->getAttributeValues()['name'] }}</strong></p>
                </div>
                <div class="row justify-content-center" style="margin-bottom: 30px">
                    <h1>{{ $situation->getData()['description'] }}</h1>
                </div>
                @foreach($situation->getAttributes()->sortBy('sort_order') as $attribute)
                    @if($attribute->name === 'name' || $attribute->name === 'description')
                        @continue
                    @endif

                    @if($attribute->type === 'file')
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-3">{!! $attribute->label !!} : </div>
                            <div class="col-md-5"><a href="{{ $attribute->getValue()['filelink']}}"><strong>{{$attribute->getValue()['filename']}}</strong></a></div>
                            <div class="col-md-2"></div>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-3">{!! $attribute->label !!} : </div>
                            @if($attribute->type === 'bool')
                                <div class="col-md-5"><strong>{{$attribute->getText() === 'true' ? 'Da' : 'Ne'}}</strong></div>
                            @else
                                <div class="col-md-5"><strong>{{$attribute->getText()}}</strong></div>
                            @endif
                            <div class="col-md-2"></div>
                        </div>
                    @endif
                @endforeach
                <div class="button-bar">
                    <a href="{{ request()->session()->get('backroute') }}" class="btn btn-primary">Nazad</a>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>

    </div>
@endsection
