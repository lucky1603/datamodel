@extends('layouts.show')

@section('head')
    <p style="text-align: center">između</p>
    <h3 style="text-align: center">NTP Beograd</h3>
    <p style="text-align: center">i</p>
    <h3 style="text-align: center">{{ $client->getData()['name'] }}</h3>
@endsection

@section('returns')
    <a href="{{ route('contracts.index') }}" class="btn btn-lg btn-link btn-outline-info">Back</a>
@endsection
