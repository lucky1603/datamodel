@extends('layouts.hyper-vertical-profile-shortdata')

@section('profile-content')
    @php
        $status = $model->getValue('profile_status');
    @endphp
    @if(in_array($status, [1,2]))
        @yield('status')
    @elseif($status >= 3)
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
            <div class="tab-pane h-100 overflow-auto" id="current_status">
                @yield('status')
            </div>
        </div>
{{--    @else--}}
{{--        @yield('application-data')--}}
    @endif

@endsection
