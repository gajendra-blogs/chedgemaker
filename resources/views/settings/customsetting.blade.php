@extends('layouts.app')

@section('page-title', __('General Settings'))
@section('page-heading', __('General Settings'))

@section('breadcrumbs')
    <li class="breadcrumb-item text-muted">
        @lang('Settings')
    </li>
    <li class="breadcrumb-item active">
        @lang('General')
    </li>
@stop

@section('content')

@include('partials.messages')

{!! Form::open(['route' => 'settings.general.update', 'id' => 'general-settings-form']) !!}

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
            
                @foreach($allSettings as $setting)
                <div class="form-group">
                    <label for="name">@lang($setting["key"])</label>
                    <input type="text" class="form-control input-solid" id="app_name"
                           name="{{ $setting['key'] }}" value="{{ $setting['value']}}" >
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<button type="submit" class="btn btn-primary">
    @lang('Update')
</button>

{{ Form::close() }}
@stop
