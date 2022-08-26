@extends('layouts.hyper-vertical-mainframe')

@section('content')
    @yield('profile-content')
@endsection

@php
    $profile_status = $model->getValue('profile_status');
@endphp

@section('sidemenu')
    @if(\Illuminate\Support\Facades\Auth::user()->isAdmin())
        <li class="side-nav-item">
            <a href="{{ route('profiles.index') }}" class="side-nav-link">
                <i class="uil-backspace"></i>
                <span>{{ mb_strtoupper(__('Back to List')) }}</span>
            </a>
        </li>
    @else
        <li class="side-nav-item">
            <a href="{{route('profiles.show', ['profile' => $model->getId()])}}" class="side-nav-link">
                <i class="uil-user"></i>
                <span>{{ mb_strtoupper( __('Moji podaci')) }}</span>
            </a>
        </li>

        <li class="side-nav-item">
            <a href="javascript:void(0);" class="side-nav-link" aria-expanded="false">
                <i class="uil-laptop-cloud"></i>
                <span>{{ mb_strtoupper( __('Moji programi') ) }}</span>
                <span class="menu-arrow"></span>
            </a>
            @php
                $programs = $model->getPrograms();
            @endphp

            <ul class="side-nav-second-level mm-collapse" aria-expanded="false">
                @if(count($programs) > 0)
                    @foreach($programs as $program)
                        <li>
                            <div class="d-flex justify-content-start">
                                <a href="{{ route('programs.profile', ['program' => $program->getId()]) }}">
                                    {{ mb_strtoupper($program->getValue('program_name')) }}
                                    @if ($program->hasReportAlert())
                                        <img src="/images/custom/Button-warning-icon.png" style="height: 20px" title="Podsetnik za slanje izveštaja">
                                    @endif
                                </a>
                            </div>

                        </li>
                    @endforeach
                @endif
                <li><a href="{{ route('programs.create') }}">{{ mb_strtoupper(__("New Program")) }}</a></li>
            </ul>
        </li>

        <li class="side-nav-item" id="navOtherProfiles">
            <a href="{{ route('profiles.otherCompanies', ['profile' => $model->getId()]) }}" class="side-nav-link">
                <i class="uil-bag"></i>
                <span>{{ mb_strtoupper( __('Other Profiles')) }}</span>
            </a>
        </li>
    @endif
@endsection



