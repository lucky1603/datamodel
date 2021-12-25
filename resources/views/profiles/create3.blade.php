@extends('layouts.hyper-vertical')

@section('page-title')
    {{ mb_strtoupper(__('Add Profile')) }}
@endsection

@section('content')
    <div class="container">
        @include('profiles.partials._profile_create_form')
    </div>
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