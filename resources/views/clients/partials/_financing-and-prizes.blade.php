<h5 class="mb-3 text-uppercase bg-light p-2">
    <i class="mdi mdi-office-building mr-1"></i>
    {{ App\AttributeGroup::get('financing_prizing_group')->label }}
</h5>

<div class="form-group">
    <label for="{{ $model->getAttribute('prizes')->name }}">{{ $model->getAttribute('prizes')->label }}</label>
    <textarea class="form-control" id="{{ $model->getAttribute('prizes')->name }}" name="{{ $model->getAttribute('prizes')->name }}" rows="4" placeholder="{{ __('gui.MaxCharsCount') }}">{{ $model->getData()['prizes'] }}</textarea>
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('financing_type')->name }}">{{ $model->getAttribute('financing_type')->label }}</label>
    <textarea class="form-control" id="{{ $model->getAttribute('financing_type')->name }}" name="{{ $model->getAttribute('financing_type')->name }}" rows="4" placeholder="{{ __('gui.MaxCharsCount') }}">{{ $model->getData()['financing_type'] }}</textarea>
</div>

<div class="form-group">
    <input id="{{ $model->getAttribute('looking_for_financing')->name }}Hidden" type="hidden" name="{{ $model->getAttribute('looking_for_financing')->name }}" value="off">
    {!! $model->getAttribute('looking_for_financing')->label !!}
    <input
        type="checkbox"
        id="{{ $model->getAttribute('looking_for_financing')->name }}"
        name="{{$model->getAttribute('looking_for_financing')->name}}"
        @if($model->getAttribute('looking_for_financing')->getValue()) checked @endif style="padding-top: 10px"
        onclick="
            if(document.getElementById('{{ $model->getAttribute('looking_for_financing')->name }}').checked)
            {
            document.getElementById('{{ $model->getAttribute('looking_for_financing')->name }}Hidden').disabled = true;
            } else {
            document.getElementById('{{ $model->getAttribute('looking_for_financing')->name }}Hidden').disabled = false;
            }
            ">
</div>
