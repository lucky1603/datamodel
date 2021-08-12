@extends('layouts.hyper-vertical-profile-pre')

@section('profile-content')
    <div class="card">
        <div class="card-body">
            <h1 class="text-center">Prijava na <span class="attribute-label">{{ $programName }}</span></h1>
        </div>
        <form class="p-4" id="myForm" method="post" enctype="multipart/form-data" action="">
            @switch($programType)
                @case(\App\Business\Program::$INKUBACIJA_BITF)
                    @include('profiles.partials._ibitf')
                    @break
                @case(\App\Business\Program::$RASTUCE_KOMPANIJE)

                    @break
                @case(\App\Business\Program::$RAISING_STARTS)

                    @break
            @endswitch
        </form>
    </div>
@endsection
