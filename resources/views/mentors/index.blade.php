@extends('layouts.hyper-vertical-mainframe')

{{--@section('page-title')--}}
{{--    {{ mb_strtoupper(__('Mentors List')) }}--}}
{{--@endsection--}}

@section('page-header')
    <span class="h4" style="position: relative; top:3vh; left: 2vh">{{ mb_strtoupper(__('Mentors List')) }}</span>
@endsection

@section('content')
    <div>
        <ul class="nav float-right page-title-right" >
            <li class="nav-item">
                <a
                    class="nav-link text-muted"
                    id="newmentor"
                    href="{{ route('mentors.create') }}"
                    role="button">
                    <i class="dripicons-user font-20"></i><span class="ml-0 mt-2 font-weight-bold"> {{mb_strtoupper(__('New Mentor'))}}</span>
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
                    <input type="text" id="mentorSearch" name="mentorSearch" class="form-control" placeholder="{{ __('Search...') }}" >
                </div>
            </li>
            <li class="nav-item ml-2">
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-text small">{{ __('By Specialization') }}</span>
                    </div>
                    <select name="mentorSpec" id="mentorSpec" class="form-control form-control-sm">
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
    @foreach($mentors as $mentor)
        @if($loop->index % 4 == 0)
            <div class="row">
        @endif

        <div class="col-lg-3">
            <div class="card shadow ribbon-box">
                <div class="card-body p-0">
                    @php
                        $attribute = $mentor->getAttribute('mentor-type');
                    @endphp
                    <div class="ribbon-two @if($attribute->getValue() == 1) ribbon-two-primary @else ribbon-two-success @endif">
                        <span>{{ $attribute->getText() }}</span>
                    </div>
                    <div class="row align-items-center">
                        <div class="col-sm-5 overflow-hidden">
                            <div style="height: 150px;  overflow: hidden">
                                <img
                                    src="
                                @if($mentor->getAttribute('photo') != null
                                        && strlen($mentor->getValue('photo')['filelink']) > 0)
                                    {{ $mentor->getValue('photo')['filelink'] }}
                                    @else
                                        /images/custom/nophoto2.png
                                    @endif" class="h-100"
                                />
                            </div>

                        </div>
                        <div class="col-sm-7 text-center">
                            <h4 class="mt-0 mb-4 "><a href="{{ route('mentors.profile', ['mentor' => $mentor->getId()]) }}">{{ $mentor->getAttribute('name')->getText() }}</a></h4>
                            <a class="text-center" href="mailto://{{$mentor->getValue('email')}}" target="_blank">{{ $mentor->getValue('email') }}</a>
                            <p class="text-center">{{ $mentor->getValue('phone') }}</p>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        @if($loop->index % 4 == 3 || $loop->iteration == $mentors->count() )
            </div>
        @endif
    @endforeach


@endsection

@section('scripts')
    <script type="text/javascript">
        $('#textBtn').click(function() {
            alert('click')
            $('#photo').trigger('click');
        })

        $('#photo').on('change', function (evt) {
            let el = evt.currentTarget;
            console.log(el);
            console.log($(el)[0].files[0]);
            var fileReader = new FileReader();
            fileReader.onload = function () {
                var data = fileReader.result;  // data <-- in this var you have the file data in Base64 format
                $('#photoPreview').attr('src', data);
            };
            fileReader.readAsDataURL($(el)[0].files[0]);
        });



    </script>
@endsection


