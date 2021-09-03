@extends('layouts.hyper-vertical-profile-shortdata')

@section('profile-content')
    <div class="card">
        <div class="card-body">
            <h1 class="text-center">Prijava na <span class="attribute-label">{{ $programName }}</span></h1>
        </div>
        <form class="p-4" id="myForm" method="post" enctype="multipart/form-data" action="{{ route('profiles.saveapplicationdata') }}">
            @csrf
            <input type="hidden" id="programType" name="programType" value="{{ $programType }}">
            <input type="hidden" id="profile_id" name="profile_id" value="{{ $model->getId() }}">
            @if(isset($instance_id))
                <input type="hidden" id="instance_id" name="instance_id" value="{{ $instance_id }}">
            @endif
            @switch($programType)
                @case(\App\Business\Program::$INKUBACIJA_BITF)
                    @include('profiles.partials._ibitf')
                    @break
                @case(\App\Business\Program::$RASTUCE_KOMPANIJE)

                    @break
                @case(\App\Business\Program::$RAISING_STARTS)

                    @break
            @endswitch
        </form>
    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $('#send').on('click', function() {
            $('#button_spinner').attr('hidden', false);
            var profileId = <?php echo $model->getId(); ?>;

            var result = 0;
            $.get('/profiles/check/' + profileId, function(data) {
                var result = JSON.parse(data);
                console.log(result);
                $('#button_spinner').attr('hidden', true);

                if(result.code == 0) {
                    $.toast(result.message);

                } else {
                    $.toast({
                        text : result.message,
                        afterHidden : function() {
                            location.reload();
                        }
                    });
                }

            });

        });

    </script>
@endsection
