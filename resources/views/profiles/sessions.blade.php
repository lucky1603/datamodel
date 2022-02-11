@extends('layouts.hyper-vertical-profile')

{{--@section('page-title')--}}
{{--    {{ $model->getValue('name') }}--}}
{{--@endsection--}}

@section('page-header')
    <div class="w-50 d-inline-block" style="height: 7vh">
        <div><span class="h4" style="position: relative; top:2vh; left: 1vh">{{ $model->getValue('name') }}</span></div>
        <div><span class="text-primary font-12" style="position: relative; top: 2vh; left: 1vh">{{ mb_strtoupper($model->getText('profile_state')) }}</span></div>
    </div>
@endsection

@section('profile-content')
    <program-sessions
        :programid="{{ $model->getActiveProgram()->getId() }}"
            usertype="{{ $model->getUsers()->first()->roles->first()->name }}"></program-sessions>
@endsection
@section ('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.side-nav-item').each(function(index) {
                if($(this).attr('id') == 'navSessions' && !$(this).hasClass('mm_active')) {
                    $(this).addClass('mm_active');
                } else if($(this).attr('id') != 'navReports' && $(this).hasClass('mm_active')) {
                    $(this).removeClass('mm_active');
                }
            });

        });
    </script>
@endsection
