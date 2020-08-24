@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Clients') }}</div>

                <div class="card-body">
                    <a href="{{ route('clients.index') }}"><img src="images/clients.png"/></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Contracts') }}</div>
                    <a href="{{ route('contracts.index') }}"><img src="images/contract.png"/></a>
                <div class="card-body">

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Events') }}</div>
                    <img src="images/events.png"/>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
