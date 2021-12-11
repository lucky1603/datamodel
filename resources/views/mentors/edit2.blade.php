@extends('layouts.hyper-vertical')

@section('content')
    @include('mentors.form.mentor-form-dlg', ['action' => route('mentors.update'), 'showCommands' => false, 'showTitle' => false])
@endsection


