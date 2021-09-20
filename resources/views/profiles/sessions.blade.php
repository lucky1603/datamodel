@extends('layouts.hyper-vertical-profile')

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
