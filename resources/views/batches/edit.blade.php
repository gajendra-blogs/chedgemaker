@extends('layouts.app')

@section('page-title', __('Edit Batch'))
@section('page-heading', $batch->batch_name)

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('batches.index') }}">@lang('Batches')</a>
    </li>
    <li class="breadcrumb-item">
        <a href="{{ route('batches.show', $batch->id) }}">
            {{ $batch->batch_name }}
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
                            @lang('Batch Details')
                        </a>
                    </li>
                </ul>

                <div class="tab-content mt-4" id="nav-tabContent">
                    <div class="tab-pane fade show active px-2"
                         id="details"
                         role="tabpanel"
                         aria-labelledby="nav-home-tab">
                        <form action="{{ route('batches.update', $batch) }}" method="POST" id="batch-form">
                            @csrf
                            @method('PUT')
                            @include('batches.partials.details', ['profile' => false])
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

@stop

@section('scripts')
    {!! HTML::script('assets/js/batch/batch.js') !!}
@stop
