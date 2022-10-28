<h3 class="text-center attribute-label m-4">{{ mb_strtoupper(__('Saradnja sa NIO')) }}</h3>

@php
    $labels = [
        [
            'title' => 'nio_project',
            'subtitle' => '*Navedite naziv projekta i naziv naučno-istraživačkih organizacija (NIO)  sa kojima  sarađujete  na projektu.'
        ],
        [
            'title' => 'ino_vaucer',
            'subtitle' => '*Navedite iznos i naziv NIO iz  koje  ekspert dolazi...'
        ],
        [
            'title' => 'nio_labs',
            'subtitle' => '* Navedite naziv laboratorije i/ili NIO i uslove korišćenja.'
        ],
        [
            'title' => 'nio_event',
            'subtitle' => '* Navedite naziv događaja i kratko opišite tip saradnje'
        ],
        [
            'title' => 'nio_other',
            'subtitle' => ''
        ],

    ]
@endphp

@foreach($labels as $label)
<div class="form-group mt-2">
    @php
        $attribute = $attributes->where('name', $label['title'])->first();
    @endphp
    <label for="{{ $attribute->name }}" class="attribute-label">{!! $attribute->label !!}</label><br/>
    <span class='font-12 font-italic'>{{ $label['subtitle'] }}</span>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="4" @if ($mode == 'anonimous') disabled @endif>{{ $attribute->getValue() }}</textarea>
</div>
@endforeach
