<!-- {{auth()->user()}} -->
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="address">@lang('Fee Head')</label>
            {!! Form::select('fee_head_id', $fee_head, $edit ? $user->country_id : '', ['class' => 'form-control input-solid']) !!}
        </div>
        <div class="form-group">
            <label for="address">@lang('Country')</label>
            {!! Form::select('fee_plan_id', $batches, $edit ? $user->country_id : '', ['class' => 'form-control input-solid']) !!}
        </div>
    </div>
    <div class="col-md-6">
    <div class="form-group">
            <label for="amount">@lang('Amount')</label>
            <input type="text" class="form-control input-solid" id="amount"
                   name="amount" placeholder="@lang('Amount (in Rs.)')" value="{{ $edit ? $course->course_duration : '' }}">
        </div>
        <!-- <div class="form-group">
            <label for="address">@lang('Status')</label>
            <select class="form-control input-solid" name="status" aria-invalid="false">
                <option value="">@lang('Select Status')</option>
                <option value="1" {{$edit ? $course->status == 1 ? 'selected' : '' : '' }}>@lang('Active')</option>
                <option value="0" {{$edit ? $course->status == 0 ? 'selected' : '' : '' }}>@lang('Inactive')</option>
            </select>
        </div> -->
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
