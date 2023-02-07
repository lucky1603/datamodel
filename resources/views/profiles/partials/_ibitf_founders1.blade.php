<h3 class="text-center @if($mode == 'anonimous') attribute-grayed @else attribute-label @endif m-4 @if($mode != 'anonimous') mandatory-label @endif">{{ \App\AttributeGroup::where('name', 'ibitf_founders')->first()->label }}</h3>

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
                                <input type="text" name="founderName[]" class="w-100 @error('founderName.*') is-invalid @enderror" value="{{ old('founderName.'.$i) }}" @if ($mode == 'anonimous') disabled @endif>
                                @error('founderName.*') <div class="alert alert-danger">{{ $message }}</div>@enderror
                            </td>
                            <td>
                                <input type="text" name="founderUniversity[]" class="w-100" @error('founderUniversity.*') is-invalid @enderror value="{{ old('founderUniversity.'.$i) }}" @if ($mode == 'anonimous') disabled @endif
                                @error('founderUniversity.*') <div class="alert alert-danger">{{ $message }}</div>@enderror
                            </td>
                            <td>
                                <input type="text" name="founderPart[]" class="w-100 @error('founderPart.*') is-invalid @enderror" value="{{ old('founderPart.'.$i) }}" @if ($mode == 'anonimous') disabled @endif>
                                @error('founderPart.*') <div class="alert alert-danger">{{ $message }}</div>@enderror
                            </td>
                            <td>
                                <img src="/images/custom/Delete-icon.png" role="button" width="16" height="16" class="delete-icon"/>
                            </td>
                        </tr>
                    @endfor
                @else
                    <tr>
                        <td>
                            <input type="text" name="founderName[]" class="w-100 @error('founderName.*') is-invalid @enderror"  @if ($mode == 'anonimous') disabled @endif>
                            @error('founderName.*') <div class="alert alert-danger">{{ $message }}</div>@enderror
                        </td>
                        <td>
                            <input type="text" name="founderUniversity[]" class="w-100" @error('founderUniversity.*') is-invalid @enderror  @if ($mode == 'anonimous') disabled @endif>
                            @error('founderUniversity.*') <div class="alert alert-danger">{{ $message }}</div>@enderror
                        </td>
                        <td>
                            <input type="text" name="founderPart[]" class="w-100 @error('founderPart.*') is-invalid @enderror" value="0" @if ($mode == 'anonimous') disabled @endif>
                            @error('founderPart.*') <div class="alert alert-danger">{{ $message }}</div>@enderror
                        </td>
                        <td>
                            <img src="/images/custom/Delete-icon.png" role="button" width="16" height="16" class="delete-icon"/>
                        </td>
                    </tr>
                @endif
            @else
                @php
                    $counter = 0;
                @endphp
                @foreach($founders as $founder)
                    <tr>
                        <td>
                            <input type="text" name="founderName[]" class="w-100" value="{{ $founder->getValue('founder_name') }}" @if ($mode == 'anonimous') disabled @endif>
                            @error('founderName.*') <div class="alert alert-danger">{{ $message }}</div>@enderror
                        </td>
                        <td>
                            <input type="text" name="founderUniversity[]" class="w-100" value="{{ $founder->getValue('founder_university') }}" @if ($mode == 'anonimous') disabled @endif>
                            @error('founderUniversity.*') <div class="alert alert-danger">{{ $message }}</div>@enderror
                        </td>
                        <td>
                            <input type="text" name="founderPart[]" class="w-100" value="{{ $founder->getValue('founder_part') }}" @if ($mode == 'anonimous') disabled @endif>
                            @error('founderPart.*') <div class="alert alert-danger">{{ $message }}</div>@enderror
                        </td>
                        <td>
                            <img src="/images/custom/Delete-icon.png" role="button" width="16" height="16" class="delete-icon"/>
                        </td>

                    </tr>
                @endforeach
            @endif

            </tbody>
        </table>

        <button id="btnAddFounder" type="button" class="btn btn-success rounded-circle mt-1" title="Dodaj osnivača" >+</button>
    </div>
</div>
