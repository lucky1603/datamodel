@php
    $ext = pathinfo( $attribute->getValue()['filename'],PATHINFO_EXTENSION);

    $color = 'transparent';
    switch($ext) {
        case 'xlsx':
            $color = 'green';
            break;
        case 'docx':
            $color = 'darkblue';
            break;
        case 'pdf':
            $color = 'red';
            break;
        default:
            $color = 'gray';
            break;
    }
@endphp
<div style="display: flex; background-color: #efefef" class="border border rounded p-1 mt-1 mr-1 file-info">
    <div style="width: {{ strlen($ext) * 15 }}px; height:40px; align-items: center; display: flex; background-color: {{ $color }}"
         class="text-light float-left font-18 rounded text-center">
        <span class="m-auto file-ext">.{{ strtoupper($ext) }}</span>
    </div>
    <div style="display: flex; flex-direction: column; margin: 0 15px" class="flex-fill">
        <span class="w-100 font-18 font-weight-bold file-name m-auto">{{ $attribute->getValue()['filename'] }}</span>
    </div>
    <a href="{{ $attribute->getValue()['filelink'] }}" target="_blank" title="{{__('Download')}}">
        <div style="display: flex; background-color: white; align-items: center; height: 100%" class="float-right border rounded pl-2 pr-2">
            <i class="m-auto dripicons-download font-18 text-muted text-center" ></i>
        </div>
    </a>
</div>
