@extends('layouts.show')

@section('head')
    <div style="text-align: center">između</div>
    <h3 style="text-align: center">NTP Beograd</h3>
    <div style="text-align: center">i</div>
    <h3 style="text-align: center"><a href="{{ route('clients.show', $client->getId()) }}">{{ $client->getData()['name'] }}</a></h3>
    <div style="height: 30px"></div>
@endsection

@section('returns')
    <a href="{{ request()->session()->get('backroute') }}" class="btn btn-lg btn-link btn-outline-info">Back</a>
@endsection
