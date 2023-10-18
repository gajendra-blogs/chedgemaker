@extends('layouts.home')
@section('content')



<link media="all" type="text/css" rel="stylesheet" href="{{ url('assets/frontend/css/register/register.css') }}">

<div class="mt-5">
    <div class="row justify-content-center">
        <div class="col-md-10 d-flex ">
            <div class="container mb-3">
                <div class="contact-from mt-30">
                    @if($errors->first('paymentType'))
                    <h4 class="text-danger text-center mb-3">
                        <?php echo $errors->first('paymentType'); ?>
                    </h4>
                    @endif
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
                                        <input type="text" value="{{old('first_name')}}" name="first_name"
                                            id="first_name" class="form-control input-solid"
                                            placeholder="@lang('FirstName')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" value="{{old('last_name')}}" name="last_name" id="last_name"
                                            class="form-control input-solid" placeholder="@lang('LastName')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="email" name="email" id="email" value="{{old('email')}}"
                                            class="form-control input-solid" placeholder="@lang('Email')">
                                        @if($errors->first('email'))
                                        <span class="text-danger">
                                            <?php echo $errors->first('email'); ?></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="phone" name="phone" value="{{old('phone')}}" id="phone"
                                            class="form-control input-solid" placeholder="@lang('Phone')">
                                        @if($errors->first('phone'))
                                        <span class="text-danger">
                                            <?php echo $errors->first('phone'); ?></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-group mb-3">
                                        <select id="country" name="country" class="form-control ">
                                            <option value="">Choose Country</option>
                                            @foreach ($countries as $country)
                                            <option value="{{$country->id}}"
                                                {{$country->name == "India"  ? 'selected' : ''}}>
                                                {{ $country->name }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @if($errors->first('country'))
                                        <span class="text-danger">
                                            <?php echo $errors->first('country'); ?></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select name="state" id="states" class="form-control">
                                            <option value="">Select State</option>
                                        </select>
                                        @if($errors->first('state'))
                                        <span class="text-danger">
                                            <?php echo $errors->first('state'); ?></span>
                                        @endif
                                    </div>
                                    <span class="text-danger"> <?php echo $errors->first('state'); ?></span>

                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <select name="city" id="cities" class="form-control input-solid">
                                            <option value="">Select City</option>
                                        </select>
                                        @if($errors->first('city'))
                                        <span class="text-danger">
                                            <?php echo $errors->first('city'); ?></span>
                                        @endif
                                    </div>
                                    <span class="text-danger"> <?php echo $errors->first('city'); ?></span>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <textarea name="address" id="address" class="form-control input-solid"
                                            placeholder="@lang('Address')" rows="1">{{ old('address') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="pin_code" value="{{old('pin_code')}}" value=""
                                            id="pin_code" class="form-control input-solid"
                                            placeholder="@lang('Pin Code')">
                                    </div>
                                </div>
                            </div>
                            <div class="section-title mt-4 mb-3">
                                <h5>Create Password</h5>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <input type="password" name="password" value="{{old('password')}}" id="password"
                                            class="form-control input-solid" placeholder="@lang('password')">
                                        @if($errors->first('password'))
                                        <span class="text-danger">
                                            <?php echo $errors->first('password'); ?></span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <input type="password" name="confirmPassword" value="{{old('confirmPassword')}}"
                                            id="confirmPassword" class="form-control input-solid"
                                            placeholder="@lang('confirm password')">
                                        @if($errors->first('confirmPassword'))
                                        <span class="text-danger">
                                            <?php echo $errors->first('confirmPassword'); ?></span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="section-title mt-4 mb-3">
                                <h5>Course Information</h5>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select name="centers" id="centers" class="form-control input-solid">
                                            <option value="">Select Center</option>
                                            @foreach($centers as $center)
                                            <option value="{{$center->id}}">{{$center->center_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <select name="courses" id="courses" class="form-control input-solid">
                                            <option value="">Select Course</option>
                                        </select>
                                    </div>
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
                                <h5>Academic Information <span class="showAcademicForm">
                                        <svg height="2em" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <!--! Font Awesome Pro 6.2.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                            <path
                                                d="M256 512c141.4 0 256-114.6 256-256S397.4 0 256 0S0 114.6 0 256S114.6 512 256 512zM232 344V280H168c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V168c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H280v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z" />
                                        </svg>
                                    </span></h5>
                            </div>

                            <div id="academicInformation">
                                <!-- <h5 style="color:#07294d">10th Marksheet</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="10_th_marksheet[]" value="{{old('10_th_marksheet.0')}}"
                                            id="institute" class="form-control input-solid"
                                            placeholder="@lang('Institute')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="10_th_marksheet[]" value="{{old('10_th_marksheet.1')}}"
                                            id="university" class="form-control input-solid"
                                            placeholder="@lang('Board')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="10_th_marksheet[]" id="passout_year"
                                            value="{{old('10_th_marksheet.2')}}" class="form-control input-solid"
                                            placeholder="@lang('Passout Year')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="10_th_marksheet[]" id="marks"
                                            value="{{old('10_th_marksheet.3')}}" class="form-control input-solid"
                                            placeholder="@lang('Total Marks')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="text" name="10_th_marksheet[]" id="place"
                                            value="{{old('10_th_marksheet.4')}}" class="form-control input-solid"
                                            placeholder="@lang('Place')">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-3">
                                        <input type="file" name="10_th_marksheet_file"
                                            value="{{old('10_th_marksheet.5')}}" id="document"
                                            class="form-control input-solid form-control-file"
                                            placeholder="@lang('Documents')">
                                    </div>
                                </div>
                            </div> -->

                                @include('frontend/register.partials.academic10')
                                <h5 style="color:#07294d">12th Marksheet</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <input type="text" name="12_th_marksheet[]"
                                                value="{{old('12_th_marksheet.0')}}" id="institute"
                                                class="form-control input-solid" placeholder="@lang('Institute')">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <input type="text" name="12_th_marksheet[]"
                                                value="{{old('12_th_marksheet.1')}}" id="university"
                                                class="form-control input-solid" placeholder="@lang('Board')">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <input type="text" name="12_th_marksheet[]"
                                                value="{{old('12_th_marksheet.2')}}" id="passout_year"
                                                class="form-control input-solid" placeholder="@lang('Passout Year')">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <input type="text" name="12_th_marksheet[]" id="marks"
                                                value="{{old('12_th_marksheet.3')}}" class="form-control input-solid"
                                                placeholder="@lang('Total Marks / CGPA')">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <input type="text" name="12_th_marksheet[]" id="place"
                                                value="{{old('12_th_marksheet.4')}}" class="form-control input-solid"
                                                placeholder="@lang('Place')">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="12_th_marksheet_File">
                                                <svg height="2em" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 512 512">
                                                    <path
                                                        d="M512 416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96C0 60.7 28.7 32 64 32H181.5c17 0 33.3 6.7 45.3 18.7l26.5 26.5c12 12 28.3 18.7 45.3 18.7H448c35.3 0 64 28.7 64 64V416zM232 376c0 13.3 10.7 24 24 24s24-10.7 24-24V312h64c13.3 0 24-10.7 24-24s-10.7-24-24-24H280V200c0-13.3-10.7-24-24-24s-24 10.7-24 24v64H168c-13.3 0-24 10.7-24 24s10.7 24 24 24h64v64z" />
                                                </svg>&nbsp;&nbsp;upload file
                                                <input type="file" name="12_th_marksheet_File[]" style="display: none"
                                                    id="12_th_marksheet_File" value="{{old('12_th_marksheet.5')}}"
                                                    class="form-control input-solid form-control-file"
                                                    placeholder="@lang('Documents')">&nbsp;&nbsp;
                                                <span id="12_th_marksheet_File_preview"></span>
                                            </label>
                                            <i id="12_icon_cancle" class="fa fa-times text-danger"
                                                aria-hidden="true"></i>
                                        </div>
                                    </div>

                                </div>
                                <h5 style="color:#07294d">Graduation</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <input type="text" name="graduation[]" id="institute"
                                                value="{{old('graduation.0')}}" class="form-control input-solid"
                                                placeholder="@lang('Institute')">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <input type="text" name="graduation[]" id="university"
                                                value="{{old('graduation.1')}}" class="form-control input-solid"
                                                placeholder="@lang('university')">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <input type="text" name="graduation[]" id="passout_year"
                                                value="{{old('graduation.2')}}" class="form-control input-solid"
                                                placeholder="@lang('Passout Year')">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <input type="text" name="graduation[]" id="marks"
                                                value="{{old('graduation.3')}}" class="form-control input-solid"
                                                placeholder="@lang('Total Marks / CGPA')">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <input type="text" name="graduation[]" id="place"
                                                value="{{old('graduation.4')}}" class="form-control input-solid"
                                                placeholder="@lang('Place')">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="graduation_file">
                                                <svg height="2em" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 512 512">
                                                    <path
                                                        d="M512 416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96C0 60.7 28.7 32 64 32H181.5c17 0 33.3 6.7 45.3 18.7l26.5 26.5c12 12 28.3 18.7 45.3 18.7H448c35.3 0 64 28.7 64 64V416zM232 376c0 13.3 10.7 24 24 24s24-10.7 24-24V312h64c13.3 0 24-10.7 24-24s-10.7-24-24-24H280V200c0-13.3-10.7-24-24-24s-24 10.7-24 24v64H168c-13.3 0-24 10.7-24 24s10.7 24 24 24h64v64z" />
                                                </svg>&nbsp;&nbsp;upload file
                                                <input type="file" style="display: none" name="graduation_file[]"
                                                    id="graduation_file"
                                                    class="form-control input-solid form-control-file"
                                                    placeholder="@lang('Documents')">
                                            </label>&nbsp;&nbsp;

                                            <span id="graduation_marksheet_File_preview"></span>
                                            <i id="graduation_icon_cancle" class="fa fa-times text-danger"
                                                aria-hidden="true"></i>
                                        </div>
                                    </div>
                                </div>
                                <h5 style="color:#07294d">Post Graduation</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <input type="text" name="post_graduation[]" id="institute"
                                                value="{{old('post_graduation.0')}}" class="form-control input-solid"
                                                placeholder="@lang('Institute')">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <input type="text" name="post_graduation[]" id="university"
                                                value="{{old('post_graduation.1')}}" class="form-control input-solid"
                                                placeholder="@lang('university')">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <input type="text" name="post_graduation[]" id="passout_year"
                                                value="{{old('post_graduation.2')}}" class="form-control input-solid"
                                                placeholder="@lang('Passout Year')">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <input type="text" name="post_graduation[]" id="marks"
                                                value="{{old('post_graduation.3')}}" class="form-control input-solid"
                                                placeholder="@lang('Total Marks / CGPA')">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <input type="text" name="post_graduation[]" id="place"
                                                value="{{old('post_graduation.4')}}" class="form-control input-solid"
                                                placeholder="@lang('Place')">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label for="post_graduation_file">
                                                <svg height="2em" xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 512 512">
                                                    <path
                                                        d="M512 416c0 35.3-28.7 64-64 64H64c-35.3 0-64-28.7-64-64V96C0 60.7 28.7 32 64 32H181.5c17 0 33.3 6.7 45.3 18.7l26.5 26.5c12 12 28.3 18.7 45.3 18.7H448c35.3 0 64 28.7 64 64V416zM232 376c0 13.3 10.7 24 24 24s24-10.7 24-24V312h64c13.3 0 24-10.7 24-24s-10.7-24-24-24H280V200c0-13.3-10.7-24-24-24s-24 10.7-24 24v64H168c-13.3 0-24 10.7-24 24s10.7 24 24 24h64v64z" />
                                                </svg>&nbsp;&nbsp;upload file
                                                <input type="file" style="display: none" name="post_graduation_file[]"
                                                    id="post_graduation_file" value="{{old('post_graduation_file.0')}}"
                                                    class="form-control input-solid form-control-file"
                                                    placeholder="@lang('Documents')">
                                            </label>&nbsp;&nbsp;
                                            <span id="postGraduation_marksheet_File_preview"></span>
                                            <i id="postGraduation_icon_cancle" class="fa fa-times text-danger"
                                                aria-hidden="true"></i>
                                        </div>
                                    </div>
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
                        </form>
                    </div>
                </div>
            </div>
        </div>




        @stop
        @section('scripts')
        {!! HTML::script('assets/frontend/js/countryState/countryState.js') !!}
        {!! HTML::script('assets/frontend/js/studentRegistration.js') !!}
        @stop
