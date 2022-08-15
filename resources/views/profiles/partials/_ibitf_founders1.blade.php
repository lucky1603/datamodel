<h3 class="text-center attribute-label m-4">{{ \App\AttributeGroup::where('name', 'ibitf_founders')->first()->label }}</h3>

<div class="row">
    <div class="col-sm-12 text-center">
        <table class="table-centered table-bordered w-100">
            <thead class="bg-dark text-light text-sm-center">
            <tr>
                <th>Ime i prezime</th>
                <th>Završeni fakultet</th>
                <th>Okvirno planirani udeo u %</th>
            </tr>
            </thead>
            <tbody id="foundersBody">
                @if( !isset($founders) || $founders == null || $founders->count() == 0)
                @if(old('founderName') != null)
                    @for($i = 0; $i < count(old('founderName')); $i ++)
                        @if($i != 0 && old('founderName') == null)
                            @continue
                        @endif

                        <tr>
                            <td>
                                <input type="text" name="founderName[]" class="w-100 @error('founderName.*') is-invalid @enderror" value="{{ old('founderName.'.$i) }}">
                                @error('founderName.*') <div class="alert alert-danger">{{ $message }}</div>@enderror
                            </td>
                            <td>
                                <input type="text" name="founderUniversity[]" class="w-100" @error('founderUniversity.*') is-invalid @enderror value="{{ old('founderUniversity.'.$i) }}">
                                @error('founderUniversity.*') <div class="alert alert-danger">{{ $message }}</div>@enderror
                            </td>
                            <td>
                                <input type="text" name="founderPart[]" class="w-100 @error('founderPart.*') is-invalid @enderror" value="{{ old('founderPart.'.$i) }}">
                                @error('founderPart.*') <div class="alert alert-danger">{{ $message }}</div>@enderror

                            </td>
                        </tr>
                    @endfor
                @else
                    <tr>
                        <td>
                            <input type="text" name="founderName[]" class="w-100 @error('founderName.*') is-invalid @enderror" >
                            @error('founderName.*') <div class="alert alert-danger">{{ $message }}</div>@enderror
                        </td>
                        <td>
                            <input type="text" name="founderUniversity[]" class="w-100" @error('founderUniversity.*') is-invalid @enderror >
                            @error('founderUniversity.*') <div class="alert alert-danger">{{ $message }}</div>@enderror
                        </td>
                        <td>
                            <input type="text" name="founderPart[]" class="w-100 @error('founderPart.*') is-invalid @enderror" value="0">
                            @error('founderPart.*') <div class="alert alert-danger">{{ $message }}</div>@enderror
                        </td>
                    </tr>
                @endif
            @else
                @foreach($founders as $founder)
                    <tr>
                        <td>
                            <input type="text" name="founderName[]" class="w-100" value="{{ $founder->getValue('founder_name') }}">
                            @error('founderName.*') <div class="alert alert-danger">{{ $message }}</div>@enderror
                        </td>
                        <td>
                            <input type="text" name="founderUniversity[]" class="w-100" value="{{ $founder->getValue('founder_university') }}">
                            @error('founderUniversity.*') <div class="alert alert-danger">{{ $message }}</div>@enderror
                        </td>
                        <td>
                            <input type="text" name="founderPart[]" class="w-100" value="{{ $founder->getValue('founder_part') }}">
                            @error('founderPart.*') <div class="alert alert-danger">{{ $message }}</div>@enderror
                        </td>
                    </tr>
                @endforeach
            @endif

            </tbody>
        </table>

        <button id="btnAddFounder" type="button" class="btn btn-success rounded-circle mt-1" title="Dodaj osnivača" >+</button>
    </div>
</div>

