<h3 class="text-center attribute-label m-4">{{ \App\AttributeGroup::where('name', 'rstarts_tim')->first()->label }}</h3>

<div class="text-center mt-2 mb-2">
    <h4 class="attribute-label">Članovi tima</h4>
    <table class="table-bordered w-100">
        <thead class="bg-dark text-light">
        <tr>
            <th class="w-25">Ime i prezime, zvanje</th>
            <th class="w-25">Obrazovanje, iskustvo </th>
            <th class="w-25">Uloga u razvoju startapa, vreme posvećeno razvoju startapa</th>
            <th class="w-25">Drugi posao </th>
        </tr>
        </thead>
        <tbody id="membersBody">
            @if(!isset($teamMembers) || $teamMembers == null || $teamMembers->count() == 0)
                <tr>
                    <td><textarea name="memberName[]" rows="4" class="w-100">aaa</textarea></td>
                    <td><textarea name="memberEducation[]" rows="4" class="w-100"></textarea> </td>
                    <td><textarea name="memberRole[]" rows="4" class="w-100"></textarea></td>
                    <td><textarea name="memberOtherJob[]" rows="4" class="w-100"></textarea></td>
                </tr>
            @else
                @foreach($teamMembers as $teamMember)
                    <tr>
                        <td><textarea name="memberName[]" rows="4" class="w-100">{{ $teamMember->getValue('team_member_name') }}</textarea></td>
                        <td><textarea name="memberEducation[]" rows="4" class="w-100">{{ $teamMember->getValue('team_education') }}</textarea> </td>
                        <td><textarea name="memberRole[]" rows="4" class="w-100">{{ $teamMember->getValue('team_role') }}</textarea></td>
                        <td><textarea name="memberOtherJob[]" rows="4" class="w-100">{{ $teamMember->getValue('team_other_job') }}</textarea></td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <button id="btnAddMember" type="button" class="btn btn-success rounded-circle mt-1" title="Dodaj člana tima" >+</button>
</div>

<div class="text-center mt-4 mb-2">
    <h4 class="attribute-label">Planirana/postojeća osnivačka struktura startapa</h4>
    <table class="table-bordered w-100">
        <thead class="bg-dark text-light">
        <tr>
            <th style="width: 50%">Ime i prezime/naziv privrednog drustva</th>
            <th style="width: 50%">Udeo u startapu kao  registrovanom privrednom društvu</th>
        </tr>
        </thead>
        <tbody id="foundersBody">
            @if( !isset($founders) || $founders == null || $founders->count() == 0)
                <tr>
                    <td><input type="text" name="founderName[]" class="w-100"></td>
                    <td><input type="text" name="founderPart[]" class="w-100"></td>
                </tr>
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
    <button id="btnAddFounder" type="button" class="btn btn-success rounded-circle mt-1" title="Dodaj osnivača" >+</button>
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_founder_cvs')->first();
    @endphp
    <label class="attribute-label col-form-label col-form-label-sm">CV-jevi osnivaca</label>
    <input type="file" multiple name="rstarts_founder_cvs[]" class="form-control">
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
    <label class="attribute-label" for="{{ $attribute->name }}">Linkovi na profile osnivača</label>
    @php
        if(is_array($attribute->getValue())) {
            $val = implode(';', $attribute->getValue());
        } else {
            $val = $attribute->getValue();
        }
    @endphp
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $val }}</textarea>
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_team_history')->first();
    @endphp
    <label class="attribute-label" for="{{ $attribute->name }}">Da li ste do sada, kao tim, saradjivali na zajedničkim projektima/u poslovanju?</label>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() }}</textarea>
</div>

<div class="form-group">
    @php
        $attribute = $attributes->where('name', 'rstarts_app_motive')->first();
    @endphp
    <label class="attribute-label" for="{{ $attribute->name }}">Šta vas je motivisalo da se prijavite za ovaj Program?</label>
    <textarea class="form-control" id="{{$attribute->name}}" name="{{$attribute->name}}" rows="3">{{ $attribute->getValue() }}</textarea>
</div>


