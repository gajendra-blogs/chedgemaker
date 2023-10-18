<form action="{{route('student.update.address' , $address->id)}}" method="post"  id="update-address-form">
  @csrf
  @method('PUT')
    <div class="row">
        <div class="col-md-6">

            <div class="form-group">
                <label for="address1">Address 1</label>
                <input type="text" class="form-control input-solid" id="address1" name="address1" placeholder="@lang('Address 1')" value="{{ $edit ? $address->address1 : '' }}">
            </div>
            <div class="form-group">
                <label for="address2">Address 2</label>
                <input type="text" class="form-control input-solid" id="address2" name="address2" placeholder="@lang('Address 2')" value="{{ $edit ? $address->address2 : '' }}">
            </div>
            <div class="form-group">
                <label for="pincode">Pincode</label>
                <div class="form-group">
                    <input type="text" placeholder="Pin Code" name="pincode" id='pincode' value="{{ $edit ? $address->pin_code : '' }}" class="form-control input-solid" />
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="birthday">Select Country</label>
                <select id="country" name="country" class="form-control ">
                    <option value="">Choose Country</option>
                    @foreach ($countries as $country)
                    <option value="{{$country->id}}" {{$country->id == $address->country  ? 'selected' : ''}}>
                        {{ $country->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="phone">Select State</label>
                <select name="state" id="state" class="form-control">
                    <option value="">Select State</option>
                    @foreach ($states as $state)
                    <option value="{{$state->id}}" {{$state->id == $address->state ? 'selected' : ''}}>
                        {{ $state->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="">Select City</label>
                <select name="city" id="city" class="form-control input-solid">
                    <option value="">Select City</option>
                    @foreach ($cities as $city)
                    <option value="{{$city->id}}" {{$city->id == $address->city  ? 'selected' : ''}}>
                        {{ $city->city }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        @if ($edit)
        <div class="col-md-12 mt-2">
            <button type="submit" class="btn btn-primary" id="update-details-btn">
                <i class="fa fa-refresh"></i>
                Update Address
            </button>
        </div>
        @endif
    </div>
</form>

