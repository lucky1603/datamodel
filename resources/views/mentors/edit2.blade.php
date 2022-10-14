@extends('layouts.hyper-vertical')

@section('content')
    {{-- @include('mentors.form.mentor-form-dlg', ['action' => route('mentors.update'), 'showCommands' => false, 'showTitle' => false]) --}}

    <mentor-form :mentor_id="{{ $mentor->getId() }}" token={{ csrf_token()}} action="/mentors/edit"></mentor-form>
@endsection


