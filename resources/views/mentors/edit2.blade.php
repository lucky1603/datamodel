@extends('layouts.hyper-vertical')

@php
    $locale = session('locale');
    if($locale == null) {
        $locale = app()->getLocale();
    } else {
        app()->setLocale($locale);
    }

@endphp

@section('content')
    {{-- @include('mentors.form.mentor-form-dlg', ['action' => route('mentors.update'), 'showCommands' => false, 'showTitle' => false]) --}}

    <mentor-form :mentor_id="{{ $mentor->getId() }}" token={{ csrf_token()}} action="/mentors/edit"></mentor-form>
@endsection


