@extends('layouts.hyper-profile-admin')

@php
    $profile = $program->getProfile();
@endphp

@section('page-header')
    <div class="w-50 d-inline-block" style="height: 7vh">
        <div><span class="h4" style="position: relative; top:2vh; left: 1vh">{{ $profile->getValue('name') }}</span></div>
        <div><span class="text-primary font-12" style="position: relative; top: 2vh; left: 1vh">{{ mb_strtoupper($program->getStatusText()) }}</span></div>
    </div>
@endsection

@section('application-data')
    <div class="card shadow " style="height: 100%;overflow: auto">
        @php
            $status = $program->getStatus();
            $workflow = $program->getWorkflow();
        @endphp

        @if($status > 0)
            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                @for($i = 1; $i <= $status; $i++)

                    @php
                        $phase = $workflow->getPhase($i);
                    @endphp

                    @if($i < $status && !$phase->isVisibleInHistory())
                        @continue
                    @endif

                    <li class="nav-item">
                        <a href="{{ $phase->getDisplayId() }}" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 @if($i == 1 /* $status */) active @endif">
                            <i class="mdi mdi-face-agent d-md-none d-block"></i>
                            <span class="d-none d-md-block">{{ $phase->getDisplayName() }}</span>
                        </a>
                    </li>
                @endfor
            </ul>

            <div class="tab-content overflow-auto h-100">
                @for($i = 1; $i <= $status; $i++)
                    @php
                        $phase = $workflow->getPhase($i);
                        $attributesData = $phase->getAttributesData();
                        $attributesData['status'] = $status;
                        $attributesData['validStatus'] = $i;
                    @endphp

                    @if($i < $status && !$phase->isVisibleInHistory())
                        @continue
                    @endif

                    <div class="tab-pane @if($i == 1 /* $status */) show active @endif h-100 overflow-auto "  id="{{ ltrim($phase->getDisplayId(), '#') }}">
                        @include($phase->getDisplayForm(), $attributesData)
                    </div>
                @endfor
            </div>
        @elseif($status == -1)
            @php
                $phaseCount = $workflow->getPhases()->count();
            @endphp
            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                @for($i = 1; $i <= $phaseCount; $i++)

                    @php
                        $phase = $workflow->getPhase($i);
                    @endphp

                    @if(!$phase->isVisibleInHistory())
                        @continue
                    @endif

                    <li class="nav-item">
                        <a href="{{ $phase->getDisplayId() }}" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 @if($i == 1 /* $status */) active @endif">
                            <i class="mdi mdi-face-agent d-md-none d-block"></i>
                            <span class="d-none d-md-block">{{ $phase->getDisplayName() }}</span>
                        </a>
                    </li>
                @endfor
            </ul>
            <div class="tab-content overflow-auto h-100">
                @for($i = 1; $i <= $phaseCount; $i++)
                    @php
                        $phase = $workflow->getPhase($i);
                        $attributesData = $phase->getAttributesData();
                        $attributesData['status'] = $status;
                        $attributesData['validStatus'] = $i;
                    @endphp

                    @if(!$phase->isVisibleInHistory())
                        @continue
                    @endif

                    <div class="tab-pane @if($i == 1 /* $status */) show active @endif h-100 overflow-auto "  id="{{ ltrim($phase->getDisplayId(), '#') }}">
                        @include($phase->getDisplayForm(), $attributesData)
                    </div>
                @endfor
            </div>

        @endif
    </div>
@endsection


