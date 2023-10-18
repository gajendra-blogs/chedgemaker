@include('partials.messages')

<div class="card">
    <div class="card-body">

    <h4 id="error-message" class="text-danger text-center mb-3"></h4>
        <input type="hidden" id="ajaxUrlCenterCourse" value="{{ route('feePlan.getCourseAndCenterName') }}">
        <input type="hidden" id="ajaxUrlfeeHeads" value="{{ route('feePlan.getFeeHeads') }}">
        <form data-href="{{ route('feePlan.storeFeePlan') }}" id="fee-plan-form">
        <input type="hidden" id="fee_plan_id" value="">
            
            @csrf
            <div id="fee-plan-form-errors" class="text-center text-danger"></div>
            <div class="row">
                <!-- <div class="col-md-6">
                    <div class="form-group">
                        <label for="fee_heads_title">@lang('Center Name')</label>
                        <select id="select_center"  class="form-select form-control input-solid" aria-label="Default select example"  name="center_id">
                            <option value="">select center</option>
                            @foreach($centers as $center)
                                 <option value="{{$center->id}}">{{$center->center_name}}</option>
                             @endforeach
                        </select>
                    </div>
                </div> -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="select_course1">@lang('Course Name')</label>
                        <select id="select_course1"  class="form-select form-control input-solid" aria-label="Default select example"  name="course_id">
                        <option value="">select courses</option>
                        @foreach($courses as $course)
                                 <option value="{{$course->id}}">{{$course->course_name}}</option>
                             @endforeach
                        </select>
                        <span id="no-courses" class="text-danger"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fee_heads_title">@lang('Fee Plan Name')</label>
                        <input type="text" class="form-control input-solid" id="fee_plan_name" name="fee_plan_name" placeholder="Enter Fee Plan Name" value="">
                        </select>
                    </div>
                </div>
                <!-- <div class="col-md-4">
                    <div class="form-group">
                        <label for="fee_heads_title">@lang('Module')</label>
                        <select id="select_module"  class="form-select form-control input-solid" aria-label="Default select example"  name="center_id">
                            <option value="">Select Module</option>
                            <option value="1">Basic</option>
                            <option value="2">Intermidate</option>
                          
                        </select>
                    </div>
                </div> -->
                <!-- <div class="col-md-4">
                    <div class="form-group">
                        <label for="fee_heads_title">@lang('Module Name')</label>
                        <select id="select_module"  class="form-select form-control input-solid" aria-label="Default select example"  name="course_id">
                        <option value="">select courses</option>
                            @foreach($courses as $course)
                                 <option value="{{$course->id}}">{{$course->course_name}}</option>
                             @endforeach
                        </select>
                    </div>
                </div> -->
               
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fee_heads_title">@lang('Fee Plan Type')</label>
                        <select id="fee_type" class="form-select form-control input-solid" aria-label="Default select example" name="fee_type" required>
                            <option value="#">Select Type</option>
                            <option value="lumpsum">Lumpsum</option>
                            <option value="installment">Installment</option>
                        </select>
                    </div>
                </div>

            <div class="col-md-6" id="fee_type_div">
                <label>Total Fee </label>
                <input type='text' class='form-control input-solid' id='total_fee'  name='total_fee' required>
            </div>
            </div>
            <!-- <button type='button' id='feeHead' class='btn btn-success btn-sm d-none'>Define Fee Head</button> -->
            <div class="row" id='fee_head_div'>
                  @php
                    $totalfixed=0;
                    @endphp
                    @foreach($feeheads as $feehead)
                    <div class="form-group">
                    <label class="control-label col" for="text"><strong>@lang($feehead->fee_heads_title):</strong></label>
                    <div class="col">
                    <input type="text"  data-id="{{ $feehead->id }}" class="form-control input-solid" value="" id="{{$feehead->fee_heads_title}}" name="feeHeads[]" data-feeHeads=" {{$feehead->id }}" >
                    </div>
                    </div>

                  @endforeach
            </div>
            

            <div  id='installmentShow_div'>
            </div>
            <button type='button' id='installmentShow_btn' class='btn btn-success btn-sm d-none'>Define Installment</button>

            <div  id='installmentShow_div_ins'>
            </div>
        </div>
</div>
<div class="text-center">
    <button type="submit" id="store_feePlan" class="btn btn-success bg-success">Save</button>
</div>
</form>
</div>
</div>

@section('scripts')
{!! HTML::script('assets/js/feePlan/feePlan.js') !!}
@stop