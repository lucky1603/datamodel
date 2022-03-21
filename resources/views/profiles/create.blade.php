@extends('layouts.hyper-vertical')

{{--@section('page-title')--}}
{{--    {{ mb_strtoupper(__('Add Profile')) }}--}}
{{--@endsection--}}

@section('page-header')
    <span class="h4" style="position: relative; top:3vh; left: 2vh">{{ mb_strtoupper(__('Add Profile')) }}</span>
@endsection

@section('content')
    @php
        foreach (['name', 'profile_state', 'is_company', 'ntp', 'page'] as $key) {
            \Illuminate\Support\Facades\Session::forget($key);
        }
    @endphp

{{--    <div class="container">--}}
{{--        @include('profiles.partials._profile_create_form')--}}
{{--    </div>--}}

    <profile-form :token="{{ $token }}" :show_buttons="true" style="margin: 50px 200px 50px 200px"></profile-form>
@endsection

@section('sidemenu')
        <li class="side-nav-item">
            <a href="{{ route('profiles.create') }}" class="side-nav-link">
                <i class="uil-user-plus"></i>
                <span>{{ mb_strtoupper( __('New Profile')) }}</span>
            </a>
        </li>
        <li>
            <a href="{{route('profiles.index')}}" class="side-nav-link">
                <i class="uil-list-ul"></i>
                <span>{{ mb_strtoupper( __('Back to List')) }}</span>
            </a>
        </li>

@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#cancel').click(function() {
                history.go(-1);
            }) ;

            if($('#is_company').prop('checked') == true) {
                $('#nameCol').removeClass('col-lg-12').addClass('col-lg-6');
                $('#idNumberCol').show();
            } else {
                $('#idNumberCol').hide();
                $('#nameCol').removeClass('col-lg-6').addClass('col-lg-12');
            }

            $('#is_company').on('change', function(event) {
                if($(this).prop('checked') == true) {
                    $('#nameCol').removeClass('col-lg-12').addClass('col-lg-6');
                    $('#idNumberCol').show();
                } else {
                    $('#idNumberCol').hide();
                    $('#nameCol').removeClass('col-lg-6').addClass('col-lg-12');
                }
            });
        });
    </script>

@endsection
