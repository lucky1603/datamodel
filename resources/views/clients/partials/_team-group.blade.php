<h5 class="mb-3 text-uppercase bg-light p-2">
    <i class="mdi mdi-office-building mr-1"></i>
    {{ App\AttributeGroup::get('team_group')->label }}
</h5>

<div class="form-group">
    <label for="{{ $model->getAttribute('team_members')->name }}" class="attribute-label">{{ $model->getAttribute('team_members')->label }}</label>
    <textarea class="form-control" id="{{ $model->getAttribute('team_members')->name }}" name="{{ $model->getAttribute('team_members')->name }}" rows="4" placeholder="{{ __('gui.TeamHint') }}">{{ $model->getData()['team_members'] }}</textarea>
</div>

<div class="form-group">
    <label for="{{ $model->getAttribute('team_members_file')->name }}" class="attribute-label">{!! $model->getAttribute('team_members_file')->label !!}</label>
    @if($model->getAttribute('team_members_file')->getValue() != null)
        <table class="table table-responsive">
            <tr>
                <td><a href="{{ $model->getAttribute('team_members_file')->getValue()['filelink'] }}">{{ $model->getAttribute('team_members_file')->getValue()['filename'] }}</a></td>
            </tr>
            <tr>
                <input type="file" class="form-control" id="{{ $model->getAttribute('team_members_file')->name }}" name="{{ $model->getAttribute('team_members_file')->name }}">
            </tr>
        </table>
    @else
        <input type="file" class="form-control" id="{{ $model->getAttribute('team_members_file')->name }}" name="{{ $model->getAttribute('team_members_file')->name }}">
    @endif
</div>
