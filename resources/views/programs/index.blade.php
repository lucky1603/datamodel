@extends('layouts.hyper-vertical-mainframe')

@section('page-header')
    <span class="h4" style="position: relative; top:3vh; left: 2vh">{{ mb_strtoupper(__('Program List')) }}</span>
@endsection

@section('content')
    @php
        if(\Illuminate\Support\Facades\Session::has('program_type'))
            $program_type = \Illuminate\Support\Facades\Session::get('program_type');
        else
            $program_type = 0;

        if(\Illuminate\Support\Facades\Session::has('program_name'))
            $name = \Illuminate\Support\Facades\Session::get('program_name');
        else
            $name = '';

        if(\Illuminate\Support\Facades\Session::has('program_status')) {
            $program_status = \Illuminate\Support\Facades\Session::get('program_status');
        } else {
            $program_status = 0;
        }

        if(\Illuminate\Support\Facades\Session::has('page')) {
            $page = \Illuminate\Support\Facades\Session::get('page');
        } else {
            $page = 1;
        }

        if(\Illuminate\Support\Facades\Session::has('year')) {
            $year =  \Illuminate\Support\Facades\Session::get('year');
        } else {
            $year = 0;
        }

        $alltogether = [
            'page' => $page,
            'status' => $program_status,
            'name' => $name,
            'type' => $program_type,
            'year' => $year
        ] ;

    @endphp
    <program-explorer-table-view
        page_size="15"
        f_name="{{ $name }}"
        :f_program_type="{{ $program_type }}"
        :f_program_status="{{ $program_status }}" :f_page="{{ $page }}" :f_year="{{ $year }}">
    </program-explorer-table-view>
@endsection

