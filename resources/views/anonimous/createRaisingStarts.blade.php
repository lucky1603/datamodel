@extends('layouts.backbone')

@section('body-content')
    <div class="h-100 w-100 position-absolute">
        <div class="row bg-dark" style="height: 100px">
            <div class="col-6 col-lg-2 h-100">
                <img src="/images/custom/white-logo-transparent-full.png" class="ml-3 mt-2 h-75" />
            </div>
            <div class="col-lg-8 text-center" style="display: flex; align-items: center; horiz-align: center">
            <span class="font-24 text-light w-100" style="font-family: 'Roboto Light'">
                Prijava na RAISING STARTS</span>
            </div>
            <div class="col-6 col-lg-2 h-100">
                <div class="row h-100">
                    <div class="col-4 h-100" style="align-items: center; display: flex">
                        <img src="/images/custom/raisingstarts.png" class="h-75 mt-auto mb-auto" />
                    </div>
{{--                    <div class="col-8 h-100" style="align-items: center; display: flex">--}}
{{--                        <span class="text-light font-24" style="font-family: 'Roboto Light'">ACCELERATOR</span>--}}
{{--                    </div>--}}
                </div>
            </div>
        </div>
        <div class="row w-100" >
            <div class="col-8 offset-2 w-100">
                <form id="myRaisingStartsForm" method="POST" enctype="multipart/form-data" action="{{ route('storeRaisingStarts') }}" class="mt-4 h-100 w-100">
                    @csrf
                    @include('profiles.partials._rstarts')

{{--                    <div class="mt-4" style="display: flex">--}}
{{--                        <input--}}
{{--                            type="checkbox"--}}
{{--                            id="gdpr"--}}
{{--                            name="gdpr"--}}
{{--                            style="position: relative; top:4px"--}}
{{--                            class="@error('gdpr') is-invalid @enderror"--}}
{{--                            @if(old('gdpr') == 'on') checked @endif>--}}
{{--                        <span class="ml-1 attribute-label">--}}
{{--                            Slažem se sa--}}
{{--                            <a href="https://ntpark.rs/wp-content/uploads/2020/01/Obavestenje-o-obradi-podataka-o-licnosti.pdf" target="_blank">--}}
{{--                                uslovima obrade podataka o ličnosti.--}}
{{--                            </a>--}}
{{--                        </span>--}}
{{--                    </div>--}}
{{--                    @error('gdpr') <div class="alert alert-danger">{{ $message }}</div> @enderror--}}

                    <div class="row mt-4">
                        <div class="col-md-4"></div>
                        <div class="form-group col-md-3">
                            <div class="captcha text-center">
                                <span>{!! captcha_img('ntp') !!}</span>
                                <button type="button" id="refresh" class="btn btn-sm btn-success text-light"><i class="mdi mdi-refresh font-18" id="refresh"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="form-group col-md-3">
                            <input id="captcha" type="text" class="form-control" placeholder="Unesite karaktere sa slike" name="captcha"></div>

                    </div>
                    @error('captcha') <div class="alert alert-danger text-center">{{ $message }}</div>@enderror

                    <div class="text-center pt-4 mt-3" style="height: 5%">
                        <button type="type" id="buttonSend" class="btn btn-sm btn-primary w-15 rounded-pill">Posalji</button>
                        <button type="button" class="btn btn-sm btn-outline-primary w-15 rounded-pill">Odustani</button>
                    </div>
                </form>
            </div>
        </div>




    </div>


@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#btnAddMember').click(function() {
                let cloned = $('tbody#membersBody tr:first-child').clone();
                cloned.find('textarea').val('');
                cloned.appendTo('tbody#membersBody');
            });

            $('#btnAddFounder').click(function() {
                let cloned = $('tbody#foundersBody tr:first-child').clone();
                cloned.find('input').val('');
                cloned.appendTo('tbody#foundersBody');
            });

            $('#refresh').click(function(){
                $.ajax({
                    type:'GET',
                    url:'/refreshcaptcha',
                    success:function(data){
                        $(".captcha span").html(data.captcha);
                    }
                });
            });

        });
    </script>

@endsection
