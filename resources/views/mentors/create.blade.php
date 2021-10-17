{{--@extends('layouts.create')--}}

{{--@section('title')--}}
{{--    <h1 class="text-center attribute-label">{{__('Create New Mentor')}}</h1>--}}
{{--@endsection--}}


@extends('layouts.app')
@section('content')
    @include('mentors.form.mentor-form', ['action' => route('mentors.store'), 'showCommands' => true, 'showTitle' => true,  'title' => __('Add New Mentor')])
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







