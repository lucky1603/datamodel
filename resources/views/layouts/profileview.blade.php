@extends('layouts.userwithoutsidebar')

@section('content')
    {{--    <div class="row" >--}}
{{--            <div class="col-3 layout-column sidebar" style="background-color: blue; height: 100%">--}}
{{--                <div class="card" style="margin-top: 10px">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="image-container">--}}
{{--                            <img class="image-container-profile" src="@yield('profile_image')" >--}}
{{--                            <img class="shadow image-container-logo" src="@yield('logo_image')" >--}}
{{--                        </div>--}}
{{--                        @yield('client_short_data')--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--                <div class="card" style="margin-top: 10px">--}}
{{--                    <div class="card-header">--}}
{{--                        <strong>{{ __('SUPPORT TEAM') }}</strong>--}}
{{--                    </div>--}}
{{--                    <div class="card-body">--}}
{{--                        @yield('users')--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="col layout-column" >--}}
{{--                <div class="card shadow" style="margin-top: 10px">--}}
{{--                    <div class="card-body" >--}}
{{--                        <nav class="nav">--}}
{{--                            <a class="nav-link active" href="#">{{ __('Application') }}</a>--}}
{{--                            <a class="nav-link" href="#">{{ __('Events') }}</a>--}}
{{--                        </nav>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}
    <div class="panel-left">
    </div>
    <div class="panel-right">

    </div>
@endsection
@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#accordion').accordion();
        });
    </script>
@endsection
