@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h1 class="page-title">{{ $model->getData()['name'] }}</h1>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="row justify-content-center">
                    <p class="column-title">Detalji</p>
                </div>

                @foreach($model->getAttributes() as $attribute)
                    @if($attribute->type === 'file')
                        <div class="row zebra">
                            <div class="col-md-3">{{ $attribute->label }} : </div>
                            <div class="col-md-5"><a href="{{ $attribute->getValue()['filelink']}}"><strong>{{$attribute->getValue()['filename']}}</strong></a></div>
                        </div>
                    @else
                        <div class="row zebra">
                            <div class="col-md-3">{{ $attribute->label }} : </div>
                            <div class="col-md-5"><strong>{{$attribute->getText()}}</strong></div>
                        </div>
                    @endif

                @endforeach
            </div>

            <div class="col-md-4">
                <div class="row justify-content-center">
                    <p class="column-title">Aktivnosti</p>
                </div>
                @foreach($events as $event)
                    <div class="row">
                        <div class="col event-time">{{$event->getData()['occurred_at']}}</div>
                        <div class="col event-name">{{ $event->getData()['name'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="button-bar" style="text-align: center">
            @yield('returns')
        </div>

    </div>
@endsection
