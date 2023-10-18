@extends('layouts.home')
@section('page-title', __('My Account'))
@section('page-heading', __('My Accounts'))
@section('content')
<link rel="stylesheet" href="{{url('assets/frontend/css/student/profile.css')}}">
<input type="hidden" name="" value=" {{ route('states.getStates') }}" id="country-url">
<input type="hidden" id="cityUrl" data-href="{{ route('city.getCities') }}">
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" id="nav-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="home" aria-selected="true">
                            @lang('User Details')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="authentication-tab" data-toggle="tab" href="#address-details" role="tab" aria-controls="home" aria-selected="true">
                            @lang('Address Details')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="authentication-tab" data-toggle="tab" href="#acedmic-details" role="tab" aria-controls="home" aria-selected="true">
                            @lang('Academic Details')
                        </a>
                    </li>
                </ul>

                <div class="tab-content mt-4" id="nav-tabContent">
                    <div class="tab-pane fade show active px-2" id="details" role="tabpanel" aria-labelledby="nav-home-tab">

                        <div class="row">
                            <div class="col-sm-12">
                                <div id="student-detials">
                                    @include('frontend.user.partial.profilecart')
                                </div>
                                <a href="{{route('student.edit.details' , $current_user->id)}}" data-section="details" class="btn btn-icon edit edit-btn-profile" title="@lang('Edit Details')" data-toggle="tooltip" data-placement="top">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>


                        </div>
                    </div>

                    <div class="tab-pane fade px-2" id="address-details" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="col-sm-12">
                                <div id="student-address">
                                    @include('frontend.user.partial.address')
                                </div>
                                <a href="{{route('student.edit.address' , $addresses->id)}}" data-section="address" class="btn btn-icon edit edit-btn-profile" title="@lang('Edit Address')" data-toggle="tooltip" data-placement="top">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </div>
                    </div>

                    <div class="tab-pane fade px-2" id="acedmic-details" role="tabpanel" aria-labelledby="nav-profile-tab">
                        @include('frontend.user.partial.acedmic')
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                @include('frontend.user.partial.avtar' , ['edit' => true])
            </div>
        </div>
    </div>
</div>
@include('frontend.partials.editModel' , ["title" => 'Student Upadte'])
@include('frontend.partials.addAcademicModal' , ["title" => 'Student Academic'])

@stop


@section('scripts')
{!! HTML::script('assets/frontend/js/student/student.js') !!}
@stop