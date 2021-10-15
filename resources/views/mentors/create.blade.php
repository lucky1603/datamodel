@extends('layouts.create')

@section('title')
    <h1 class="text-center attribute-label">{{__('Create New Mentor')}}</h1>
@endsection


{{--@extends('layouts.app')--}}
{{--@section('content')--}}
{{--<form id="myMentorForm" action="{{ route('mentors.store') }}" method="POST" enctype="multipart/form-data" style="width: 500px">--}}
{{--    <div class="row border border-danger" >--}}
{{--        <div class="col-lg-6 border border-primary" style="display: flex; flex-direction: column; align-items: center" >--}}
{{--            <img src="/images/custom/nophoto2.png" id="photoPreview" style="width: 200px">--}}
{{--            <border style="border-radius: 10px; width: 50px; overflow: hidden; position:relative; top:-45px">--}}
{{--                <input type="file" id="photo" name="photo" style="color: transparent;display:none">--}}
{{--                <button id="textBtn" type="button" class="btn btn-sm btn-primary rounded-pill" >Izaberi sliku</button>--}}
{{--            </border>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</form>--}}

{{--@endsection--}}

{{--@section('scripts')--}}
{{--    <script type="text/javascript">--}}
{{--        $('#textBtn').click(function() {--}}
{{--            $('#photo').trigger('click');--}}
{{--        })--}}

{{--        $('#photo').on('change', function (evt) {--}}
{{--            let el = evt.currentTarget;--}}
{{--            console.log(el);--}}
{{--            console.log($(el)[0].files[0]);--}}
{{--            var fileReader = new FileReader();--}}
{{--            fileReader.onload = function () {--}}
{{--                var data = fileReader.result;  // data <-- in this var you have the file data in Base64 format--}}
{{--                $('#photoPreview').attr('src', data);--}}
{{--            };--}}
{{--            fileReader.readAsDataURL($(el)[0].files[0]);--}}
{{--        });--}}

{{--    </script>--}}
{{--@endsection--}}




