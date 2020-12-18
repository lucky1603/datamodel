<h5 class="mb-3 text-uppercase bg-light p-2">
    <i class="mdi mdi-office-building mr-1"></i>
    {{ App\AttributeGroup::get('support')->label }}
</h5>

<div class="form-group">
    <label for="{{ $model->getAttribute('kvadratura')->name }}">{!! $model->getAttribute('kvadratura')->label !!}:</label>
    <input type="text" class="border float-right text-right" id="{{ $model->getAttribute('kvadratura')->name }}" name="{{ $model->getAttribute('kvadratura')->name }}" value="{{ $model->getData()['kvadratura'] }}">
</div>


<div class="form-group">
    <input id="{{ $model->getAttribute('zajednicke_prostorije')->name }}Hidden" type="hidden" name="{{ $model->getAttribute('zajednicke_prostorije')->name }}" value="off">
    <span class="font-weight-semibold"> {!! $model->getAttribute('zajednicke_prostorije')->label !!}</span>
    <input
        type="checkbox" class="ml-1"
        id="{{ $model->getAttribute('zajednicke_prostorije')->name }}"
        name="{{$model->getAttribute('zajednicke_prostorije')->name}}"
        @if($model->getAttribute('zajednicke_prostorije')->getValue()) checked @endif
        onclick="
        if(document.getElementById('{{ $model->getAttribute('zajednicke_prostorije')->name }}').checked)
        {
        document.getElementById('{{ $model->getAttribute('zajednicke_prostorije')->name }}Hidden').disabled = true;
        } else {
        document.getElementById('{{ $model->getAttribute('zajednicke_prostorije')->name }}Hidden').disabled = false;
        }
        ">
</div>

<div class="form-group">
    <input id="{{ $model->getAttribute('inovaciona_laboratorija')->name }}Hidden" type="hidden" name="{{ $model->getAttribute('inovaciona_laboratorija')->name }}" value="off">
    <span class="font-weight-semibold"> {!! $model->getAttribute('inovaciona_laboratorija')->label !!}</span>
    <input
        type="checkbox" class="ml-1"
        id="{{ $model->getAttribute('inovaciona_laboratorija')->name }}"
        name="{{$model->getAttribute('inovaciona_laboratorija')->name}}"
        @if($model->getAttribute('inovaciona_laboratorija')->getValue()) checked @endif
        onclick="
        if(document.getElementById('{{ $model->getAttribute('inovaciona_laboratorija')->name }}').checked)
        {
        document.getElementById('{{ $model->getAttribute('inovaciona_laboratorija')->name }}Hidden').disabled = true;
        } else {
        document.getElementById('{{ $model->getAttribute('inovaciona_laboratorija')->name }}Hidden').disabled = false;
        }
        ">
</div>

<div class="form-group">
    <input id="{{ $model->getAttribute('konsalting_usluge')->name }}Hidden" type="hidden" name="{{ $model->getAttribute('konsalting_usluge')->name }}" value="off">
    <span class="font-weight-semibold"> {!! $model->getAttribute('konsalting_usluge')->label !!}</span>
    <input
        type="checkbox" class="ml-1"
        id="{{ $model->getAttribute('konsalting_usluge')->name }}"
        name="{{$model->getAttribute('konsalting_usluge')->name}}"
        @if($model->getAttribute('konsalting_usluge')->getValue()) checked @endif
        onclick="
        if(document.getElementById('{{ $model->getAttribute('konsalting_usluge')->name }}').checked)
        {
        document.getElementById('{{ $model->getAttribute('konsalting_usluge')->name }}Hidden').disabled = true;
        } else {
        document.getElementById('{{ $model->getAttribute('konsalting_usluge')->name }}Hidden').disabled = false;
        }
        ">
</div>
