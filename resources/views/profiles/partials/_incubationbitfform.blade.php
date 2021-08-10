
@foreach($attributeGroups as $attributeGroup)
    <h5>{{ $attributeGroup->label }}</h5>
{{--<div class="form-group">--}}
{{--    <label for="{{ $model->getAttribute('name')->name }}" class="attribute-label">{{ $model->getAttribute('name')->label }}</label>--}}
{{--    <input type="text" class="form-control" id="{{ $model->getAttribute('name')->name }}" name="{{ $model->getAttribute('name')->name }}" value="{{ $model->getData()['name'] }}">--}}
{{--</div>--}}
@endforeach
