@extends('layouts.hyper-vertical-mainframe')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ strtoupper( __('Profiles')) }}</div>
                <div class="card-body"><a href="{{ route('profiles.index') }}"><img src="images/custom/clients.png" width="100%"/></a></div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Users')}}</div>
                <div class="card-body"><a href="{{ route('users') }}"><img src="images/custom/contract.png" width="100%"/></a></div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Sessions') }}</div>
                <div class="card-body"><a href="{{ route('trainings') }}"><img src="images/custom/events.png" width="100%"/></a></div>
            </div>

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



