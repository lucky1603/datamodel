@extends('layouts.hyper-vertical')

@section('content')
    <mentor-sessions
        :mentorid="{{ $mentorId }}"
        usertype="{{ \Illuminate\Support\Facades\Auth::user()->roles->first()->name }}"></mentor-sessions>
@endsection

@section('sidemenu')
    <li class="side-nav-item" id="navProfile">
        <a href="{{ route('mentors.profile', ['mentor' => $mentorId]) }}" class="side-nav-link">
            <i class="uil-user"></i>
            <span>{{ mb_strtoupper( __('Mentor Profile')) }}</span>
        </a>
    </li>
    <li class="side-nav-item mm-active" id="navSessions">
        <a href="{{ route('mentors.ownsessions', ['mentor' => $mentorId]) }}" class="side-nav-link">
            <i class="uil-user"></i>
            <span>{{ mb_strtoupper( __('Mentor Sessions')) }}</span>
        </a>
    </li>
    <li class="side-nav-item" id="navGoBack">
        <a href="{{route('mentors.index')}}" class="side-nav-link">
            <i class="uil-backward"></i>
            <span>{{ mb_strtoupper( __('Back to List')) }}</span>
        </a>
    </li>
@endsection

@section ('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            // $('.side-nav-item').each(function(index) {
            //     if($(this).attr('id') == 'navSessions' && !$(this).hasClass('mm_active')) {
            //         $(this).addClass('mm_active');
            //     } else if($(this).hasClass('mm_active')) {
            //         $(this).removeClass('mm_active');
            //     }
            // });

        });
    </script>
@endsection


