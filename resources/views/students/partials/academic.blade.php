<div>
    <h4>{{$academics[0]->qualification}}</h4>
</div>
<input type="hidden" name=ids[] class="form-control input-solid" value="{{ $edit ? $academics[0]->id : '' }}">
<input type="hidden" name=userids[] class="form-control input-solid" value="{{ $edit ? $academics[0]->user_id : '' }}">
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="qualification">@lang('Qualification')</label>
            <input type="text" class="form-control input-solid" id="qualification"
                   name="10_th_marksheet[]" placeholder="@lang('Qualification')" value="10">
        </div>
        <div class="form-group">
            <label for="institute">@lang('Institute')</label>
            <input type="text" class="form-control input-solid" id="institute"
                   name="10_th_marksheet[]" placeholder="@lang('Institute')" value="{{ $edit ? $academics[0]->institute : '' }}">
        </div>
        <div class="form-group">
            <label for="university">@lang('University')</label>
            <input type="text" class="form-control input-solid" id="university"
                   name="10_th_marksheet[]" placeholder="@lang('University')" value="{{ $edit ? $academics[0]->university : '' }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="passout_year">@lang('Pass Year')</label>
            <div class="form-group">
                <input type="text" name="10_th_marksheet[]" id='passout_year'
                value="{{ $edit ? $academics[0]->passout_year : '' }}" placeholder="@lang('Pass year')" class="form-control input-solid" />
            </div>
        </div>
        <div class="form-group">
            <label for="place">@lang('Place')</label>
            <input type="text" class="form-control input-solid" id="place"
                   name="10_th_marksheet[]" placeholder="@lang('Place')" value="{{ $edit ? $academics[0]->place : '' }}">
        </div>
        <div class="form-group">
            <label for="marks">@lang('Marks')</label>
            <input type="text" class="form-control input-solid" id="marks"
                   name="10_th_marksheet[]" placeholder="@lang('Marks')" value="{{ $edit ? $academics[0]->marks : '' }}">
        </div>
    </div>
</div>


<div>
    <h4>{{$academics[1]->qualification}}</h4>
</div>
<input type="hidden" name=ids[] class="form-control input-solid" value="{{ $edit ? $academics[1]->id : '' }}">
<input type="hidden" name=userids[] class="form-control input-solid" value="{{ $edit ? $academics[1]->user_id : '' }}">
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="qualification">@lang('Qualification')</label>
            <input type="text" class="form-control input-solid" id="qualification"
                   name="12_th_marksheet[]" placeholder="@lang('Qualification')" value="12">
        </div>
        <div class="form-group">
            <label for="institute">@lang('Institute')</label>
            <input type="text" class="form-control input-solid" id="institute"
                   name="12_th_marksheet[]" placeholder="@lang('Institute')" value="{{ $edit ? $academics[1]->institute : '' }}">
        </div>
        <div class="form-group">
            <label for="university">@lang('University')</label>
            <input type="text" class="form-control input-solid" id="university"
                   name="12_th_marksheet[]" placeholder="@lang('University')" value="{{ $edit ? $academics[1]->university : '' }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="passout_year">@lang('Pass Year')</label>
            <div class="form-group">
                <input type="text" name="12_th_marksheet[]" id='passout_year'
                value="{{ $edit ? $academics[1]->passout_year : '' }}" placeholder="@lang('Pass year')" class="form-control input-solid" />
            </div>
        </div>
        <div class="form-group">
            <label for="place">@lang('Place')</label>
            <input type="text" class="form-control input-solid" id="place"
                   name="12_th_marksheet[]" placeholder="@lang('Place')" value="{{ $edit ? $academics[1]->place : '' }}">
        </div>
        <div class="form-group">
            <label for="marks">@lang('Marks')</label>
            <input type="text" class="form-control input-solid" id="marks"
                   name="12_th_marksheet[]" placeholder="@lang('Marks')" value="{{ $edit ? $academics[1]->marks : '' }}">
        </div>
    </div>
</div>


<div>
    <h4>{{$academics[2]->qualification}}</h4>
</div>
<input type="hidden" name=ids[] class="form-control input-solid" value="{{ $edit ? $academics[2]->id : '' }}">
<input type="hidden" name=userids[] class="form-control input-solid" value="{{ $edit ? $academics[2]->user_id : '' }}">
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="qualification">@lang('Qualification')</label>
            <input type="text" class="form-control input-solid" id="qualification"
                   name="graduation[]" placeholder="@lang('Qualification')" value="Graduation">
        </div>
        <div class="form-group">
            <label for="institute">@lang('Institute')</label>
            <input type="text" class="form-control input-solid" id="institute"
                   name="graduation[]" placeholder="@lang('Institute')" value="{{ $edit ? $academics[2]->institute : '' }}">
        </div>
        <div class="form-group">
            <label for="university">@lang('University')</label>
            <input type="text" class="form-control input-solid" id="university"
                   name="graduation[]" placeholder="@lang('University')" value="{{ $edit ? $academics[2]->university : '' }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="passout_year">@lang('Pass Year')</label>
            <div class="form-group">
                <input type="text" name="graduation[]" id='passout_year'
                value="{{ $edit ? $academics[2]->passout_year : '' }}" placeholder="@lang('Pass year')" class="form-control input-solid" />
            </div>
        </div>
        <div class="form-group">
            <label for="place">@lang('Place')</label>
            <input type="text" class="form-control input-solid" id="place"
                   name="graduation[]" placeholder="@lang('Place')" value="{{ $edit ? $academics[2]->place : '' }}">
        </div>
        <div class="form-group">
            <label for="marks">@lang('Marks')</label>
            <input type="text" class="form-control input-solid" id="marks"
                   name="graduation[]" placeholder="@lang('Marks')" value="{{ $edit ? $academics[2]->marks : '' }}">
        </div>
    </div>
</div>

<div>
    <h4>{{$academics[3]->qualification}}</h4>
</div>
<input type="hidden" name=ids[] class="form-control input-solid" value="{{ $edit ? $academics[3]->id : '' }}">
<input type="hidden" name=userids[] class="form-control input-solid" value="{{ $edit ? $academics[3]->user_id : '' }}">
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="qualification">@lang('Qualification')</label>
            <input type="text" class="form-control input-solid" id="qualification"
                   name="post_graduation[]" placeholder="@lang('Qualification')" value="post_graduation">
        </div>
        <div class="form-group">
            <label for="institute">@lang('Institute')</label>
            <input type="text" class="form-control input-solid" id="institute"
                   name="post_graduation[]" placeholder="@lang('Institute')" value="{{ $edit ? $academics[3]->institute : '' }}">
        </div>
        <div class="form-group">
            <label for="university">@lang('University')</label>
            <input type="text" class="form-control input-solid" id="university"
                   name="post_graduation[]" placeholder="@lang('University')" value="{{ $edit ? $academics[3]->university : '' }}">
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="passout_year">@lang('Pass Year')</label>
            <div class="form-group">
                <input type="text" name="post_graduation[]" id='passout_year'
                value="{{ $edit ? $academics[3]->passout_year : '' }}" placeholder="@lang('Pass year')" class="form-control input-solid" />
            </div>
        </div>
        <div class="form-group">
            <label for="place">@lang('Place')</label>
            <input type="text" class="form-control input-solid" id="place"
                   name="post_graduation[]" placeholder="@lang('Place')" value="{{ $edit ? $academics[3]->place : '' }}">
        </div>
        <div class="form-group">
            <label for="marks">@lang('Marks')</label>
            <input type="text" class="form-control input-solid" id="marks"
                   name="post_graduation[]" placeholder="@lang('Marks')" value="{{ $edit ? $academics[3]->marks : '' }}">
        </div>
    </div>
</div>