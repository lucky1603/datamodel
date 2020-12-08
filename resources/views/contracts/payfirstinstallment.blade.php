@extends('layouts.app')

@section('content')
    <div class="container">
    <div class="justify-content-center">
        <div class="col-12">
            <h1 class="text-center mt-3 mb-5">{{ __('First Installment Payment') }} - {{ $client->getData()['name'] }}</h1>
        </div>
    </div>
    <form method="POST" enctype="multipart/form-data" action="{{ route('contracts.firstinstallmentpayed', $contract->getId()) }}">
        @csrf
        <input type="hidden" name="full_amount" id="full_amount" value="{{ $full_amount }}">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-6">
                    <label>{{__('Contract Number')}}:</label>
                    <input type="text" id="contract_number" class="form-control" name="contract_number">
                </div>
                <div class="col-sm-6">
                    <label >{{__('Amount')}}:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{ $contract->getData()['currency'] }}</span>
                        </div>
                        <input type="text" class="form-control" id="amount" name="amount">
                    </div>
                </div>
            </div>

        </div>

        <div class="form-group">
            <div class="row">
                <div class="col-4">
                    <label >{{__('Payed')}}:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{ $contract->getData()['currency'] }}</span>
                        </div>
                        <input type="text" class="form-control" id="payed" name="payed">
                    </div>
                </div>
                <div class="col-4">
                    <label >{{__('On Hold')}}:</label>
                        <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{ $contract->getData()['currency'] }}</span>
                        </div>
                        <input type="text" class="form-control" id="on_hold" name="on_hold">
                    </div>
                </div>
                <div class="col-4">
                    <label >{{__('Remains')}}:</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{ $contract->getData()['currency'] }}</span>
                        </div>
                        <input type="text" class="form-control" id="remains" name="remains">
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-6">
                <button type="submit" class="btn btn-primary float-right" >Prihvati</button>
            </div>
            <div class="col-sm-6">
                <a href="{{ route('contracts.show', $contract->getId()) }}" class="btn btn-dark float-left">Nazad</a>
            </div>
        </div>

    </form>
    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
           $('#payed').on('focusout', function (evt) {
               alert('updated');
              var payed = parseFloat($('#payed').val());
              var full = parseFloat($('#full_amount').val());
              console.log("Full je " + full);
              console.log('Payed is ' + payed);
           });
        });
    </script>
@endsection
