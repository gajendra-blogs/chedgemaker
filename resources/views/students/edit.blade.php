@extends('layouts.app')

@section('page-title', __('Edit Student'))
@section('page-heading', $student->present()->nameOrEmail)

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('students.index') }}">@lang('Students')</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('students.show', $student) }}">
            {{ $student->present()->nameOrEmail }}
        </a>
    </li>
    <li class="breadcrumb-item active">
        @lang('Edit')
    </li>
@stop

@section('content')

@include('partials.messages')

<div class="row">
    <div class="col-8">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" id="nav-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active"
                           id="details-tab"
                           data-toggle="tab"
                           href="#details"
                           role="tab"
                           aria-controls="home"
                           aria-selected="true">
                            @lang('Student Details')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           id="authentication-tab"
                           data-toggle="tab"
                           href="#login-details"
                           role="tab"
                           aria-controls="home"
                           aria-selected="true">
                            @lang('Login Details')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           id="authentication-tab"
                           data-toggle="tab"
                           href="#academic-details"
                           role="tab"
                           aria-controls="home"
                           aria-selected="true">
                            @lang('Academic Details')
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link"
                           id="authentication-tab"
                           data-toggle="tab"
                           href="#course-details"
                           role="tab"
                           aria-controls="home"
                           aria-selected="true">
                            @lang('Address Details')
                        </a>
                    </li>
                </ul>

                <div class="tab-content mt-4" id="nav-tabContent">
                    <div class="tab-pane fade show active px-2"
                         id="details"
                         role="tabpanel"
                         aria-labelledby="nav-home-tab">
                        <form action="{{ route('students.update', $student) }}" method="POST" id="details-form">
                            @csrf
                            @method('PUT')
                            @include('students.partials.details', ['profile' => false])
                        </form>
                    </div>

                    <div class="tab-pane fade px-2"
                         id="login-details"
                         role="tabpanel"
                         aria-labelledby="nav-profile-tab">
                         <form action="{{ route('students.update.login-details', $student) }}"
                              method="POST"
                              id="login-details-form">
                            @csrf
                            @method('PUT')
                            @include('students.partials.auth')
                        </form>
                    </div>
                    <div class="tab-pane fade px-2"
                         id="academic-details"
                         role="tabpanel"
                         aria-labelledby="nav-profile-tab">
                         <form action="{{ route('students.update.academic', $student, $academics) }}"
                              method="POST"
                              id="academic-details-form">
                            @csrf
                            @method('PUT')
                    
                            @include('students.partials.academic')
                    
                            <div class="col-md-12 mt-2">
                          <button type="submit" class="btn btn-primary" id="update-details-btn">
                         <i class="fa fa-refresh"></i>@lang('Update Academic Details')</button>
                           </div>
                        </form>
                    </div>
                    <div class="tab-pane fade px-2"
                         id="course-details"
                         role="tabpanel"
                         aria-labelledby="nav-profile-tab">
                         <form action="{{ route('students.update.address', $student) }}"
                              method="POST"
                              id="login-details-form">
                            @csrf
                            @method('PUT')
                            @include('students.partials.addresses')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="card">
            <div class="card-body">
            <form action="{{ route('students.update.avatar', $student->id) }}"
                      method="POST"
                      id="avatar-form"
                      enctype="multipart/form-data">
                    @csrf
                    @include('students.partials.avatar', ['updateUrl' => route('user.update.avatar.external', $student->id)])
                </form>
            </div>
        </div>
    </div>
</div>

@stop

@section('scripts')
    {!! HTML::script('assets/js/as/btn.js') !!}
    {!! HTML::script('assets/js/as/profile.js') !!}
    {!! JsValidator::formRequest('Vanguard\Http\Requests\Student\UpdateDetailsRequest', '#details-form') !!}
    {!! JsValidator::formRequest('Vanguard\Http\Requests\Student\UpdateLoginDetailsRequest', '#login-details-form') !!}
@stop
