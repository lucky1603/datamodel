@extends('layouts.hyper-vertical-mainframe')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-4">
            <profile-card title="{{ strtoupper( __('Profiles')) }}" class="m-5" :hasFooter="false">
                <a href="{{ route('profiles.index') }}"><img src="images/custom/clients.png" width="100%"/></a>
            </profile-card>
        </div>
        <div class="col-md-4">
            <profile-card title="{{ __('Users')}}" class="m-5" :hasFooter="false">
                <a href="{{ route('users') }}"><img src="images/custom/contract.png" width="100%"/></a>
            </profile-card>
        </div>
        <div class="col-md-4">
            <profile-card title="{{ __('Sessions') }}" class="m-5" :hasFooter="false">
                <a href="{{ route('trainings') }}"><img src="images/custom/events.png" width="100%"/></a>
            </profile-card>
        </div>
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



