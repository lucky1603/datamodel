<h5 class="mb-3 text-uppercase bg-light p-2">
    <i class="mdi mdi-office-building mr-1"></i>
    {{ App\AttributeGroup::get('enterpreneur_readyness')->label }}
</h5>

<div class="form-group">
    <label for="{{ $model->getAttribute('have_skills')->name }}" class="attribute-label">{{ $model->getAttribute('have_skills')->label }}</label>
    <textarea class="form-control" id="{{ $model->getAttribute('have_skills')->name }}" name="{{ $model->getAttribute('have_skills')->name }}" rows="4" placeholder="{{ __('gui.MaxCharsCount') }}">{{ $model->getData()['have_skills'] }}</textarea>
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('improve_skills')->name }}" class="attribute-label">{{ $model->getAttribute('improve_skills')->label }}</label>
    <textarea class="form-control" id="{{ $model->getAttribute('improve_skills')->name }}" name="{{ $model->getAttribute('improve_skills')->name }}" rows="4" placeholder="{{ __('gui.MaxCharsCount') }}">{{ $model->getData()['improve_skills'] }}</textarea>
</div>

<div class="form-group">
    <input id="{{ $model->getAttribute('regular_mentor_sessions')->name }}Hidden" type="hidden" name="{{ $model->getAttribute('regular_mentor_sessions')->name }}" value="off">
    <span class="font-weight-semibold attribute-label"> {!! $model->getAttribute('regular_mentor_sessions')->label !!}</span>
    <input
        type="checkbox" class="ml-1"
        id="{{ $model->getAttribute('regular_mentor_sessions')->name }}"
        name="{{$model->getAttribute('regular_mentor_sessions')->name}}"
        @if($model->getAttribute('regular_mentor_sessions')->getValue()) checked @endif
        onclick="
            if(document.getElementById('{{ $model->getAttribute('regular_mentor_sessions')->name }}').checked)
            {
            document.getElementById('{{ $model->getAttribute('regular_mentor_sessions')->name }}Hidden').disabled = true;
            } else {
            document.getElementById('{{ $model->getAttribute('regular_mentor_sessions')->name }}Hidden').disabled = false;
            }
            ">
</div>

<div class="form-group">
    <input id="{{ $model->getAttribute('regular_workshops')->name }}Hidden" type="hidden" name="{{ $model->getAttribute('regular_workshops')->name }}" value="off">
    <span class="font-weight-semibold attribute-label"> {!! $model->getAttribute('regular_workshops')->label !!}</span>
    <input
        type="checkbox" class="ml-1"
        id="{{ $model->getAttribute('regular_workshops')->name }}"
        name="{{$model->getAttribute('regular_workshops')->name}}"
        @if($model->getAttribute('regular_workshops')->getValue()) checked @endif
        onclick="
        if(document.getElementById('{{ $model->getAttribute('regular_workshops')->name }}').checked)
        {
        document.getElementById('{{ $model->getAttribute('regular_workshops')->name }}Hidden').disabled = true;
        } else {
        document.getElementById('{{ $model->getAttribute('regular_workshops')->name }}Hidden').disabled = false;
        }
        ">
</div>

<div class="form-group">
    <input id="{{ $model->getAttribute('will_evaluate_work')->name }}Hidden" type="hidden" name="{{ $model->getAttribute('will_evaluate_work')->name }}" value="off">
    <span class="font-weight-semibold attribute-label"> {!! $model->getAttribute('will_evaluate_work')->label !!}</span>
    <input
        type="checkbox" class="ml-1"
        id="{{ $model->getAttribute('will_evaluate_work')->name }}"
        name="{{$model->getAttribute('will_evaluate_work')->name}}"
        @if($model->getAttribute('will_evaluate_work')->getValue()) checked @endif
        onclick="
        if(document.getElementById('{{ $model->getAttribute('will_evaluate_work')->name }}').checked)
        {
        document.getElementById('{{ $model->getAttribute('will_evaluate_work')->name }}Hidden').disabled = true;
        } else {
        document.getElementById('{{ $model->getAttribute('will_evaluate_work')->name }}Hidden').disabled = false;
        }
        ">
</div>

<div class="form-group">
    <input id="{{ $model->getAttribute('establish_company')->name }}Hidden" type="hidden" name="{{ $model->getAttribute('establish_company')->name }}" value="off">
    <span class="font-weight-semibold attribute-label"> {!! $model->getAttribute('establish_company')->label !!}</span>
    <input
        type="checkbox" class="ml-1"
        id="{{ $model->getAttribute('establish_company')->name }}"
        name="{{$model->getAttribute('establish_company')->name}}"
        @if($model->getAttribute('establish_company')->getValue()) checked @endif
        onclick="
        if(document.getElementById('{{ $model->getAttribute('establish_company')->name }}').checked)
        {
        document.getElementById('{{ $model->getAttribute('establish_company')->name }}Hidden').disabled = true;
        } else {
        document.getElementById('{{ $model->getAttribute('establish_company')->name }}Hidden').disabled = false;
        }
        ">
</div>

<div class="form-group">
    <input id="{{ $model->getAttribute('fulfill_contract_obligations')->name }}Hidden" type="hidden" name="{{ $model->getAttribute('fulfill_contract_obligations')->name }}" value="off">
    <span class="font-weight-semibold attribute-label">{!! $model->getAttribute('fulfill_contract_obligations')->label !!}</span>
    <input
        type="checkbox" class="ml-1"
        id="{{ $model->getAttribute('fulfill_contract_obligations')->name }}"
        name="{{$model->getAttribute('fulfill_contract_obligations')->name}}"
        @if($model->getAttribute('fulfill_contract_obligations')->getValue()) checked @endif
        onclick="
        if(document.getElementById('{{ $model->getAttribute('fulfill_contract_obligations')->name }}').checked)
        {
        document.getElementById('{{ $model->getAttribute('fulfill_contract_obligations')->name }}Hidden').disabled = true;
        } else {
        document.getElementById('{{ $model->getAttribute('fulfill_contract_obligations')->name }}Hidden').disabled = false;
        }
        ">
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('motiv')->name }}" class="attribute-label">{{ $model->getAttribute('motiv')->label }}</label>
    <textarea class="form-control" id="{{ $model->getAttribute('motiv')->name }}" name="{{ $model->getAttribute('motiv')->name }}" rows="4" placeholder="{{ __('gui.MaxCharsCount') }}">{{ $model->getData()['motiv'] }}</textarea>
</div>
