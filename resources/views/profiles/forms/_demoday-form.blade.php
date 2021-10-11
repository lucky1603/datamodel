<div class="container h-100">
    <form id="myDemoDayForm" method="POST" enctype='multipart/form-data' action="" class="pl-2 pr-2 h-100" >
        <div class="row" style="height: 10%">
            <div class="col-12 h-100">
                <h3 class="text-center">{{ __('Demo Day') }}</h3>
            </div>
        </div>
        <div class="row overflow-auto" style="height: 75%">
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
                    <span class="attribute-label mr-2">Uslovi zadovoljeni</span>
                    <input
                        type="checkbox"
                        id="passed"
                        name="passed"
                        @if($value) checked @endif
                        onclick="if(document.getElementById('passed').checked == true)
                            document.getElementById('passedHidden').disabled = true;
                        else
                            document.getElementById('passedHidden').disabled = false;">
                </div>

            </div>

        </div>

        <div class="row text-center " style="height: 15%; display: flex; flex-direction: row; justify-content: center; align-items: center">
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



