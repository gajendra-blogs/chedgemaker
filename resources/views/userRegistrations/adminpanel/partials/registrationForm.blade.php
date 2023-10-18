<link media="all" type="text/css" rel="stylesheet" href="{{ url('assets/frontend/css/register/register.css') }}">

<div class="mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10 d-flex ">
            <div class="container mb-3">
                <div class="contact-from mt-30">
                    <div class="section-title">
                        <h5>Basic Information</h5>
                    </div>
                    <div class="main-form pt-45">
                        <form action="{{ route('user.postRegister') }}" id="studentRegForm"
                            data-href=" {{ route('states.getStates') }}" method="post" class="mt-3"
                            enctype="multipart/form-data">
                            <input type="hidden" id="cityUrl" data-href="{{ route('city.getCities') }}">
                            <input type="hidden" id="GetCoursesUrl"
                                data-href="{{ route('student.getCourseByCenterId') }}">
                            <input type="hidden" data-href="{{ route('student.getFeePlan') }}" id="GetFeePlanUrl">
                            <input type="hidden" data-href="{{route('student.getCourseById')}}" id="getCourse">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="first_name" id="first_name"
                                            class="form-control input-solid" placeholder="@lang('FirstName')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="last_name" id="last_name"
                                            class="form-control input-solid" placeholder="@lang('LastName')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="email" name="email" id="email" class="form-control input-solid"
                                            placeholder="@lang('Email')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="phone" name="phone" id="phone" class="form-control input-solid"
                                            placeholder="@lang('Phone')">
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group mb-3">
                                        <select id="country" name="country" id="country_id" class="form-control ">
                                            <option>Choose Country</option>
                                            @foreach ($countries as $country)
                                            <option value="{{$country->id}}"
                                                {{$country->name == "India"  ? 'selected' : ''}}>
                                                {{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <select name="state" id="states" class="form-control ">
                                            <option>Select State</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <select name="city" id="cities" class="form-control input-solid">
                                            <option>Select City</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <textarea name="address" id="address" class="form-control input-solid"
                                            placeholder="@lang('Address')" rows="1"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="pin_code" id="pin_code"
                                            class="form-control input-solid" placeholder="@lang('Pin Code')">
                                    </div>
                                </div>
                            </div>
                            <div class="section-title mt-4 mb-3">
                                <h5>Course Information</h5>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <select name="centers" id="centers" class="form-control input-solid">
                                        <option>Select Center</option>
                                        @foreach($centers as $center)
                                        <option value="{{$center->id}}">{{$center->center_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select name="courses" id="courses" class="form-control input-solid">
                                        <option>Select Course</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                      <select name="counsellor_id" id="counsellor_id" class="form-control input-solid">
                                        <option>Select Counsellor</option>
                                        @foreach($counsellers as $counseller)
                                            <option value="{{$counseller->id}}">{{$counseller->first_name}}</option>
                                            @endforeach
                                      </select>
                                    </div>
                                </div>
                            </div>
                            <div class="card container mt-3 d-none" id="paymentTypeDiv">
                                <div class="card-body">
                                    <div id="courseDescription"></div>
                                    <table>
                                        <tr>
                                            <td>
                                                <h5>Payment -</h5>
                                            </td>
                                            <td><select id='paymentType' name="paymentType" class='form-control'>
                                                    <option value='null'>Select</option>
                                                    <option value='lumpsum'>Lumpsum</option>
                                                    <option value='installment'>Installment</option>
                                                </select></td>
                                        </tr>
                                    </table>
                                    <div id="feePlanDetails"></div>
                                </div>
                            </div>

                            <div class="section-title mt-4 mb-3">
                                <h5>Academic Information</h5>
                            </div>

                            <h5 style="color:#07294d">10th Marksheet</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="10_th_marksheet[]" id="institute"
                                            class="form-control input-solid" placeholder="@lang('Institute')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="10_th_marksheet[]" id="university"
                                            class="form-control input-solid" placeholder="@lang('Board')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="10_th_marksheet[]" id="passout_year"
                                            class="form-control input-solid" placeholder="@lang('Passout Year')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="10_th_marksheet[]" id="marks"
                                            class="form-control input-solid" placeholder="@lang('Total Marks')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="10_th_marksheet[]" id="place"
                                            class="form-control input-solid" placeholder="@lang('Place')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="file" name="10_th_marksheet_file" id="document"
                                            class="form-control input-solid form-control-file"
                                            placeholder="@lang('Documents')">
                                    </div>
                                </div>
                            </div>
                            <h5 style="color:#07294d">12th Marksheet</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="12_th_marksheet[]" id="institute"
                                            class="form-control input-solid" placeholder="@lang('Institute')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="12_th_marksheet[]" id="university"
                                            class="form-control input-solid" placeholder="@lang('Board')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="12_th_marksheet[]" id="passout_year"
                                            class="form-control input-solid" placeholder="@lang('Passout Year')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="12_th_marksheet[]" id="marks"
                                            class="form-control input-solid" placeholder="@lang('Total Marks')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="12_th_marksheet[]" id="place"
                                            class="form-control input-solid" placeholder="@lang('Place')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="file" name="12_th_marksheet_File[]" id="document"
                                            class="form-control input-solid form-control-file"
                                            placeholder="@lang('Documents')">
                                    </div>
                                </div>

                            </div>
                            <h5 style="color:#07294d">Graduation</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="graduation[]" id="institute"
                                            class="form-control input-solid" placeholder="@lang('Institute')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="graduation[]" id="university"
                                            class="form-control input-solid" placeholder="@lang('Board')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="graduation[]" id="passout_year"
                                            class="form-control input-solid" placeholder="@lang('Passout Year')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="graduation[]" id="marks"
                                            class="form-control input-solid" placeholder="@lang('Total Marks')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="graduation[]" id="place"
                                            class="form-control input-solid" placeholder="@lang('Place')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="file" name="graduation_file[]" id="document"
                                            class="form-control input-solid form-control-file"
                                            placeholder="@lang('Documents')">
                                    </div>
                                </div>

                            </div>
                            <h5 style="color:#07294d">Post Graduation</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="post_graduation[]" id="institute"
                                            class="form-control input-solid" placeholder="@lang('Institute')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="post_graduation[]" id="university"
                                            class="form-control input-solid" placeholder="@lang('Board')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="post_graduation[]" id="passout_year"
                                            class="form-control input-solid" placeholder="@lang('Passout Year')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="post_graduation[]" id="marks"
                                            class="form-control input-solid" placeholder="@lang('Total Marks')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="post_graduation[]" id="place"
                                            class="form-control input-solid" placeholder="@lang('Place')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="file" name="post_graduation_file[]" id="document"
                                            class="form-control input-solid form-control-file"
                                            placeholder="@lang('Documents')">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mt-4 mb-3">

                                        <button type="submit" class=" btn btn-lg btn-block"
                                            style="background-color:#07294d ; color:#ffc600"> Book
                                            this
                                            Course</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>