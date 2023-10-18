<div class="card border-primary">
    <div class="col-lg-12">
        @if ($edit)
        <div class="float-left">
            <h3 class="card-title mt-2">Edit Center</h3>
        </div>
        @else
        <div class="float-left">
            <h3 class="card-title mt-2">Create Center</h3>
        </div>
        @endif
    </div>
    <hr style="margin-top: -6px;margin-bottom: -21px;">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                @if($edit)
                <form enctype="multipart/form-data" id="center-form-edit" method="POST" data-href="{{ route('center.update', $center->id) }}">
                    @else
                    <form enctype="multipart/form-data" id="center-form" method="POST" data-href="{{ route('center.store') }}">
                        @endif
                        @csrf
                        <input type="hidden" name="row_count" class="row-count" value="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="center_code">@lang('Code')</label>
                                    <input type="code" class="form-control input-solid  " id="center_code" name="center_code" placeholder="Enter Code" value="{{ $edit ? $center->center_code : ''}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="center_name">@lang('Name')</label>
                                    <input type="center_name" class="form-control input-solid  " id="center_name" name="center_name" placeholder="Enter Name" value="{{ $edit ? $center->center_name : ''}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="center_location">@lang('Location')</label>
                                    <input type="text" class="form-control input-solid" id="center_location" placeholder="Enter Location" name="center_location" value="{{ $edit ? $center->center_location : '' }}">
                                </div>
                            </div>
                        <!-- </div> -->
                        <!-- <div class="row"> -->
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="center_email">@lang('Email')</label>
                                    <input type="center_email" class="form-control input-solid  " id="center_email" name="center_email" placeholder="Enter Email" value="{{ $edit ? $center->center_email : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_number">@lang('Contact No.')</label>
                                    <input type="text" class="form-control input-solid" id="contact_number" placeholder="Enter Phone" name="contact_number" value="{{ $edit ? $center->contact_number : '' }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact_person">@lang('Contact Person.')</label>
                                    <input type="text" class="form-control input-solid" id="contact_person" placeholder="Enter Contact Person" name="contact_person" value="{{ $edit ? $center->contact_person : '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12   ">
                                @if ($edit)
                                <button type="submit" class="btn btn-primary">
                                    @lang('Update')
                                </button>
                                @else
                                <button type="submit" class="btn btn-primary">
                                    @lang('Create')
                                </button>
                                @endif
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>