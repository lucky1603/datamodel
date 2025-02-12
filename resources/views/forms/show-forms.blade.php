@extends('layouts.hyper-vertical-mainframe')

@section('page-header')
    <span class="h4" style="position: relative; top:3vh; left: 2vh">{{ mb_strtoupper(__('Forms Preview')) }}</span>
@endsection

@section('content')
    <div class="container d-flex align-items-center justify-content-center w-100 h-100">
        <div id="cardIncubation" class="card m-2" role="button" style="width: 250px; height: 250px" title="Pokaži formular za Incubation">
            <div class="card-body bg-dark w-100 h-100 d-flex align-items-center">
                <img src="/images/custom/inkubacija.png" class="w-100 m-auto">
            </div>
        </div>
        <div id="cardRaisingStarts" class="card m-2" role="button" style="width: 250px; height: 250px" title="Pokaži formular za Raising Starts">
            <div class="card-body bg-dark w-100 h-100 d-flex align-items-center">
                <img src="/images/custom/raisingstarts.png" class="w-100 m-auto">
            </div>
        </div>
        <div id="cardRastuceKompanije" class="card m-2" role="button"  style="width: 250px; height: 250px" title="Pokaži formular za 'Rastuće Kompanije'">
            <div class="card-body bg-dark w-100 h-100 d-flex align-items-center flex-column">
                <img src="/images/custom/rastuce.png" class="w-100 m-auto">
            </div>
        </div>
    </div>


    {{-- <div class="d-flex align-items-center justify-content-left w-100 h-100">
        <div class="row w-100">
            <div class="col-4">
                <div class="d-flex flex-column align-items-center justify-content-center">
                    <div id="cardRaisingStarts" class="card m-2" role="button" style="width: 250px; height: 250px" title="Pokaži formular za Raising Starts">
                        <div class="card-body bg-dark w-100 h-100 d-flex align-items-center">
                            <img src="/images/custom/raisingstarts.png" class="w-100 m-auto">
                        </div>
                    </div>
                    <public-call-manager ref="publicCallManager1" class="mt-2" :call-id="1" :key="1"></public-call-manager>
                </div>
            </div>
            <div class="col-4">
                <div class="d-flex flex-column align-items-center justify-content-center">
                    <div id="cardIncubation" class="card m-2" role="button" style="width: 250px; height: 250px" title="Pokaži formular za Incubation">
                        <div class="card-body bg-dark w-100 h-100 d-flex align-items-center">
                            <img src="/images/custom/inkubacija.png" class="w-100 m-auto">
                        </div>
                    </div>
                    <public-call-manager ref="publicCallManager2" class="mt-2" :call-id="2" :key="2"></public-call-manager>
                </div>
            </div>
            <div class="col-4">
                <div class="d-flex flex-column align-items-center justify-content-center">
                    <div id="cardRastuceKompanije" class="card m-2" role="button"  style="width: 250px; height: 250px" title="Pokaži formular za 'Rastuče Kompanije'">
                        <div class="card-body bg-dark w-100 h-100 d-flex align-items-center flex-column">
                            <img src="/images/custom/rastuce.png" class="w-100 m-auto">
                        </div>
                    </div>
                    <public-call-manager ref="publicCallManager3" class="mt-2" :call-id="3" :key="3"></public-call-manager>
                </div>
            </div>  
        </div>
    </div> --}}

@endsection


{{-- @section('sidemenu')
    <li class="side-nav-item">
        <a href="{{ route('forms.showRaisingStarts') }}" class="side-nav-link">
            <i class="uil-laptop-cloud"></i>
            <span>{{ mb_strtoupper(__('Raising Starts')) }}</span>
        </a>
    </li>
    <li class="side-nav-item">
        <a href="{{ route('forms.showIncubation') }}" class="side-nav-link">
            <i class="uil-laptop-cloud"></i>
            <span>{{ mb_strtoupper(__('Incubation')) }}</span>
        </a>
    </li>
    <li class="side-nav-item">
        <a href="{{ route('forms.showIncubation') }}" class="side-nav-link">
            <i class="uil-laptop-cloud"></i>
            <span>{{ mb_strtoupper(__('Growing Companies')) }}</span>
        </a>
    </li>
    <li class="side-nav-item">
        <a href="{{ route('home') }}" class="side-nav-link">
            <i class="uil-laptop-cloud"></i>
            <span>{{ mb_strtoupper(__('Back')) }}</span>
        </a>
    </li>
@endsection --}}

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#cardRaisingStarts').click(function() {
                location.href="/forms/showRaisingStarts";
            });
            $('#cardIncubation').click(function() {
                location.href = "/forms/showIncubation";
            });
        });
    </script>
@endsection
