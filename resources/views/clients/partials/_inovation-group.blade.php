<h5 class="mb-3 text-uppercase bg-light p-2">
    <i class="mdi mdi-office-building mr-1"></i>
    {{ App\AttributeGroup::get('innovation_group')->label }}
</h5>

<div class="form-group">
    <label for="{{ $model->getAttribute('product_description')->name }}" class="attribute-label">{{ $model->getAttribute('product_description')->label }}</label>
    <textarea class="form-control" id="{{ $model->getAttribute('product_description')->name }}" name="{{ $model->getAttribute('product_description')->name }}" rows="4" placeholder="255 chars max...">{{ $model->getData()['product_description'] }}</textarea>
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('inovation_type')->name }}" class="attribute-label">{{ $model->getAttribute('inovation_type')->label }}</label>
    <select class="form-control" id="{{ $model->getAttribute('inovation_type')->name }}" name="{{ $model->getAttribute('inovation_type')->name }}">
        <option value="0" @if($model->getAttribute('inovation_type')->getValue() == 0) selected @endif >{{__('Choose')}} ...</option>
        @foreach( $model->getAttribute('inovation_type')->getOptions() as $key => $value )
            <option value="{{ $key }}" @if($model->getAttribute('inovation_type')->getValue() == $key) selected @endif>{{ $value }}</option>
        @endforeach
    </select>
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('inovativity')->name }}" class="attribute-label">{{ $model->getAttribute('inovativity')->label }}</label>
    <textarea class="form-control" id="{{ $model->getAttribute('inovativity')->name }}" name="{{ $model->getAttribute('inovativity')->name }}" rows="4" placeholder="255 chars max...">{{ $model->getData()['inovativity'] }}</textarea>
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('intelectual_property_protection')->name }}" class="attribute-label">{{ $model->getAttribute('intelectual_property_protection')->label }}</label>
    <textarea class="form-control" id="{{ $model->getAttribute('intelectual_property_protection')->name }}" name="{{ $model->getAttribute('intelectual_property_protection')->name }}" rows="4" placeholder="255 chars max...">{{ $model->getData()['intelectual_property_protection'] }}</textarea>
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('mvp_testing')->name }}" class="attribute-label">{{ $model->getAttribute('mvp_testing')->label }}</label>
    <textarea class="form-control" id="{{ $model->getAttribute('mvp_testing')->name }}" name="{{ $model->getAttribute('mvp_testing')->name }}" rows="4" placeholder="255 chars max...">{{ $model->getData()['mvp_testing'] }}</textarea>
</div>
