@extends('layouts.app')

@section('page-title', __('Student Registrations'))
@section('page-heading', __('Student Registrations'))

@section('breadcrumbs')
<li class="breadcrumb-item">
    @lang('Student')
</li>
<li class="breadcrumb-item active">
    @lang('Registration')
</li>
@stop

@section('content')

@include('partials.messages')
@include('userRegistrations.adminpanel.partials.registrationForm')

@stop

@section('scripts')
{!! HTML::script('assets/frontend/js/countryState/countryState.js') !!}
{!! HTML::script('assets/frontend/js/studentRegistration.js') !!}
@stop