@extends('layouts.hyper-vertical-profile-shortdata')

@section('profile-content')
    @php
        $status = $program->getStatus();
    @endphp
    @if($status == 1)
        @yield('status')
    @else
        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
            <li class="nav-item">
                <a href="#application" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                    <i class="mdi mdi-view-list d-md-none d-block"></i>
                    <span class="d-none d-md-block">Podaci iz prijave</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#current_status" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                    <i class="mdi mdi-list-status d-md-none d-block"></i>
                    <span class="d-none d-md-block">STATUS</span>
                </a>
            </li>
        </ul>

        <div class="tab-content" style="height: 90%">
            <div class="tab-pane show active h-100 overflow-auto"  id="application">
                @yield('application-data')
            </div>
            <div class="tab-pane " id="current_status">
                @yield('status')
            </div>
        </div>
    @endif
{{--    @else--}}
{{--        @yield('application-data')--}}


@endsection
