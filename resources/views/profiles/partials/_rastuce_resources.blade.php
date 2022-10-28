<h3 class="text-center attribute-label mt-4">{{ __('POTREBE ZA USLUGAMA U NTP BEOGRAD') }}</h3>
<p class="text-right font-italic">(odgovarajuće polje označite sa X)</p>
<table class="w-100 table table-bordered">
    <thead class="bg-dark text-white p-1">
        <tr>
            <td colspan="2">{{ __('Označite potrebne stavke') }}</td>
        </tr>
    </thead>
    <tbody>

        @foreach([
                    'meeting_rooms',
                    '3d_lab',
                    'business_advise_info',
                    'young_talents',
                    'internationalization',
                    'promotion',
                    'nio_contact',
                    'financing_sources',
                    'financial_advise',
                    'resources_other'
                ] as $attname)
        <tr>
            @php
                $attribute = $attributes->where('name', $attname)->first();
            @endphp
            <td style="witdh: 95%">{{ $attribute->label }}</td>
            <td class="text-center" style="width: 5%">

                <input
                    class="checkbox-aligned"
                    type="checkbox"
                    id="{{ $attribute->name }}"
                    name="{{$attribute->name}}"
                    @if($attribute->getValue()) checked @endif style="padding-top: 10px"
                    onclick="
                        if(document.getElementById('{{ $attribute->name }}').checked)
                        {
                        document.getElementById('{{ $attribute->name }}Hidden').disabled = true
                        } else {
                        document.getElementById('{{ $attribute->name }}Hidden').disabled = false;
                        }
                        " @if ($mode == 'anonimous') disabled @endif>
            </td>
        </tr>
        @endforeach
    </tbody>


</table>
