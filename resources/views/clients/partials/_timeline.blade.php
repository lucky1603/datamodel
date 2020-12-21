<div class="timeline-show mb-3 text-center">
    <h5 class="m-0 time-show-name">{{ __('Interest') }}</h5>
</div>

@foreach($model->getSituations() as $situation)
    @if($loop->iteration == 2)
        <div class="timeline-show mb-3 text-center">
            <h5 class="m-0 time-show-name">{{__('Registration')}}</h5>
        </div>
    @endif

    @if($loop->iteration % 2 != 0)
        <div class="timeline-lg-item timeline-item-left">
    @else
        <div class="timeline-lg-item">
    @endif

    <div class="timeline-desk">
        <div class="timeline-box">
            @if($loop->iteration % 2 != 0)
                <span class="arrow-alt"></span>
            @else
                <span class="arrow"></span>
            @endif
            <span class="timeline-icon"><i class="mdi mdi-adjust"></i></span>
            <h4 class="mt-0 mb-1 font-16">{{$situation->getData()['name']}}</h4>
            <p class="text-muted"><small>{{ $situation->getData()['occurred_at'] }}</small></p>
            <p>{{ $situation->getData()['description'] }} </p>
            @if($situation->getDisplayAttributes() != null)
                <table class="@if($situation->getDisplayAttributes()->count() > 1) table-striped @else table-borderless @endif" style="width: 100%">
                    @foreach($situation->getDisplayAttributes() as $attribute)
                        <tr>
                            <td style=" width: @if($situation->getDisplayAttributes()->count() > 1) 50% @else auto @endif">
                                <span class="attribute-label font-12 mt-0 mb-0"><strong>{!! $attribute->label  !!} :</strong></span>
                            </td>
                            @if($attribute->type != 'file')
                                <td>
                                    <span class="text-muted font-12">{!! $attribute->getText() !!} </span>
                                </td>
                            @else
                                <td>
                                    <a href="{{ $attribute->getValue()['filelink'] }}" class="btn-link font-12">{!! $attribute->getValue()['filename'] !!} </a>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </table>
            @endif

            {{--                <a href="javascript: void(0);" class="btn btn-sm btn-light">👍 17</a>--}}
            {{--                <a href="javascript: void(0);" class="btn btn-sm btn-light">❤️ 89</a>--}}
        </div>
    </div>
</div>
@endforeach
