@extends('layouts.hyper-vertical-profile')

@section('profile-content')
    <div class="card" style="height: 100%;">
        <div class="card-header">
            <ul class="nav float-right page-title-right" >
                <li class="nav-item">
                    <a
                        class="nav-link text-muted"
                        id="newClient"
                        href="{{ route('profiles.create') }}"
                        role="button" data-toggle="modal" data-target="#dialogHost">
                        <i class="dripicons-document-new font-20"></i><span class="ml-0 mt-2 font-weight-bold"> {{strtoupper(__('New Profile'))}}</span>
                    </a>
                </li>
            </ul>
            <ul class="nav page-title" >
                <li class="nav-item"><label style="margin-top: 8px"><strong>{{ __('PROFILE FILTER') }}:</strong></label></li>
                <li class="nav-item" style="margin-left: 40px">
                    <div class="input-group input-group-sm" style="margin-top: 2px">
                        <div class="input-group-prepend">
                            <span class="input-group-text small">{{ __('By Status') }}</span>
                        </div>
                        <select name="clientStatus" id="clientStatus" class="form-control form-control-sm">
                            <option value="1">{{ __('Mapped') }}</option>
                            <option value="2">{{ __('Interested') }}</option>
                            <option value="3">{{ __('Applied') }}</option>
                        </select>
                    </div>
                </li>
                <li class="nav-item" style="margin-left: 20px">
                    <div class="input-group input-group-sm" style="margin-top: 2px;">
                        <div class="input-group-prepend">
                            <span class="input-group-text">{{ __('By Name') }}</span>
                        </div>
                        <input type="text" id="profileSearch" name="profileSearch" class="form-control" placeholder="{{ __('Search...') }}" >
                        {{--                        <span class="mdi mdi-search-web" style="font-size: 22px;position: absolute; left:90px; top:0px; color: lightgray; z-index: 9"></span>--}}
                        <div class="input-group-append">
                            <span class="mdi mdi-search-web input-group-text"></span>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <div class="card-body" style="overflow: auto">
            {{__('Trainings')}}
        </div>
    </div>
@endsection
@section ('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.side-nav-item').each(function(index) {
                if($(this).attr('id') == 'navTrainings' && !$(this).hasClass('mm_active')) {
                    $(this).addClass('mm_active');
                } else if($(this).attr('id') != 'navReports' && $(this).hasClass('mm_active')) {
                    $(this).removeClass('mm_active');
                }
            });
        });
    </script>
@endsection
