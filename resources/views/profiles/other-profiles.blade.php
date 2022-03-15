@extends('layouts.hyper-vertical-profile')

@section('page-header')
    <div class="w-50 d-inline-block" style="height: 7vh">
        <div><span class="h4" style="position: relative; top:2vh; left: 1vh">{{ $model->getValue('name') }}</span></div>
        <div><span class="text-primary font-12" style="position: relative; top: 2vh; left: 1vh">{{ mb_strtoupper($model->getText('profile_state')) }}</span></div>
    </div>
@endsection

@section('profile-content')
    <profile-explorer-table-view
        :page_size="20"
        class="h-auto"
        source="/profiles/otherCompanies/{{ $model->getId() }}" :show_header="false" role="{{ $role }}"
    ></profile-explorer-table-view>
@endsection
