<div class="container h-100">
    <form id="myDemoDayForm" method="POST" enctype='multipart/form-data' action="" class="pl-2 pr-2 h-100" >
        <input type="hidden" id="id" name="id" value="{{ $id }}">
        <input type="hidden" id="programId" name="programId" value="{{ $program->getId() }}">
        <div class="row" >
            <div class="col-12 h-100">
                <h3 class="text-center">{{ __('Demo Day') }}</h3>
                <hr>
            </div>
        </div>

        @php
            $status = $program->getStatus();
        @endphp

        <div style="display: flex; flex-direction: row; justify-content: center; align-items: center">
            <button type="button" id="btnDemoDayPassed" class="btn btn-sm btn-success ml-1"  @if($status != $validStatus) disabled @endif>
                <span id="button_spinner_demoday_ok" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                <span id="button_text">{{__('gui.accept')}}</span>
            </button>
            <button type="button" id="btnDemoDayRejected" class="btn btn-sm btn-danger ml-1"  @if($status != $validStatus) disabled @endif>
                <span id="button_spinner_demoday_reject" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                <span id="button_text">{{__('gui.reject')}}</span>
            </button>

        </div>
    </form>
</div>



