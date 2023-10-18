@extends('layouts.app')

@section('page-title', __('Assign Course Center'))
@section('page-heading', __('Assign Course Center'))

@section('breadcrumbs')
<li class="breadcrumb-item active">
    @lang('Assign Course Center')
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
                    <!-- <div class="input-group custom-search-form">
                        <input type="text" class="form-control input-solid" name="search" value="{{ Request::get('search') }}" placeholder="@lang('Search for assign course center...')">

                        <span class="input-group-append">
                            @if (Request::has('search') && Request::get('search') != '')
                            <a href="{{ route('batches.index') }}" class="btn btn-light d-flex align-items-center text-muted" role="button">
                                <i class="fas fa-times"></i>
                            </a>
                            @endif
                            <button class="btn btn-light" type="submit" id="search-users-btn">
                                <i class="fas fa-search text-muted"></i>
                            </button>
                        </span>
                    </div> -->
                </div>

                <div class="col-md-2 mt-2 mt-md-0">
                    {{-- {!!
                        Form::select(
                            'status',
                            $statuses,
                            Request::get('status'),
                            ['id' => 'status', 'class' => 'form-control input-solid']
                        )
                    !!} --}}
                </div>
                @if (auth()->user()->hasPermission('batch.add'))
                <div class="col-md-6">
                    <a data-href="{{ route('batches.create') }}" id="add-btn-batch" data-toggle="modal" data-target="#AddUpdateModel" class="btn btn-primary btn-rounded float-right">
                        <i class="fas fa-plus mr-2"></i>
                        @lang('Add')
                    </a>
                </div>
                @endif
            </div>
        </form>

        <div class="row">
            @foreach($all_centers as $center)
            <div class="col-md-6">
                <div class="card" style="width: 18;">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h4 class="card-title ">{{$center->center_name}}</h4>
                            <!-- <a class="text-primary" href="{{route('batches.edit' , Crypt::encrypt($center->id))}}">@lang('Edit')</a> -->
                        </div>
                        <h6 class="card-subtitle mb-2 text-muted">@lang('Courses Available on Center')</h6>
                        <ul class="list-group list-group-flush" id="center-div{{$center->id}}">
                            <div class="courses-div">
                                @foreach($assigned_courses as $assigned_course)
                                    @if($assigned_course->center_id == $center->id)
                                        <li class="list-group-item">{{ $assigned_course->course_name }}</li>
                                    @endif
                                @endforeach
                            </div>
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- {!! $batches->render() !!}  --}}

        <!--Add or Update Modal -->
        @include('partials.AddUpdateModel' , ['edit' => $edit , 'form' => 'batches.partials.details' , 'title' => 'Batches'])

        @stop

        @section('scripts')
        {!! HTML::script('assets/js/batch/batch.js') !!}
        @stop