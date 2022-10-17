@extends('layouts.hyper-vertical')

@php
    $locale = session('locale');
    if($locale == null) {
        $locale = app()->getLocale();
    } else {
        app()->setLocale($locale);
    }

@endphp

@php
    $program = $report->programBO();
@endphp

@section('content')
    <mentor-report-editor
        report_id="{{ $report->id }}"
        backroute="{{ route('mentors.ownsessions', ['mentor' => $report->mentor->id]) }}">
    </mentor-report-editor>
@endsection

@section('sidemenu')
    <li class="side-nav-item">
        <a href="/mentors/ownsessions/{{ $report->mentor->id }}" class="side-nav-link">
            <i class="uil-laptop-cloud"></i>
            <span>{{ mb_strtoupper(__('Back to Reports')) }}</span>
        </a>
    </li>
@endsection
