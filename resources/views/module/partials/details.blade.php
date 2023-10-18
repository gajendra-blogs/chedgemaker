
<div class="card">
    <div class="col-lg-12">
        @if ($edit)
        <div class="float-left">
            <h3 class="card-title mt-2">Edit Module</h3>
        </div>
        @else
        <div class="float-left">
            <h3 class="card-title mt-2">Create Module</h3>
        </div>
        @endif
    </div>
    <hr style="margin-top: -6px;margin-bottom: -21px;">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                @if($edit)
                <form id="module-form-edit" action="" data-href="{{route('module.update' , $module)}}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @endif
                    <form id="module-form" action="" data-href="{{route('module.store')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="row_count" class="row-count" value="">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">@lang('Name')</label>
                                            <input type="text" class="form-control input-solid" id="name" name="name" placeholder="@lang('Enter Name')" value="{{ $edit ? $module->name : '' }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="description">@lang('Description')</label>
                                            <textarea class="form-control input-solid" id="description" rows="5" cols="50" name="description" placeholder="@lang('Enter Description')" required>{{ $edit ? $module->description : '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="duration">@lang('Duration')</label>
                                            <input type="text" class="form-control input-solid" id="duration" name="duration" placeholder="@lang('Duration (in days)')" value="{{ $edit ? $module->duration : '' }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="fees">@lang('Module Fee')</label>
                                            <input type="text" class="form-control input-solid" id="fees" name="fees" placeholder="@lang('Fees (in Rs)')" value="{{ $edit ? $module->fees : '' }}">
                                        </div>
                                    </div>

                                    @if ($edit)
                                    <div class="col-md-12 mt-2">
                                        <button type="submit" class="btn btn-primary" id="update-details-btn">
                                            <i class="fa fa-refresh"></i>
                                            @lang('Update')
                                        </button>
                                    </div>
                                    @else

                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary">
                                            @lang('Create')
                                        </button>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>


                    </form>
            </div>
        </div>
    </div>
</div>


@section('scripts')
    {!! HTML::script('assets/js/module/module.js') !!}
@stop