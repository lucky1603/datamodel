<h3 class="text-center attribute-label" style="margin-top: 120px;">{{ \App\AttributeGroup::where('name', 'rstarts_tim')->first()->label }}</h3>

<div class="text-center mt-2 mb-2">
    <h4 class="attribute-label @if(isset($model)) mandatory-label @endif">Članovi tima </h4>
    <div class="overflow-auto">
        <table class="table-bordered w-100 no-gutters">
            <thead class="bg-dark text-light">
            <tr>
                <th class="w-25 py-1">Ime i prezime, zvanje

                </th>
                <th class="w-25 py-1">
                    Obrazovanje, iskustvo

                    <p class="font-11 font-weight-normal mt-2">
                        (navedite i ukoliko ste imali prethodno iskustvo u razvoju poslovanja/pokretanju startapa ili biznisa)
                    </p>
                    <p class="font-11 font-weight-normal">
                        Napomena: navedeno iskustvo i obrazovanje je potrebno da bude reflektovano u priloženim CV-jevima
                    </p>
                    <p class="font-10 font-weight-normal">
                        (max 1050 karaktera)
                    </p>

                </th>
                <th class="w-25 py-1">
                    Uloga u razvoju startapa, vreme posvećeno razvoju startapa
                    <ul class="font-11 font-weight-normal text-left mt-2">
                        <li>Potpuno posvećen,</li>
                        <li>u većoj meri prosvećen,</li>
                        <li>delimično posvećen,</li>
                        <li>u manjoj meri posvećen</li>
                    </ul>
                    <p class="m-4 font-weight-bold font-11">
                        Jasno naznačiti koji članovi tima su kreatori ideje
                    </p>
                </th>
                <th class="w-25 py-1">
                    Drugi posao
                    <p class="font-11 font-weight-normal mt-2">
                        (full-time, part-time)/<strong>obaveze/studije</strong> (osnovne studije/apsolvent/master studije) <strong>i
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
                            <td>
                                <textarea name="memberName[]" rows="4" class="w-100 @error('memberName.*') is-invalid @enderror" @if($mode == 'anonimous') disabled @endif>{{ old('memberName.'.$i) }}</textarea>
                                @error('memberName.*')<div class="alert alert-danger">{{ $message }}</div>@enderror
                            </td>
                            <td>
                                <textarea name="memberEducation[]" rows="4" class="w-100 @error('memberEducation.*') is-invalid @enderror" @if($mode == 'anonimous') disabled @endif>{{ old('memberEducation.'.$i) }}</textarea>
                                @error('memberEducation.*')<div class="alert alert-danger">{{ $message }}</div>@enderror
                            </td>
                            <td>
                                <textarea name="memberRole[]" rows="4" class="w-100 @error('memberRole.*') is-invalid @enderror"  @if($mode == 'anonimous') disabled @endif>{{ old( 'memberRole.'.$i) }}</textarea>
                                @error('memberRole.*')<div class="alert alert-danger">{{ $message }}</div>@enderror
                            </td>
                            <td>
                                <textarea name="memberOtherJob[]" rows="4" class="w-100 @error('memberOtherJob.*') is-invalid @enderror"  @if($mode == 'anonimous') disabled @endif>{{ old('memberOtherJob.'.$i) }}</textarea>
                                @error('memberOtherJob.*')<div class="alert alert-danger">{{ $message }}</div>@enderror
                            </td>
                            <td>
                                <img src="/images/custom/Delete-icon.png" role="button" width="16" height="16" class="delete-icon"/>
                            </td>
                        </tr>
                    @endfor
                @else
                    <tr>
                        <td><textarea name="memberName[]" rows="4" class="w-100 @error('memberName.*') is-invalid @enderror"  @if($mode == 'anonimous') disabled @endif></textarea></td>
                        <td><textarea name="memberEducation[]" rows="4" class="w-100 @error('memberEducation.*') is-invalid @enderror"  @if($mode == 'anonimous') disabled @endif></textarea></td>
                        <td><textarea name="memberRole[]" rows="4" class="w-100 @error('memberRole.*') is-invalid @enderror"  @if($mode == 'anonimous') disabled @endif></textarea></td>
                        <td><textarea name="memberOtherJob[]" rows="4" class="w-100 @error('memberOtherJob.*') is-invalid @enderror"  @if($mode == 'anonimous') disabled @endif></textarea></td>
                        <td>
                            <img src="/images/custom/Delete-icon.png" role="button" width="16" height="16" class="delete-icon"/>
                        </td>
                    </tr>

                    <tr>
                        <td><textarea name="memberName[]" rows="4" class="w-100 @error('memberName.*') is-invalid @enderror" @if($mode == 'anonimous') disabled @endif></textarea></td>
                        <td><textarea name="memberEducation[]" rows="4" class="w-100 @error('memberEducation.*') is-invalid @enderror"  @if($mode == 'anonimous') disabled @endif></textarea></td>
                        <td><textarea name="memberRole[]" rows="4" class="w-100 @error('memberRole.*') is-invalid @enderror"  @if($mode == 'anonimous') disabled @endif></textarea></td>
                        <td><textarea name="memberOtherJob[]" rows="4" class="w-100 @error('memberOtherJob.*') is-invalid @enderror" @if($mode == 'anonimous') disabled @endif></textarea></td>
                        <td>
                            <img src="/images/custom/Delete-icon.png" role="button" width="16" height="16" class="delete-icon"/>
                        </td>
                    </tr>
                @endif
            @else
                @foreach($teamMembers as $teamMember)
                    <tr>
                        <td>
                            <textarea name="memberName[]" rows="4" class="w-100" required @if($mode == 'anonimous') disabled @endif>{{ $teamMember->getValue('team_member_name') }}</textarea>
                            @error('memberName')<div class="alert alert-danger">{{ $message }}</div>@enderror
                        </td>
                        <td>
                            <textarea name="memberEducation[]" rows="4" class="w-100" @if($mode == 'anonimous') disabled @endif>{{ $teamMember->getValue('team_education') }}</textarea>
                            @error('memberEducation')<div class="alert alert-danger">{{ $message }}</div>@enderror
                        </td>
                        <td>
                            <textarea name="memberRole[]" rows="4" class="w-100" @if($mode == 'anonimous') disabled @endif>{{ $teamMember->getValue('team_role') }}</textarea>
                            @error('memberRole')<div class="alert alert-danger">{{ $message }}</div>@enderror
                        </td>
                        <td>
                            <textarea name="memberOtherJob[]" rows="4" class="w-100" @if($mode == 'anonimous') disabled @endif>{{ $teamMember->getValue('team_other_job') }}</textarea>
                            @error('memberOtherJob')<div class="alert alert-danger">{{ $message }}</div>@enderror
                        </td>
                        <td>
                            <img src="/images/custom/Delete-icon.png" role="button" width="16" height="16" class="delete-icon"/>
                        </td>
                    </tr>
                @endforeach
            @endif
            </tbody>
        </table>
    </div>

    <button id="btnAddMember" type="button" class="btn btn-success rounded-circle mt-1" title="Dodaj člana tima" >+</button>
</div>

<div class="text-center mt-4 mb-2">
    <h4 class="attribute-label  @if(isset($model)) mandatory-label @endif">Planirana/postojeća osnivačka struktura startapa</h4>
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
                                <input type="text" name="founderName[]" class="w-100 @error('founderName.*') is-invalid @enderror" value="{{ old('founderName.'.$i) }}" @if($mode == 'anonimous') disabled @endif>
                                @error('founderName.*') <div class="alert alert-danger">{{ $message }}</div>@enderror
                            </td>
                            <td>
                                <input type="text" name="founderPart[]" class="w-100 @error('founderPart.*') is-invalid @enderror" value="{{ old('founderPart.'.$i) }}" @if($mode == 'anonimous') disabled @endif>
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
                            <input type="text" name="founderName[]" class="w-100 @error('founderName.*') is-invalid @enderror"  @if($mode == 'anonimous') disabled @endif>
                            @error('founderName.*') <div class="alert alert-danger">{{ $message }}</div>@enderror
                        </td>
                        <td>
                            <input type="text" name="founderPart[]" class="w-100 @error('founderPart.*') is-invalid @enderror" value="0" @if($mode == 'anonimous') disabled @endif>
                            @error('founderPart.*') <div class="alert alert-danger">{{ $message }}</div>@enderror
                        </td>
                        <td>
                            <img src="/images/custom/Delete-icon.png" role="button" width="16" height="16" class="delete-icon"/>
                        </td>
                    </tr>
                @endif
            @else
                @foreach($founders as $founder)
                    <tr>
                        <td>
                            <input type="text" name="founderName[]" class="w-100" value="{{ $founder->getValue('founder_name') }}" @if($mode == 'anonimous') disabled @endif>
                            @error('founderName.*') <div class="alert alert-danger">{{ $message }}</div>@enderror
                        </td>
                        <td>
                            <input type="text" name="founderPart[]" class="w-100" value="{{ $founder->getValue('founder_part') }}" @if($mode == 'anonimous') disabled @endif>
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

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_founder_cvs')->first();
    @endphp
    <label class="attribute-label col-form-label col-form-label-sm @if(isset($model)) mandatory-label @endif">
        CV-jevi minimum dva postojeća/planirana osnivača startapa <i class="dripicons-information font-18" title="Datoteke moraju biti u
        formatu (.pdf, .docx, .xlsx) i njihova veličina ne sme premašivati 1MB. Svi fajlovi moraju biti istovremeno dodati."></i>
    </label>
    <input
        type="file"
        multiple name="rstarts_founder_cvs[]"
        title="Svi fajlovi moraju biti istovremeno dodati!"
        id="rstarts_founder_cvs"
        class="form-control @error('rstarts_founder_cvs') is-invalid @enderror @if(isset($model)) mandatory-field @endif"
        @if($mode == 'anonimous') disabled @endif>
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
    <textarea class="form-control @error("rstarts_founder_links") is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3" @if($mode == 'anonimous') disabled @endif>{{ $val }}</textarea>
    @error('rstarts_founder_links') <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_team_history')->first();
    @endphp
    <label class="attribute-label @if(isset($model)) mandatory-label @endif" for="{{ $attribute->name }}">
        Da li ste do sada, kao tim, saradjivali na zajedničkim projektima/u poslovanju?
        <span class="font-12 text-dark font-weight-normal">
            (Navedite da li ste prethodno kao tim (ili deo članova tima) radili na razvoju
            startap ideje ili ukoliko ste saradjivali u poslovanju ili zajednički radili u okviru iste organizacije.)
        </span>
    </label>
    <textarea class="form-control @error("rstarts_team_history") is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3" @if($mode == 'anonimous') disabled @endif>{{ $attribute->getValue() ?? old($attribute->name) }}</textarea>
    @error('rstarts_team_history') <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_app_motive')->first();
    @endphp
    <label class="attribute-label @if(isset($model)) mandatory-label @endif" for="{{ $attribute->name }}">Šta vas je motivisalo da se prijavite za ovaj Program? (max 1050 karaktera)</label>
    <textarea class="form-control @error("rstarts_app_motive") is-invalid @enderror" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3" @if($mode == 'anonimous') disabled @endif>{{ $attribute->getValue() ?? old($attribute->name) }}</textarea>
    @error('rstarts_app_motive') <div class="alert alert-danger">{{ $message }}</div>@enderror
</div>


