<form method="POST" action="{{ route('clients.update', $model->getId()) }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" id="landing" name="landing" value="{{ $landing }}">
    @include('clients.partials._general-section')
    @include('clients.partials._target-group')
    @include('clients.partials._inovation-group')
    @include('clients.partials._team-group')
    @include('clients.partials._financing-and-prizes')
    @include('clients.partials._business-model')
    @include('clients.partials._enterpreneur-readines')
    @include('clients.partials._support')
    <div class="text-center btn-group-sm">
        <button type="submit" class="btn btn-sm btn-primary">{{ __('Save') }}</button>
        <button type="button" class="btn btn-sm btn-outline-dark" id="cancel">{{ __('Cancel') }}</button>
        @if($model->getData()['status'] == 1)
            <button type="button" class="btn btn-sm btn-outline-primary" id="send">
                <span id="button_spinner" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                <span id="button_text">{{ __('Send') }}</span>
            </button>
        @endif
    </div>
</form>

@section('scripts')
<script type="text/javascript">
    $('#send').on('click', function() {
        $('#button_spinner').attr('hidden', false);
        var clientId = <?php echo $model->getId(); ?>;

        var result = 0;
        $.get('/clients/check/' + clientId, function(data) {
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


