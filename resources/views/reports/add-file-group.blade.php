@extends('layouts.hyper-vertical')

@section('content')
    <file-group-editor title="{{ $title }}" token="{{ $token }}" report-id="{{ $reportId }}"></file-group-editor>
@endsection
