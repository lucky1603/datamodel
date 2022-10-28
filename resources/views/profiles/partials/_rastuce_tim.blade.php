<h3 class="text-center attribute-label m-4">{{ mb_strtoupper(__('Tim')) }}</h3>
@php
    $attribute = $attributes->where('name', 'team_description')->first();
@endphp
<div class="form-group mt-2">
    <label for="{{ $attribute->name }}" class="attribute-label">{!! $attribute->label !!}</label><br/>
    <div class="mt-0" style="font-size: 12px;">
        <div class="font-italic">* Molim opišite da li je tim:</div>
        <div>
            <table class="table table-borderless">
                <tr>
                    <td style="width: 5%; float: right" class="py-0">1.</td>
                    <td style="width: 95%;" class="py-0">uspostavljen (minimum 2 člana tima)</td>
                </tr>
                <tr>
                    <td style="width: 5%; float: right" class="py-0">2.</td>
                    <td style="width: 95%" class="py-0">razvijen - multidisciplinaran i kompetentan sa jasno podeljenim ulogama i </td>
                </tr>
                <tr>
                    <td style="width: 5%; float: right" class="py-0">3.</td>
                    <td style="width: 95%" class="py-0">
                        Angažovan sa posvećenošću članova tima razvoju proizvoda - opišite
                        stepen angažovanosti članova koji rade na razvoju inovativnog proizvoda
                        , kao i iskustvom  osnivača i/ili članova tima u preduzetništvu i vođenju poslovanja.
                    </td>
                </tr>
            </table>
        </div>

    </div>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="4" @if ($mode == 'anonimous') disabled @endif>{{ $attribute->getValue() }}</textarea>
</div>
