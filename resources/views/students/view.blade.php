@extends('layouts.app')

@section('page-title', $student->present()->nameOrEmail)
@section('page-heading', $student->present()->nameOrEmail)

@section('breadcrumbs')
<li class="breadcrumb-item">
    <a href="{{ route('students.index') }}">@lang('Students')</a>
</li>
<li class="breadcrumb-item active">
    {{ $student->present()->nameOrEmail }}
</li>
@stop

@section('content')

<div class="row">
    <div class="col-lg-7 col-xl-8 @if (! isset($activities)) mx-auto @endif">
        <div class="card">
            <h6 class="card-header d-flex align-items-center justify-content-between">
                @lang('Details')

                <small>
                    <a href="{{ route('students.edit', $student->id) }}" data-toggle="tooltip" data-placement="top" title="@lang('Edit Student')">
                        @lang('Edit')
                    </a>
                </small>
            </h6>
            <div class="card-body">
                <div class="d-flex align-items-center flex-column pt-3">
                    <div>
                        <img class="rounded-circle img-thumbnail img-responsive mb-4" width="130" height="130" src="{{ $student->present()->avatar }}">
                    </div>

                    @if ($name = $student->present()->name)
                    <h5>{{ $student->present()->name }}</h5>
                    @endif

                    <a href="mailto:{{ $student->email }}" class="text-muted font-weight-light mb-2">
                        {{ $student->email }}
                    </a>
                </div>
                <div class="container">
                    <h3>Basic Information</h3>
                    <div class="row">
                        <div class="col">
                            <ul class="list-group list-group-flush mt-3">
                                <li class="list-group-item">
                                    <strong>@lang('Name'):</strong>
                                    {{ $student->first_name }} {{ $student->last_name}}
                                </li>
                                @if ($student->father_name)
                                <li class="list-group-item">
                                    <strong>@lang('Father Name'):</strong>
                                    {{ $student->father_name }}
                                </li>
                                @endif
                                @if ($student->guardian_contact)
                                <li class="list-group-item">
                                    <strong>@lang('Father Contact'):</strong>
                                    {{ $student->guardian_contact }}
                                </li>
                                @endif
                                @if ($student->id_proof_type)
                                <li class="list-group-item">
                                    <strong>@lang('Id Type'):</strong>
                                    {{ $student->id_proof_type}}
                                </li>
                                @endif
                                @if ($student->center_id)
                                <li class="list-group-item">
                                    <strong>@lang('Center Name'):</strong>
                                    {{ $student->center_id}}
                                </li>
                                @endif
                                <li class="list-group-item">
                                    <strong>@lang('Last Logged In'):</strong>
                                    {{ $student->present()->lastLogin }}
                                </li>
                            </ul>
                        </div>

                        <div class="col">
                            <ul>
                                @if ($student->phone)
                                <li class="list-group-item">
                                    <strong>@lang('Phone'):</strong>
                                    <a href="telto:{{ $student->phone }}">{{ $student->phone }}</a>
                                </li>
                                @endif
                                <li class="list-group-item">
                                    <strong>@lang('Birthday'):</strong>
                                    {{ $student->present()->birthday }}
                                </li>
                                <li class="list-group-item">
                                    <strong>@lang('Address'):</strong>
                                    {{ $student->present()->fullAddress }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (isset($activities))
    <div class="col-lg-5 col-xl-4">
        @include("user-activity::recent-activity", ['activities' => $activities])
    </div>
    @endif
</div>
@if (count($academics))
<div class="row">
    <div class="col-lg-12 col-xl-12">
        <div class="card">
            <h6 class="card-header d-flex align-items-center justify-content-between"></h6>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="mt-3">
                            <h3>Academic Information</h3>
                        </div>
                        <div class="table-responsive">
                            <table id="academic-table" class="table table-borderless table-striped">
                                <thead>
                                    <tr>
                                        <th class="min-width-80">@lang('Documents')</th>
                                        <th class="min-width-80">@lang('Qualification')</th>
                                        <th class="min-width-80">@lang('Institute')</th>
                                        <th class="min-width-80">@lang('University')</th>
                                        <th class="min-width-80">@lang('Passout Year')</th>
                                        <th class="min-width-80">@lang('Place')</th>
                                        <th class="min-width-80">@lang('Marks')</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($academics as $acedmic)
                                        @include('students.acedmics.row')
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if (count($addresses))

<div class="card">
    <h4 class="card-header d-flex align-items-center justify-content-between">Address</h4>
    <div class="card-body">
        <div class="container">
            <div class="">
                <h5>Home</h5>
            </div>
            @foreach($addresses as $address)
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <h4 class="card-title">{{ $address->address1 }}</h4>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $address->address2}}</h6>
                    <p class="card-text">{{$address->city}} , {{$address->state_name}} , {{ $address->country_name}} , {{$address->pin_code}} </p>
                    <a href="#" class="card-link">@lang('Add')</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endif

@section('scripts')
    {!! HTML::script('assets/js/admin/studentEdit.js') !!}
@stop
@stop