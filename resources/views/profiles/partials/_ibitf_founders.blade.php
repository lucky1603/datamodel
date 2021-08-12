<h3 class="text-center attribute-label m-4">{{ \App\AttributeGroup::where('name', 'ibitf_founders')->first()->label }}</h3>

<div class="row">
    <div class="col-sm-12">
        <table class="table-centered table-bordered w-100">
            <thead class="bg-dark text-light text-sm-center">
            <tr>
                <th>Ime i prezime</th>
                <th>Završeni fakultet</th>
                <th>Okvirno planirani udeo u %</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                @php
                    $attribute = $attributes->where('name', 'founder_name_1')->first();
                @endphp
                <td class="w-25"> <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" class="w-100"></td>

                @php
                    $attribute = $attributes->where('name', 'founder_university_1')->first();
                @endphp
                <td class="w-50"> <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" class="w-100"></td>

                @php
                    $attribute = $attributes->where('name', 'founder_share_1')->first();
                @endphp
                <td class="w-25"> <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" class="w-100"></td>

            </tr>
            <tr>
                @php
                    $attribute = $attributes->where('name', 'founder_name_2')->first();
                @endphp
                <td> <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" class="w-100"></td>

                @php
                    $attribute = $attributes->where('name', 'founder_university_2')->first();
                @endphp
                <td> <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" class="w-100"></td>

                @php
                    $attribute = $attributes->where('name', 'founder_share_2')->first();
                @endphp
                <td> <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" class="w-100"></td>

            </tr>
            <tr>
                @php
                    $attribute = $attributes->where('name', 'founder_name_3')->first();
                @endphp
                <td> <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" class="w-100"></td>

                @php
                    $attribute = $attributes->where('name', 'founder_university_3')->first();
                @endphp
                <td> <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" class="w-100"></td>

                @php
                    $attribute = $attributes->where('name', 'founder_share_3')->first();
                @endphp
                <td> <input type="text" id="{{ $attribute->name }}" name="{{ $attribute->name }}" value="{{ $attribute->getValue() }}" class="w-100"></td>

            </tr>

            </tbody>
        </table>
    </div>
</div>

