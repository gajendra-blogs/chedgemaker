@extends('layouts.app')

@section('page-title', __('Add Fee Plan Details'))
@section('page-heading', __('Create New Fee Plan Details'))

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('feePlanDetails.index') }}">@lang('Fee Plan Details')</a>
    </li>
    <li class="breadcrumb-item active">
        @lang('Create')
    </li>
@stop

@section('content')

@include('partials.messages')

{!! Form::open(['route' => 'feePlanDetails.store', 'files' => true, 'id' => 'feePlanDetials-form']) !!}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <h5 class="card-title">
                        @lang('Fee Plan Details')
                    </h5>
                    <p class="text-muted font-weight-light">
                        @lang('A general Fee Plan  information.')
                    </p>
                </div>
                <div class="col-md-9">
                    @include('feePlanDetails.partials.details', ['edit' => false, 'profile' => false])
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                @lang('Create Fee Plan Details')
            </button>
        </div>
    </div>
{!! Form::close() !!}


@stop

@section('scripts')
    <!-- {!! HTML::script('assets/js/course/course.js') !!} -->
    {!! JsValidator::formRequest('Vanguard\Http\Requests\FeePlanDetails\CreateFeePlanDetails', '#feePlanDetials-form') !!}
@stop