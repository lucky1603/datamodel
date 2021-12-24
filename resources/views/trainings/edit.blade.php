@extends('layouts.hyper-vertical')

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
