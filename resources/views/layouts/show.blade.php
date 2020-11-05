@extends('layouts.user')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h1 style="text-align: center">{{ $model->getData()['name'] }}</h1>
        </div>
        <div class="justify-content-center">
            @yield('head')
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="row justify-content-center">
                    <p class="column-title">Detalji</p>
                </div>
                @if($model->getAttributeGroups()->count() > 0)
                    @foreach($model->getAttributeGroups()->sortBy('sort_order') as $attributeGroup)
                        <h3 style="text-align: center">{{ $attributeGroup->label }}</h3>
                        @foreach($model->getAttributesForGroup($attributeGroup)->sortBy('sort_order') as $attribute)
                            @if($attribute->type === 'file')
                                <div class="row zebra">
                                    <div class="col-md-3">{!! $attribute->label !!} : </div>
                                    <div class="col-md-5"><a href="{{ $attribute->getValue()['filelink']}}"><strong>{{$attribute->getValue()['filename']}}</strong></a></div>
                                </div>
                            @else
                                @if($attribute->name != 'password')
                                    <div class="row zebra">
                                        <div class="col-md-3">{!! $attribute->label !!} : </div>
                                        <div class="col-md-5"><strong>{{$attribute->getText()}}</strong></div>
                                    </div>
                                @endif
                            @endif

                        @endforeach
                        <div style="margin-bottom: 20px"></div>
                    @endforeach
                @else
                    @foreach($model->getAttributes() as $attribute)
                        @if($attribute->type === 'file')
                            <div class="row zebra">
                                <div class="col-md-3">{!! $attribute->label !!} : </div>
                                <div class="col-md-5"><a href="{{ $attribute->getValue()['filelink']}}"><strong>{{$attribute->getValue()['filename']}}</strong></a></div>
                            </div>
                        @else
                            @if($attribute->name != 'password')
                                <div class="row zebra">
                                    <div class="col-md-3">{!! $attribute->label !!} : </div>
                                    <div class="col-md-5"><strong>{{$attribute->getText()}}</strong></div>
                                </div>
                            @endif
                        @endif

                    @endforeach
                @endif
            </div>

            <div class="col-md-4">
                <div class="row justify-content-center">
                    <p class="column-title">Situacije</p>
                </div>
                @foreach($situations as $situation)
                    <div class="row">
                        <div class="col event-time">{{ $situation->getData()['occurred_at'] }}</div>
                        <div class="col event-name"><a href="{{ route('situations.show', $situation->getData()['id']) }}">{{ $situation->getData()['description'] }}</a></div>
                    </div>
                @endforeach
                @yield('extras')
            </div>
        </div>
        <div class="button-bar" style="text-align: center">
            @yield('returns')
        </div>

    </div>
@endsection
