@extends('layouts.hyper-vertical-mainframe')

@section('content')
    <div>
        <ul class="nav float-right page-title-right" >
            <li class="nav-item">
                <a
                    class="nav-link text-muted"
                    id="newMenthor"
                    href="{{ route('menthors.create') }}"
                    role="button" data-toggle="modal" data-target="#dialogHost">
                    <i class="dripicons-user font-20"></i><span class="ml-0 mt-2 font-weight-bold"> {{mb_strtoupper(__('New Menthor'))}}</span>
                </a>
            </li>
        </ul>
        <ul class="nav page-title">
            <li class="nav-item position-relative" style="top: 4px"><label>{{mb_strtoupper( __('Search')) }}</label></li>
            <li class="nav-item ml-2">
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text small">{{ __('By Name') }}</span>
                    </div>
                    <input type="text" id="menthorSearch" name="menthorSearch" class="form-control" placeholder="{{ __('Search...') }}" >
                </div>
            </li>
            <li class="nav-item ml-2">
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text small">{{ __('By Specialization') }}</span>
                    </div>
                    <select name="menthorSpec" id="menthorSpec" class="form-control form-control-sm">
                        <option value="0">{{ __('Please select ...') }}</option>
                        <option value="1">{{ __('gui-select.BB-IOT') }}</option>
                        <option value="2">{{ __('gui-select.BB-EnEff') }}</option>
                        <option value="3">{{ __('gui-select.BB-AI') }}</option>
                        <option value="4">{{ __('gui-select.BB-NewMat') }}</option>
                        <option value="5">{{ __('gui-select.BB-vEcoTrans') }}</option>
                        <option value="6">{{ __('gui-select.BB-RoboAuto') }}</option>
                        <option value="7">{{ __('gui-select.BB-Tourism') }}</option>
                        <option value="8">{{ __('gui-select.BB-Education') }}</option>
                        <option value="9">{{ __('gui-select.BB-MediaGaming') }}</option>
                        <option value="10">{{ __('gui-select.BB-TechSport') }}</option>
                        <option value="11">{{ __('gui-select.BB-MedTech') }}</option>
                        <option value="12">{{ __('gui-select.BB-Other') }}</option>
                    </select>
                </div>
            </li>
        </ul>
    </div>
    <hr/>
    @foreach($menthors as $menthor)
        @if($loop->index % 6 == 0)
            <div class="row">
        @endif

        <div class="col-lg-2">
            <div class="card shadow">
                <div class="card-header p-0">
                    <img src="@if($menthor->getAttribute('photo') != null && strlen($menthor->getValue('photo')['filelink']) > 0) {{ $menthor->getValue('photo')['filelink'] }} @else /images/custom/nophoto2.png @endif" class="w-100"/>
                </div>
                <div class="card-body text-center">
                    <h4 class="text-center">{{ $menthor->getValue('name') }}</h4>
                    <a class="text-center" href="mailto://{{$menthor->getValue('email')}}" target="_blank">{{ $menthor->getValue('email') }}</a>
                    <p class="text-center">{{ $menthor->getValue('phone') }}</p>
                </div>
            </div>
        </div>

        @if($loop->index % 4 == 3 || $loop->iteration == $menthors->count() )
            </div>
        @endif
    @endforeach
@endsection
