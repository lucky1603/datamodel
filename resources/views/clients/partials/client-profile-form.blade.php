<form method="POST" action="{{ route('clients.update', $model->getId()) }}" enctype="multipart/form-data">
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
        <button type="button" class="btn btn-sm btn-outline-dark">{{ __('Cancel') }}</button>
        <button type="button" class="btn btn-sm btn-outline-primary">{{ __('Send') }}</button>
    </div>
</form>


