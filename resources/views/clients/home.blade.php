@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center" style="margin-bottom: 30px">
            <h1>{{ $client->getData()['name'] }}</h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">{{ __('Client Profile') }}</div>

                    <div class="card-body">
                        <a href="{{ route('clients.show', $client->getId()) }}"><img src="images/clients.png"/></a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">{{ __('Situations') }}</div>
                    <a href="{{ route('contracts.index') }}"><img src="images/contract.png"/></a>
                    <div class="card-body">

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">{{ __('Contract Realization') }}</div>
                    <img src="images/events.png"/>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
