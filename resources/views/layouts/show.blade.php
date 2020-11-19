@extends('layouts.user')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 column-no-padding">
                <div class="card" style="margin-bottom: 10px">
                    <div class="card-body">
                        <div class="clearfix">
                            <p style="margin: 0px">CLIENT PROFILE</p>
                            <h1 class="float-left" style="margin: 0px">{{ $model->getData()['name'] }}</h1>
                            @yield('returns')
                        </div>


                    </div>

                </div>
            </div>
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
                        <h3 class="group-title">{{ $attributeGroup->label }}</h3>
                        @foreach($model->getAttributesForGroup($attributeGroup)->sortBy('sort_order') as $attribute)
                            @if($attribute->type === 'file')
                                <div class="row zebra">
                                    <div class="col-md-3"><strong>{!! $attribute->label !!} : </strong></div>
                                    <div class="col-md-5"><a href="{{ $attribute->getValue()['filelink']}}">{{$attribute->getValue()['filename']}}</a></div>
                                </div>
                            @else
                                @if($attribute->name != 'password')
                                    <div class="row zebra">
                                        <div class="col-md-3"><strong>{!! $attribute->label !!} : </strong></div>
                                        <div class="col-md-5">{{$attribute->getText()}}</div>
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
                                <div class="col-md-3"><strong>{!! $attribute->label !!} : </strong></div>
                                <div class="col-md-5"><a href="{{ $attribute->getValue()['filelink']}}">{{$attribute->getValue()['filename']}}</a></div>
                            </div>
                        @else
                            @if($attribute->name != 'password')
                                <div class="row zebra">
                                    <div class="col-md-3"><strong>{!! $attribute->label !!} : </strong></div>
                                    <div class="col-md-5">{{$attribute->getText()}}</div>
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


    </div>
@endsection
