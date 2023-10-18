<!-- {{auth()->user()}} -->
<div class="card">
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
                <form id="course-form-edit" action="" data-href="{{route('course.update' , $course)}}" method="post" enctype="multipart/form-data">
                    @method('PUT')
                    @endif
                    <form id="course-form" action="" data-href="{{route('course.store')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="row_count" class="row-count" value="">


                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_name">@lang('Name')</label>
                                            <input type="text" class="form-control input-solid" id="course_name" name="course_name" placeholder="@lang('Enter Name')" value="{{ $edit ? $course->course_name : '' }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="course_description">@lang('Description')</label>
                                            <textarea class="form-control input-solid" id="course_description" rows="5" cols="50" name="course_description" placeholder="@lang('Description')" required>{{ $edit ? $course->course_description : '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="course_duration">@lang('Duration')</label>
                                            <input type="text" class="form-control input-solid" id="course_duration" name="course_duration" placeholder="@lang('Duration (in days)')" value="{{ $edit ? $course->course_duration : '' }}">
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
{!! HTML::script('assets/js/course/course.js') !!}
{!! JsValidator::formRequest('Vanguard\Http\Requests\Course\CreateCourseRequest', '#course-form') !!}
@stop