<div class="container h-100">
    <form id="myDemoDayForm" method="POST" enctype='multipart/form-data' action="" class="pl-2 pr-2 h-100" >
        <div class="row" >
            <div class="col-12 h-100">
                <h3 class="text-center">{{ __('Demo Day') }}</h3>
            </div>
        </div>
        <div class="row overflow-auto" >
            <div class="col-12 pt-3">
                @csrf
                <input type="hidden" id="id" name="id" value="{{ $id }}">
                <input type="hidden" id="profile" name="profile" value="{{ $profile }}">
                <div class="form-group">
                    @php
                        $attribute = $attributes->where('name', 'passed')->first();
                        $value = $attribute->getValue() ?? null;
                    @endphp
                    <input type="hidden" id="passedHidden" name="passed" value="off">
                    <label class="attribute-label mr-2">Uslovi zadovoljeni</label>
                    <input
                        type="checkbox"
                        id="checkboxDemoDayPassed"
                        name="passed"
                        data-switch="primary"
                        @if($value) checked @endif
                        onclick="if(document.getElementById('checkboxDemoDayPassed').checked == true)
                            document.getElementById('passedHidden').disabled = true;
                        else
                            document.getElementById('passedHidden').disabled = false;">
                    <label for="checkboxDemoDayPassed" data-on-label="Da" data-off-label="Ne" style="top: 15px"></label>
                </div>

            </div>

        </div>

        <div class="row text-center " style="display: flex; flex-direction: row; justify-content: center; align-items: center">
            <button type="button" id="btnSaveDemoDay" class="btn btn-sm btn-primary h-50 w-15 ml-1"  @if($status != $validStatus) disabled @endif>
                <span id="save-demo-day-spinner" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                <span id="eval-demo-day">{{__('gui.save')}}</span>
            </button>
            <button type="button" id="btnDemoDayPassed" class="btn btn-sm btn-success h-50 w-15 ml-1"  @if($status != $validStatus) disabled @endif>
                <span id="button_spinner_ok" class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true" hidden></span>
                <span id="button_text">{{__('gui.accept')}}</span>
            </button>

        </div>


    </form>
</div>



