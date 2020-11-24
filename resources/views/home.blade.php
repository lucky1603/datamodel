@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Clients') }}</div>

                <div class="card-body">
                    <a href="{{ route('clients.index') }}"><img src="images/custom/clients.png"/></a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Contracts') }}</div>
                    <a href="{{ route('contracts.index') }}"><img src="images/custom/contract.png"/></a>
                <div class="card-body">

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Events') }}</div>
                    <img src="images/custom/events.png"/>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
{{--    <example-component style="margin-top: 20px">Anything else.</example-component>--}}
</div>
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



