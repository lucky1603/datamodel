@extends('layouts.hyper-vertical-mainframe')

@section('page-title')
    {{ mb_strtoupper(__('Company List')) }}
@endsection

@section('content')
    @php
        if(\Illuminate\Support\Facades\Session::has('profile_state'))
            $profile_state = \Illuminate\Support\Facades\Session::get('profile_state');
        else
            $profile_state = 0;

        if(\Illuminate\Support\Facades\Session::has('name'))
            $name = \Illuminate\Support\Facades\Session::get('name');
        else
            $name = '';

        if(\Illuminate\Support\Facades\Session::has('ntp')) {
            $ntp = \Illuminate\Support\Facades\Session::get('ntp');
        } else {
            $ntp = 0;
        }

        if(\Illuminate\Support\Facades\Session::has('is_company')) {
            $is_company = \Illuminate\Support\Facades\Session::get('is_company');
        } else {
            $is_company = -1;
        }

        if(\Illuminate\Support\Facades\Session::has('page')) {
            $page = \Illuminate\Support\Facades\Session::get('page');
        } else {
            $page = 1;
        }


    @endphp
    <profile-explorer
        class="h-auto"
        f_profile_state="{{ $profile_state }}"
        f_name="{{ $name }}"
        f_ntp="{{ $ntp }}"
        f_is_company="{{ $is_company }}" f_page="{{ $page }}">
    </profile-explorer>
@endsection



