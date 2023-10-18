<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="first_name">@lang('First Name')</label>
            <input type="text" class="form-control input-solid" id="first_name"
                   name="first_name" placeholder="@lang('First Name')" value="{{ $edit ? $student->first_name : '' }}">
        </div>
        <div class="form-group">
            <label for="last_name">@lang('Last Name')</label>
            <input type="text" class="form-control input-solid" id="last_name"
                   name="last_name" placeholder="@lang('Last Name')" value="{{ $edit ? $student->last_name : '' }}">
        </div>
        <div class="form-group">
            <label for="address">@lang('Address')</label>
            <textarea type="text" class="form-control input-solid" id="address"
                   name="address" placeholder="@lang('Address')">{{ $edit ? $student->address : '' }}</textarea>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="birthday">@lang('Date of Birth')</label>
            <div class="form-group">
                <input type="text"
                       name="birthday"
                       id='birthday'
                       value="{{ $edit && $student->birthday ? $student->present()->birthday : '' }}"
                       class="form-control input-solid" />
            </div>
        </div>
        <div class="form-group">
            <label for="phone">@lang('Phone')</label>
            <input type="text" class="form-control input-solid" id="phone"
                   name="phone" placeholder="@lang('Phone')" value="{{ $edit ? $student->phone : '' }}">
        </div>
        <div class="form-group">
            <label for="first_name">@lang('Father Name')</label>
            <input type="text" class="form-control input-solid" id="father_name"
                   name="father_name" placeholder="@lang('Father Name')" value="{{ $edit ? $student->father_name : '' }}">
        </div>
    </div>

    @if ($edit)
        <div class="col-md-12 mt-2">
            <button type="submit" class="btn btn-primary" id="update-details-btn">
                <i class="fa fa-refresh"></i>
                @lang('Update Details')
            </button>
        </div>
    @endif
</div>
