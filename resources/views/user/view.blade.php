@extends('layouts.app')

@section('page-title', $user->present()->nameOrEmail)
@section('page-heading', $user->present()->nameOrEmail)

@section('breadcrumbs')
<li class="breadcrumb-item">
    <a href="{{ route('users.index') }}">@lang('Users')</a>
</li>
<li class="breadcrumb-item active">
    {{ $user->present()->nameOrEmail }}
</li>
@stop

@section('content')

<div class="row">
    <div class="col-lg-7 col-xl-8 @if (! isset($activities)) mx-auto @endif">
        <div class="card">
            <h6 class="card-header d-flex align-items-center justify-content-between">
                @lang('Details')

                <small>
                    @canBeImpersonated($user)
                    <a href="{{ route('impersonate', $user) }}" data-toggle="tooltip" data-placement="top" title="@lang('Impersonate User')">
                        @lang('Impersonate')
                    </a>
                    <span class="text-muted">|</span>
                    @endCanBeImpersonated

                    <a href="{{ route('users.edit', $user) }}" data-toggle="tooltip" data-placement="top" title="@lang('Edit User')">
                        @lang('Edit')
                    </a>
                </small>
            </h6>
            <div class="card-body">
                <div class="d-flex align-items-center flex-column pt-3">
                    <div>
                        <img class="rounded-circle img-thumbnail img-responsive mb-4" width="130" height="130" src="{{ $user->present()->avatar }}">
                    </div>

                    @if ($name = $user->present()->name)
                    <h5>{{ $user->present()->name }}</h5>
                    @endif

                    <a href="mailto:{{ $user->email }}" class="text-muted font-weight-light mb-2">
                        {{ $user->email }}
                    </a>
                </div>
                <div class="container">
                    <h3>Basic Information</h3>
                    <div class="row">
                        <div class="col">
                            <ul class="list-group list-group-flush mt-3">
                                <li class="list-group-item">
                                    <strong>@lang('Name'):</strong>
                                    {{ $user->first_name }} {{ $user->last_name}}
                                </li>
                                @if ($user->father_name)
                                <li class="list-group-item">
                                    <strong>@lang('Father Name'):</strong>
                                    {{ $user->father_name }}
                                </li>
                                @endif
                                @if ($user->guardian_contact)
                                <li class="list-group-item">
                                    <strong>@lang('Father Contact'):</strong>
                                    {{ $user->guardian_contact }}
                                </li>
                                @endif
                                @if ($user->id_proof_type)
                                <li class="list-group-item">
                                    <strong>@lang('Id Type'):</strong>
                                    {{ $user->id_proof_type}}
                                </li>
                                @endif
                                @if ($user->center_id)
                                <li class="list-group-item">
                                    <strong>@lang('Center Name'):</strong>
                                    {{ $user->center_id}}
                                </li>
                                @endif
                                <li class="list-group-item">
                                    <strong>@lang('Last Logged In'):</strong>
                                    {{ $user->present()->lastLogin }}
                                </li>
                            </ul>
                        </div>

                        <div class="col">
                            <ul>
                                @if ($user->phone)
                                <li class="list-group-item">
                                    <strong>@lang('Phone'):</strong>
                                    <a href="telto:{{ $user->phone }}">{{ $user->phone }}</a>
                                </li>
                                @endif
                                <li class="list-group-item">
                                    <strong>@lang('Birthday'):</strong>
                                    {{ $user->present()->birthday }}
                                </li>
                                <li class="list-group-item">
                                    <strong>@lang('Address'):</strong>
                                    {{ $user->present()->fullAddress }}
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

@include('partials.studentEditModel' , ['edit' => true , 'form_action' => route('acedmic.update.student' , $user)  , 'title' => 'High School Acedemic'])


@section('scripts')
    {!! HTML::script('assets/js/admin/studentEdit.js') !!}
@stop
@stop