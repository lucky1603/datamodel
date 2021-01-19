@extends('layouts.hyper-vertical-mainframe')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card m-5 shadow-lg">
                <div class="card-header bg-dark text-light">{{ __('CLIENTS') }}</div>
                <div class="card-body">
                    <a href="{{ route('clients.index') }}"><img src="images/custom/clients.png" width="100%"/></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card m-5 shadow">
                <div class="card-header bg-dark text-light">{{ __('CONTRACTS') }}</div>
                <div class="card-body">
                    <a href="{{ route('contracts.index') }}"><img src="images/custom/contract.png" width="100%"/></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card m-5">
                <div class="card-header bg-dark text-light">{{ __('EVENTS') }}</div>
                <div class="card-body">
                    <img src="images/custom/events.png" width="100%"/>
                </div>
            </div>
        </div>
    </div>
{{--    <example-component style="margin-top: 20px">Anything else.</example-component>--}}

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            if(!$('#link_home').hasClass('active')) {
                $('#link_home').addClass('active');
            }

            if($('#link_clients').hasClass('active')) {
                $('#link_clients').removeClass('active');
            }

            if($('#link_contracts').hasClass('active')) {
                $('#link_contracts').removeClass('active');
            }
        });
    </script>
@endsection



