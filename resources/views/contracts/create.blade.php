@extends('layouts.create')

@section('title')
    <h1 style="text-align: center">Dodavanje novog ugovora</h1>
    <p style="text-align: center">između</p>
    <h3 style="text-align: center">NTP Beograd</h3>
    <p style="text-align: center">i</p>
    <h3 style="text-align: center">{{ $client->getData()['name'] }}</h3>
@endsection
