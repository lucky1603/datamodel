@extends('layouts.hyper-vertical')

@section('page-title')
    {{ mb_strtoupper(__('Add New Mentor')) }}
@endsection

@section('sidemenu')
    <li class="side-nav-item">
        <a href="{{ route('mentors.create') }}" class="side-nav-link">
            <i class="uil-user-plus"></i>
            <span>{{ mb_strtoupper( __('New Mentor')) }}</span>
        </a>
    </li>
    <li>
        <a href="{{route('mentors.index')}}" class="side-nav-link">
            <i class="uil-list-ul"></i>
            <span>{{ mb_strtoupper( __('Back to List')) }}</span>
        </a>
    </li>

@endsection

@section('content')
    @include('mentors.form.mentor-form', ['action' => route('mentors.store'), 'showCommands' => true, 'showTitle' => true,  'title' => __('Add New Mentor')])
@endsection

@section('scripts')
    <script type="text/javascript">
        $('#textBtn').click(function() {
            alert('click')
            $('#photo').trigger('click');
        })

        $('#buttonClose').click(function() {
            location.href = '/mentors';
        }) ;

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







