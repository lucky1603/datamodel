@extends('layouts.hyper-vertical-mainframe')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-4">
            <profile-card title="{{ __('CLIENTS') }}" class="m-5" :hasFooter="false">
                <a href="{{ route('clients.index') }}"><img src="images/custom/clients.png" width="100%"/></a>
            </profile-card>
        </div>
        <div class="col-md-4">
            <profile-card title="{{ __('CONTRACTS')}}" class="m-5" :hasFooter="false">
                <a href="{{ route('contracts.index') }}"><img src="images/custom/contract.png" width="100%"/></a>
            </profile-card>
        </div>
        <div class="col-md-4">
            <profile-card title="{{ __('EVENTS') }}" class="m-5" :hasFooter="false">
                <img src="images/custom/events.png" width="100%"/>
            </profile-card>
        </div>
    </div>
{{--    <div class="row">--}}
{{--        <div class="col-md-4"></div>--}}
{{--        <div class="col-md-4">--}}
{{--            <profile-card title="{{ __('CONTRACTS')}}" class="m-5" :hasFooter="false">--}}
{{--                <a href="{{ route('contracts.index') }}"><img src="images/custom/contract.png" width="100%"/></a>--}}
{{--                <template slot="footer">--}}
{{--                    <button class="btn btn-success">Ok</button>--}}
{{--                </template>--}}
{{--            </profile-card>--}}
{{--        </div>--}}
{{--        <div class="col-md-4"></div>--}}
{{--    </div>--}}
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



