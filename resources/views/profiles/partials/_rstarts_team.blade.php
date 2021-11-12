<h3 class="text-center attribute-label m-4">{{ \App\AttributeGroup::where('name', 'rstarts_tim')->first()->label }}</h3>

<div class="text-center mt-2 mb-2">
    <h4 class="attribute-label">Članovi tima</h4>
    <table class="table-bordered w-100">
        <thead class="bg-dark text-light">
        <tr>
            <th class="w-25 p-1">Ime i prezime, zvanje

            </th>
            <th class="w-25 p-1">
                Obrazovanje, iskustvo

                <p class="font-11 font-weight-normal mt-2">
                    (navedite i ukoliko ste imali prethodno iskustvo u razvoju poslovanja/pokretanju startapa ili biznisa)
                </p>
                <p class="font-11 font-weight-normal">
                    Napomena: navedeno iskustvo i obrazovanje je potrebno da bude reflektovano u priloženim CV-jevima
                </p>

            </th>
            <th class="w-25">
                Uloga u razvoju startapa, vreme posvećeno razvoju startapa
                <ul class="font-11 font-weight-normal text-left mt-2">
                    <li>Potpuno posvećen,</li>
                    <li>u većoj meri prosvećen,</li>
                    <li>delimično posvećen,</li>
                    <li>u manjoj meri posvećen</li>
                </ul>
            </th>
            <th class="w-25">
                Drugi posao
                <p class="font-11 font-weight-normal mt-2">
                    (full-time, part-time) / <strong>obaveze / studije</strong> (osnovne studije/
                    apsolvent/ master studije) <strong>i
                        navedite koliko ste angažovani na tome</strong>
                </p>
            </th>
        </tr>
        </thead>
        <tbody id="membersBody">
            @if(!isset($teamMembers) || $teamMembers == null || $teamMembers->count() == 0)
                @if(old('memberName') != null)
                    @for($i = 0; $i < count(old('memberName')); $i++)
                        @if( $i != 0 && old('memberName.'.$i) == '')
                            @continue
                        @endif
                        <tr>
                            <td><textarea name="memberName[]" rows="4" class="w-100 @error('memberName.*') is-invalid @enderror">{{ old('memberName.'.$i) }}</textarea></td>
                            <td><textarea name="memberEducation[]" rows="4" class="w-100 @error('memberEducation.*') is-invalid @enderror">{{ old('memberEducation.'.$i) }}</textarea></td>
                            <td><textarea name="memberRole[]" rows="4" class="w-100 @error('memberRole.*') is-invalid @enderror">{{ old( 'memberRole.'.$i) }}</textarea></td>
                            <td><textarea name="memberOtherJob[]" rows="4" class="w-100 @error('memberOtherJob.*') is-invalid @enderror">{{ old('memberOtherJob.'.$i) }}</textarea></td>
                        </tr>
                    @endfor
                @else
                    <tr>
                        <td><textarea name="memberName[]" rows="4" class="w-100 @error('memberName.*') is-invalid @enderror"></textarea></td>
                        <td><textarea name="memberEducation[]" rows="4" class="w-100 @error('memberEducation.*') is-invalid @enderror"></textarea></td>
                        <td><textarea name="memberRole[]" rows="4" class="w-100 @error('memberRole.*') is-invalid @enderror"></textarea></td>
                        <td><textarea name="memberOtherJob[]" rows="4" class="w-100 @error('memberOtherJob.*') is-invalid @enderror"></textarea></td>
                    </tr>

                    <tr>
                        <td><textarea name="memberName[]" rows="4" class="w-100 @error('memberName.*') is-invalid @enderror"></textarea></td>
                        <td><textarea name="memberEducation[]" rows="4" class="w-100 @error('memberEducation.*') is-invalid @enderror"></textarea></td>
                        <td><textarea name="memberRole[]" rows="4" class="w-100 @error('memberRole.*') is-invalid @enderror"></textarea></td>
                        <td><textarea name="memberOtherJob[]" rows="4" class="w-100 @error('memberOtherJob.*') is-invalid @enderror"></textarea></td>
                    </tr>
                @endif
            @else
                @foreach($teamMembers as $teamMember)
                    <tr>
                        <td><textarea name="memberName[]" rows="4" class="w-100" required>{{ $teamMember->getValue('team_member_name') }}</textarea></td>
                        <td><textarea name="memberEducation[]" rows="4" class="w-100">{{ $teamMember->getValue('team_education') }}</textarea> </td>
                        <td><textarea name="memberRole[]" rows="4" class="w-100">{{ $teamMember->getValue('team_role') }}</textarea></td>
                        <td><textarea name="memberOtherJob[]" rows="4" class="w-100">{{ $teamMember->getValue('team_other_job') }}</textarea></td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    @error('memberName')<div class="alert alert-danger">{{ $message }}</div>@enderror
    <button id="btnAddMember" type="button" class="btn btn-success rounded-circle mt-1" title="Dodaj člana tima" >+</button>
</div>

<div class="text-center mt-4 mb-2">
    <h4 class="attribute-label">Planirana/postojeća osnivačka struktura startapa</h4>
    <table class="table-bordered w-100">
        <thead class="bg-dark text-light">
        <tr>
            <th style="width: 50%">Ime i prezime/naziv privrednog drustva</th>
            <th style="width: 50%">Udeo u startapu kao  registrovanom privrednom društvu [%]</th>
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
                            </td>
                            <td>
                                <input type="text" name="founderPart[]" class="w-100 @error('founderPart.*') is-invalid @enderror" value="{{ old('founderPart.'.$i) }}">
                            </td>
                        </tr>
                    @endfor
                @else
                    <tr>
                        <td>
                            <input type="text" name="founderName[]" class="w-100 @error('founderName.*') is-invalid @enderror" >
                        </td>
                        <td>
                            <input type="text" name="founderPart[]" class="w-100 @error('founderPart.*') is-invalid @enderror" >
                        </td>
                    </tr>
                @endif
            @else
                @foreach($founders as $founder)
                    <tr>
                        <td><input type="text" name="founderName[]" class="w-100" value="{{ $founder->getValue('founder_name') }}"></td>
                        <td><input type="text" name="founderPart[]" class="w-100" value="{{ $founder->getValue('founder_part') }}"></td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    @error('founderName') <div class="alert alert-danger">{{ $message }}</div>@enderror
    <button id="btnAddFounder" type="button" class="btn btn-success rounded-circle mt-1" title="Dodaj osnivača" >+</button>
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_founder_cvs')->first();
    @endphp
    <label class="attribute-label col-form-label col-form-label-sm">CV-jevi minimum dva postojeća/planirana osnivača startapa</label>
    <input type="file" multiple name="rstarts_founder_cvs[]" id="rstarts_founder_cvs" class="form-control @error('rstarts_founder_cvs') is-invalid @enderror">
    @error('rstarts_founder_cvs') <div class="alert alert-danger">{{ $message }}</div>@enderror
    @if($attribute != null && $attribute->getValue() != null)
        @if(isset($attribute->getValue()['filelink']))
            <a href="{{$attribute->getValue()['filelink']}}" target="_blank">{{ $attribute->getValue()['filename'] }}</a>
        @else
            <div style="display: flex">
                @foreach($attribute->getValue() as $file)
                    <a class="mr-2" href="{{$file['filelink']}}" target="_blank">{{ $file['filename'] }}</a>
                @endforeach
            </div>
        @endif
    @endif
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_founder_links')->first();
    @endphp
    <label class="attribute-label" for="{{ $attribute->name }}">Linkovi ka <u>LinkedIn</u> profilima osnivača <span class="font-12 text-dark font-weight-normal">(linkove upisati u ovo polje, odvojene tačkom-zarezom).</span></label>
    @php
        if(is_array($attribute->getValue())) {
            $val = implode(';', $attribute->getValue());
        } else {
            $val = $attribute->getValue() ?? old($attribute->name);
        }
    @endphp
    <textarea class="form-control @error("rstarts_founder_links") is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $val }}</textarea>
    @error('rstarts_founder_links') <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_team_history')->first();
    @endphp
    <label class="attribute-label" for="{{ $attribute->name }}">Da li ste do sada, kao tim, saradjivali na zajedničkim projektima/u poslovanju?</label>
    <textarea class="form-control @error("rstarts_team_history") is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() ?? old($attribute->name) }}</textarea>
    @error('rstarts_team_history') <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_app_motive')->first();
    @endphp
    <label class="attribute-label" for="{{ $attribute->name }}">Šta vas je motivisalo da se prijavite za ovaj Program?</label>
    <textarea class="form-control @error("rstarts_app_motive") is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() ?? old($attribute->name) }}</textarea>
    @error('rstarts_app_motive') <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>


