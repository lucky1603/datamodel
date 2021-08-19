@php
    $program = $model->getActiveProgram();
@endphp

@if($program->getAttributeGroups()->count() > 0)
    <div id="accordion" style="max-height: 400px">
        @foreach($program->getAttributeGroups()->sortBy('sort_order') as $attributeGroup)
            <h5 style="background-color: #00336D;color: white; padding: 5px">{{ $attributeGroup->label }}</h5>
            <div style="overflow: auto;max-height: 300px">
                @foreach($program->getAttributesForGroup($attributeGroup)->sortBy('sort_order') as $attribute)
                    @if($attribute->type === 'file')
                        <div class="row zebra">
                            <div class="col-md-3"><strong>{!! $attribute->label !!} : </strong></div>
                            <div class="col-md-5"><a href="{{ $attribute->getValue()['filelink']}}">{{$attribute->getValue()['filename']}}</a></div>
                        </div>
                    @else
                        @if($attribute->name != 'password')
                            <div class="row zebra">
                                <div class="col-md-3"><strong>{!! $attribute->label !!} : </strong></div>
                                <div class="col-md-5">{{$attribute->getText()}}</div>
                            </div>
                        @endif
                    @endif

                @endforeach
            </div>

        @endforeach
    </div>
    <div style="margin-bottom: 20px"></div>
@else
    @foreach($program->getAttributes() as $attribute)
        @if($attribute->type === 'file')
            <div class="row zebra">
                <div class="col-md-3"><strong>{!! $attribute->label !!} : </strong></div>
                <div class="col-md-5"><a href="{{ $attribute->getValue()['filelink']}}">{{$attribute->getValue()['filename']}}</a></div>
            </div>
        @else
            @if($attribute->name != 'password')
                <div class="row zebra">
                    <div class="col-md-3"><strong>{!! $attribute->label !!} : </strong></div>
                    <div class="col-md-5">{{$attribute->getText()}}</div>
                </div>
            @endif
        @endif

    @endforeach
@endif
