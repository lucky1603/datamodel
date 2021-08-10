@extends('layouts.hyper-vertical-profile-pre')

@section('profile-content')
    <div class="card">
        <div class="card-body">
           <h4>Prijava na {{ $programName }}</h4>
        </div>
        <form id="myForm" method="post" enctype="multipart/form-data" action="">
            @switch($programType)
                @case(\App\Business\Program::$INKUBACIJA_BITF)
                    @include('profiles.partials._incubationbitfform')
                    @break
                @case(\App\Business\Program::$RASTUCE_KOMPANIJE)

                    @break
                @case(\App\Business\Program::$RAISING_STARTS)

                    @break
            @endswitch
        </form>
    </div>
@endsection
