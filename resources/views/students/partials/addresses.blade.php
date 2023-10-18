
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="address1">@lang('Address 1')</label>
            <textarea type="text" class="form-control input-solid" id="address1"
                   name="address1" placeholder="@lang('Address1')">{{ $edit ? $addresses->address1 : '' }}</textarea>
        </div>
        <div class="form-group">
            <label for="address2">@lang('Address 2')</label>
            <textarea type="text" class="form-control input-solid" id="address2"
                   name="address2" placeholder="@lang('Address2')">{{ $edit ? $addresses->address2 : '' }}</textarea>
        </div>
        <div class="form-group">
            <label for="country">@lang('Country')</label>
                <select id="country" name="country" class="form-select form-control input-solid"
                            aria-label="Default select example" name="country">
                @foreach($countries as $countrie)
                <option value="{{ $countrie->id }}" {{ $countrie->id == $addresses->country  ? 'selected' : ''}}>{{ $countrie->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="pin_code">@lang('Pin Code')</label>
            <input type="text" class="form-control input-solid" id="pin_code"
                   name="pin_code" placeholder="@lang('Pin Code')" value="{{ $edit ? $addresses->pin_code : '' }}">
        </div>
        <div class="form-group">
            <label for="city">@lang('City')</label>
                <select id="city" name="city" class="form-select form-control input-solid"
                            aria-label="Default select example" name="city">
                @foreach($cities as $city)
                <option value="{{ $city->id }}" {{ $city->id == $addresses->city  ? 'selected' : ''}}>{{ $city->city}}</option>
                @endforeach
                </select>
        </div>
        <div class="form-group">
            <label for="state">@lang('State')</label>
                <select id="state" name="state" class="form-select form-control input-solid"
                            aria-label="Default select example" name="course_id">
                @foreach($states as $state)
                <option value="{{ $state->id }}" {{ $state->id == $addresses->state  ? 'selected' : ''}}>{{ $state->name }}</option>
                @endforeach
                </select>
        </div>
    </div>

    @if ($edit)
        <div class="col-md-12 mt-2">
            <button type="submit" class="btn btn-primary" id="update-details-btn">
                <i class="fa fa-refresh"></i>
                @lang('Update Address Details')
            </button>
        </div>
    @endif
</div>
