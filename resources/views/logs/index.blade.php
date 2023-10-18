@extends('layouts.app')

@section('page-title', __('Log Management'))
@section('page-heading', __('Logs Management'))

@section('breadcrumbs')
<li class="breadcrumb-item active">
    @lang('Logs')
</li>
@stop

@section('content')

@include('partials.messages')


<?php echo $file ?>


@stop