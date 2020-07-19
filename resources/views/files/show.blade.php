@extends('layouts.app')

@section('content')
    The uploaded file is <a href="{{ $filelink }}">{{ $filename }}</a>
@endsection
