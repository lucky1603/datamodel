@extends('layouts.app')

@section('content')
    <div class="container">
    <div class="justify-content-center">
        <div class="col-12">
            <h1 class="text-center mt-3 mb-5">{{ __('First Installment Payment') }} - {{ $client->getData()['name'] }}</h1>
        </div>
    </div>
    <form method="POST" enctype="multipart/form-data" action="{{ route('contracts.firstinstallmentpayed', $contract->getId()) }}" id="fazaI" class="contract-status-form">
        @csrf
        <input type="hidden" name="full_amount" id="full_amount" value="{{ $full_amount }}">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-6">
                    <label>{{__('Contract Number')}}:</label>
                    <input type="text" id="contract_number" class="form-control" name="contract_number" value="{{ $contract->getData()['contract_number'] }}" disabled>
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

                        <input type="text" class="form-control" id="remains_readonly" name="remains_readonly" disabled>
                        <input type="hidden" id="remains" name="remains" >
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
            $('#remains').val($('#full_amount').val());
            $('#amount').val(0.0);
            $('#payed').val(0.0);
            $('#on_hold').val(0.0);

            $('#amount').on('focusout', function(evt) {
               $('#remains').val($('#full_amount').val() - $('#amount').val());
               $('#payed').val($('#amount').val());
            });

           $('#payed').on('focusout', function (evt) {
               var payed = $('#payed').val();
               var amount = $('#amount').val();

               if(payed > amount) {
                   $('#payed').val(amount);
                   payed = $('#payed').val();
               }

               $('#on_hold').val(amount - payed);
           });

           $('#on_hold').on('focusout', function() {
               var on_hold = $('#on_hold').val();
               var amount = $('#amount').val();

               if(on_hold > amount) {
                   on_hold = amount;
                   $('#on_hold').val(on_hold);
               }

               $('#payed').val(amount - on_hold);
           })
        });
        $('#mainForm').on('loaded', function() {
            alert('woho!');
        })
    </script>
@endsection
