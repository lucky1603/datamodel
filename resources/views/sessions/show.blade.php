@extends('layouts.hyper-vertical')

@section('content')
    <div>
        <h2>{{ $session->getText('session_title') }}</h2>
        <div class="row">
            <div class="col-lg-4">
                <h4>{{ $session->getAttribute('session_start_date')->label }}</h4>
                <p>{{ $session->getText('session_start_date') }}</p>
            </div>
            <div class="col-lg-4">
                <div class="col-lg-3">
                    <h4>{{ $session->getAttribute('session_start_time')->label }}</h4>
                    <p>{{ $session->getText('session_start_date') }}</p>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="col-lg-3">
                    <h4>{{ $session->getAttribute('session_duration')->label }}</h4>
                    <div><span>{{ $session->getText('session_start_date') }} {{ $session->getText('session_duration_unit') }}</span></div>
                </div>
            </div>
        </div>
        <div>
            <h4>{{ $session->getAttribute('session_short_note')->label }}</h4>
            <p>{{ $session->getText('session_short_note') }}</p>
        </div>
    </div>
@endsection
