@extends('layouts.hyper-vertical')

@section('content')
    <div class="container">
        <event-generator token="{{ $token }}"></event-generator>
    </div>
@endsection


@section('sidemenu')
    <li class="side-nav-item">
        <a href="{{ route('trainings') }}" class="side-nav-link">
            <i class="uil-laptop-cloud"></i>
            <span>{{ strtoupper(__('Back to Sessions')) }}</span>
        </a>
    </li>
@endsection
