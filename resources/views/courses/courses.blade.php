@extends('layouts.app')

@section('page-title', __('Courses'))
@section('page-heading', __('Courses'))

@section('breadcrumbs')
<li class="breadcrumb-item active">
    @lang('Courses')
</li>
@stop

@section('content')

@include('partials.messages')
<div id="notification-logging">

</div>
<div class="card">
    <div class="card-body">

        <form action="" method="GET" id="users-form" class="pb-2 mb-3 border-bottom-light">
            <div class="row my-3 flex-md-row flex-column-reverse">
                <div class="col-md-4 mt-md-0 mt-2">
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control input-solid" name="search" value="{{ Request::get('search') }}" placeholder="@lang('Search for Courses...')">

                        <span class="input-group-append">
                            @if (Request::has('search') && Request::get('search') != '')
                            <a href="{{auth()->user()->hasRole('User') ? route('courses.index') : route('course.index')}}" class="btn btn-light d-flex align-items-center text-muted" role="button">
                                <i class="fas fa-times"></i>
                            </a>
                            @endif
                            <button class="btn btn-light" type="submit" id="search-users-btn">
                                <i class="fas fa-search text-muted"></i>
                            </button>
                        </span>
                    </div>
                </div>
                @if (auth()->user()->hasRole('Admin'))
                <div class="col-md-8">
                    <a href="" id="add-couse" data-toggle="modal" data-target="#AddUpdateModel" class="btn btn-primary btn-rounded float-right">
                        <i class="fas fa-plus mr-2"></i>
                        @lang('Add')
                    </a>
                </div>
                @endif
            </div>
        </form>
        <div class="table-responsive table-response" id="users-table-wrapper">
            <table id="course-table" class="table table-borderless table-striped">
                <thead>
                    <tr>
                        <th class="min-width-150 column-sort" data-sort="desc" data-column="{{Crypt::encrypt('course_name')}}">@lang('Name') <span class="sort-icon"><i class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class="min-width-150 column-sort" data-sort="desc" data-column="{{Crypt::encrypt('course_description')}}">@lang('Description') <span class="sort-icon"><i class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class="min-width-100 column-sort" data-sort="desc" data-column="{{Crypt::encrypt('course_duration')}}">@lang('Duration') <span class="sort-icon"><i class="fa-solid fa-arrow-up-wide-short"></i></span> </th>
                        <th class="min-width-80 column-sort" data-sort="desc" data-column="{{Crypt::encrypt('status')}}">@lang('Status') <span class="sort-icon"><i class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        @if (auth()->user()->hasRole('Admin'))
                        <th class="text-center min-width-150">@lang('Action') </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @include('courses.partials.table')
                </tbody>
            </table>

        </div>
    </div>
</div>

{!! $courses->render() !!}

<!--Add or Update Modal -->
@include('partials.AddUpdateModel' , ['edit' => $edit , 'form' => 'courses.partials.details' , 'title' => 'Courses'])

@stop

