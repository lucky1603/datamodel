@extends('layouts.hyper-vertical')

@section('content')
    <div class="container">
        <h1 class="text-center w-100 my-4">Incubation BITF Formular</h1>
        <hr>
        @include('profiles.partials._ibitf')
        <hr class="my-4 text-dark"/>
        <h1 class="my-4 text-center">{{ __('Public Calls Management') }}</h1>
        <public-call-manager :call-id="1" :key="1"></public-call-manager>
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

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('#okSpinner').hide();
        $('#cancelSpinner').hide();
    })
</script>
@endsection
