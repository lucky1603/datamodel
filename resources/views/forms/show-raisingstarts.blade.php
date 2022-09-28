@extends('layouts.hyper-vertical')

@section('content')
    <div class="container">
        <h1 class="text-center w-100 my-4">Raising Starts Formular</h1>
        <hr>
        @include('profiles.partials._rstarts')
    </div>

@endsection


@section('sidemenu')
    <li class="side-nav-item">
        <a href="{{ route('forms.showForms') }}" class="side-nav-link">
            <i class="uil-laptop-cloud"></i>
            <span>{{ strtoupper(__('Back')) }}</span>
        </a>
    </li>
@endsection
