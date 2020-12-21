<h5 class="mb-3 text-uppercase bg-light p-2">
    <i class="mdi mdi-office-building mr-1"></i>
    {{ App\AttributeGroup::get('target_group')->label }}
</h5>

<div class="form-group">
    <label for="{{ $model->getAttribute('development_phase')->name }}" class="attribute-label">{{ $model->getAttribute('development_phase')->label }}</label>
    <select class="form-control" id="{{ $model->getAttribute('development_phase')->name }}" name="{{ $model->getAttribute('development_phase')->name }}">
        <option value="0" @if($model->getAttribute('development_phase')->getValue() == 0) selected @endif >{{__('Choose')}} ...</option>
        @foreach( $model->getAttribute('development_phase')->getOptions() as $key => $value )
            <option value="{{ $key }}" @if($model->getAttribute('development_phase')->getValue() == $key) selected @endif>{{ $value }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('poblems')->name }}" class="attribute-label">{{ $model->getAttribute('poblems')->label }}</label>
    <textarea class="form-control" id="{{ $model->getAttribute('poblems')->name }}" name="{{ $model->getAttribute('poblems')->name }}" rows="4" placeholder="255 chars max...">{{ $model->getData()['poblems'] }}</textarea>
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('target_group_solution_and_competition')->name }}" class="attribute-label">{{ $model->getAttribute('target_group_solution_and_competition')->label }}</label>
    <textarea class="form-control" id="{{ $model->getAttribute('target_group_solution_and_competition')->name }}" name="{{ $model->getAttribute('target_group_solution_and_competition')->name }}" rows="4" placeholder="255 chars max...">{{ $model->getData()['target_group_solution_and_competition'] }}</textarea>
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('target_groups')->name }}" class="attribute-label">{{ $model->getAttribute('target_groups')->label }}</label>
    <textarea class="form-control" id="{{ $model->getAttribute('target_groups')->name }}" name="{{ $model->getAttribute('target_groups')->name }}" rows="4" placeholder="255 chars max...">{{ $model->getData()['target_groups'] }}</textarea>
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('target_markets')->name }}" class="attribute-label">{{ $model->getAttribute('target_markets')->label }}</label>
    <textarea class="form-control" id="{{ $model->getAttribute('target_markets')->name }}" name="{{ $model->getAttribute('target_markets')->name }}" rows="4" placeholder="255 chars max...">{{ $model->getData()['target_markets'] }}</textarea>
</div>
