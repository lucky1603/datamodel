@extends('layouts.hyper-vertical')

@section('page-header')
    <span class="h4" style="position: relative; top:3vh; left: 2vh">{{ mb_strtoupper(__('Change Training')) }}</span>
@endsection

@section('content')
    <div class="container">
        <event-modifier token="{{ $token }}" event_id="{{ $event_id }}"></event-modifier>
    </div>
@endsection


@section('sidemenu')
    <li class="side-nav-item">
        <a href="{{ route('trainings.show', ['training' => $event_id]) }}" class="side-nav-link">
            <i class="uil-laptop-cloud"></i>
            <span>{{ mb_strtoupper(__('Back to Event')) }}</span>
        </a>
    </li>
@endsection
