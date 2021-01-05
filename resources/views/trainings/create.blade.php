@extends('layouts.hyper-vertical')

@section('content')
    <div class="pt-0 pb-0 pl-2 pr-2 shadow-sm bg-white" style="display: table; width: 100%">
        <h4 style="display: table-column; float: left">{{ __('New Event') }}</h4>
        <a href="{{ route('trainings') }}" class="btn btn-sm btn-success" style="display: table-column; float: right">{{ __('Go Back') }}</a>
    </div>
@endsection
