@extends('layouts.hyper-vertical')

@section('content')
    @include('mentors.form.mentor-form', ['action' => route('mentors.update'), 'showCommands' => false, 'showTitle' => false])
@endsection


