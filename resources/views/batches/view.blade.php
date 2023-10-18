@extends('layouts.app')

@section('page-title', $batch->batch_name)
@section('page-heading', $batch->batch_name)

@section('breadcrumbs')
    <li class="breadcrumb-item">
        <a href="{{ route('batches.index') }}">@lang('Assign Course Center')</a>
    </li>
    <li class="breadcrumb-item active">
        {{ $batch->batch_name }}
    </li>
@stop

@section('content')

<div class="row">
    <div class="col-lg-5 col-xl-4 @if (! isset($activities)) mx-auto @endif">
        <div class="card">
            <h6 class="card-header d-flex align-items-center justify-content-between">
                @lang('Details')

                <small>
                    <a href="{{ route('batches.edit', $batch) }}"
                       class="edit"
                       data-toggle="tooltip"
                       data-placement="top"
                       title="@lang('Edit Batch')">
                        @lang('Edit')
                    </a>
                </small>
            </h6>
            <div class="card-body">
               <div class="d-flex align-items-center flex-column pt-3">

                    @if ($name = $batch->batch_name)
                        <h5>{{ $batch->batch_name }}</h5>
                    @endif
                </div>

                <ul class="list-group list-group-flush mt-3">
                    @if ($batch->batch_description)
                        <li class="list-group-item">
                            <strong>@lang('Batch Description'):</strong>
                            <p>{{ $batch->batch_description }}</p>
                        </li>
                    @endif
                    <li class="list-group-item">
                        <strong>@lang('Batch Start'):</strong>
                        {{ $batch->batch_start }}
                    </li>
                    <li class="list-group-item">
                        <strong>@lang('Batch End'):</strong>
                        {{ $batch->batch_end }}
                    </li>
                </ul>
            </div>
        </div>
    </div>

    @if (isset($activities))
        <div class="col-lg-7 col-xl-8">
            @include("user-activity::recent-activity", ['activities' => $activities])
        </div>
    @endif
</div>
@stop
