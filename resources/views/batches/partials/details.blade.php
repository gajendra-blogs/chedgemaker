<div class="card border-primary">
    <div class="col-lg-12">
        @if ($edit)
        <div class="float-left">
            <h3 class="card-title mt-2">Edit</h3>
        </div>
        @else
        <div class="float-left">
            <h3 class="card-title mt-2">Create</h3>
        </div>
        @endif
    </div>
    <hr style="margin-top: -6px;margin-bottom: -21px;">
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">

                
                @if($edit)
                <form action="" data-href="{{ route('batches.update', $batch) }}" method="POST" id="batch-form-edit">
                    @method('PUT')
                    @else
                    <form action="" data-href="{{route('batches.store')}}" method="POST" id="batch-form">
                        @method('POST')
                        @endif
                        @csrf
                        <input type="hidden" name="row_count" class="row-count" value="">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status">@lang('Center')</label>
                                            {!! Form::select('center_id', $centers, $edit ? $centers->id : '',
                                            ['class' => 'form-control input-solid', 'id' => 'center']) !!}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="form-group">
                                            <label for="status">@lang('Course')</label>
                                            {!! Form::select('course_id[]', $courses, $edit ? $courses->id : '',
                                            ['multiple' , 'required' , 'class' => 'form-control input-solid custom-select', 'id' => 'center_id']) !!}
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