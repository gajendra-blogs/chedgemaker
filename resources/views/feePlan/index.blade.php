@extends('layouts.app')

@section('page-title', __('Fee Management'))
@section('page-heading', __('Fee Management'))

@section('breadcrumbs')
<li class="breadcrumb-item active">
    @lang('Fee Plan details')
</li>
@stop

@section('content')

@include('partials.messages')
<input type="hidden" id="getCoursesURL" name="" value="{{ route('feePlan.getcourses' , 1) }}">

<div class="card">
    <div class="card-body">
        <input type="hidden" id="viewFeePlanDetailUrl" value="{{ route('feemanagement.view') }}">
        <form action="" method="GET" id="feePlan-form" class="pb-2 mb-3 border-bottom-light">

            <div class="row my-3 flex-md-row flex-column-reverse">
                <div class="col-md-4 mt-md-0 mt-2">
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control input-solid" name="search"
                            value="{{ Request::get('search') }}" placeholder="@lang('Search for feePlans...')">

                        <span class="input-group-append">
                            @if (Request::has('search') && Request::get('search') != '')
                            <a href="{{ route('feemanagement.index') }}"
                                class="btn btn-light d-flex align-items-center text-muted" role="button">
                                <i class="fas fa-times"></i>
                            </a>
                            @endif
                            <button class="btn btn-light" type="submit" id="search-users-btn">
                                <i class="fas fa-search text-muted"></i>
                            </button>
                        </span>
                    </div>
                </div>


                <div class="col-md-8">
                    <a href="" type="button" data-toggle="modal" data-target="#exampleModalLong"
                        class="btn btn-primary btn-rounded float-right">
                        <i class="fas fa-plus mr-2"></i>
                        @lang('Add')
                    </a>
                </div>
            </div>
        </form>

        <div class="table-responsive" id="users-table-wrapper">
            <table class="table table-striped table-borderless">
                <thead>
                    <tr>
                        <th class="min-width-150 column-sort" data-sort="desc" data-column="{{Crypt::encrypt('id')}}">
                            @lang('S No.') <span class="sort-icon"><i
                                    class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class="min-width-150 column-sort" data-sort="desc" data-column="{{Crypt::encrypt('name')}}">
                            @lang('Fee Plan Name') <span class="sort-icon"><i
                                    class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class="min-width-150 column-sort" data-sort="desc"
                            data-column="{{Crypt::encrypt('fee_type')}}">@lang('Fee Type') <span class="sort-icon"><i
                                    class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class="min-width-150 column-sort" data-sort="desc"
                            data-column="{{Crypt::encrypt('total_fee')}}">@lang('Total Fee Amount') <span
                                class="sort-icon"><i class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class="min-width-150 column-sort" data-sort="desc"
                            data-column="{{Crypt::encrypt('status')}}">@lang('Status') <span class="sort-icon"></span>
                        </th>
                        <th class="min-width-150 column-sort" data-sort="desc"
                            data-column="{{Crypt::encrypt('course_description')}}">
                            @lang('Action') <span class="sort-icon"></span></th>
                    </tr>
                </thead>
                <tbody>

                    @include('feePlan.partials.table')

                </tbody>
            </table>
        </div>
    </div>
</div>

<!--Add or Update Modal -->
<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
    aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Fee Plan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @include('feePlan.create')
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="FeePlandtailviewModal" tabindex="-1" role="dialog" aria-labelledby="FeePlandtailviewModal"
    aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Fee Plan Detail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FeePlandtailviewModalBody">

            </div>

        </div>
    </div>
</div>







<!-- ************************* Modal for edit fee heads -->
<div class="modal fade" id="FeePlandetailEditModal" tabindex="-1" role="dialog" aria-labelledby="FeePlandetailEditModal"
    aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Edit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="FeePlandetailEditModalBody">

            </div>

        </div>
    </div>
</div>

@stop
@section('scripts')
{!! HTML::script('assets/js/feePlan/feePlan.js') !!}
@stop
