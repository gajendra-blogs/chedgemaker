@extends('layouts.app')

@section('page-title', __('Centers'))
@section('page-heading', __('Centers'))

@section('breadcrumbs')
<li class="breadcrumb-item active">
    @lang('Centers')
</li>
@stop

@section('content')

@include('partials.messages')
<div id="notification-logging">

</div>

<div class="card">
    <div class="card-body">
        <form action="" method="GET" id="" class="pb-2 mb-3 border-bottom-light">
            <div class="row my-3 flex-md-row flex-column-reverse">
                <div class="col-md-4 mt-md-0 mt-2">
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control input-solid" name="search"
                            value="{{ Request::get('search') }}" placeholder="@lang('Search for centers...')">

                        <span class="input-group-append">
                            @if (Request::has('search') && Request::get('search') != '')
                            <a href="{{ route('center.index') }}"
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

                <div class="col-md-2">
                    <!-- <button class="btn btn-warning btn-sm" onclick="downloadExcelFile('centers')" type="button">Download
                        Excel</button> -->
                    <!-- <a href="{{ route('downloadExcelFileUrl', 'centers') }}">Download</a> -->
                </div>
                <div class="col-md-6">
                    <a href="" type="button" id="add-btn-center" data-toggle="modal" data-target="#AddUpdateModel"
                        class="btn btn-primary btn-rounded float-right">
                        <i class="fas fa-plus mr-2"></i>
                        @lang('Add')
                    </a>
                </div>
            </div>
        </form>

        <div class="table-responsive" id="users-table-wrapper">
            <table id="center-table" class="table table-striped table-borderless">
                <thead>
                    <tr>
                        <th class="min-width-100 column-sort" data-sort="desc"
                            data-column="{{Crypt::encrypt('center_name')}}">@lang('Center Name') <span
                                class="sort-icon"><i class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class=" column-sort" data-sort="desc" data-column="{{Crypt::encrypt('center_location')}}">
                            @lang('Center Code') <span class="sort-icon"><i
                                    class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class="min-width-150 column-sort" data-sort="desc"
                            data-column="{{Crypt::encrypt('center_location')}}">@lang('Location') <span
                                class="sort-icon"><i class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class="min-width-150 column-sort" data-sort="desc"
                            data-column="{{Crypt::encrypt('center_location')}}">@lang('Owner Name') <span
                                class="sort-icon"><i class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class="min-width-150 column-sort" data-sort="desc"
                            data-column="{{Crypt::encrypt('center_email')}}">@lang('Owner Email') <span
                                class="sort-icon"><i class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class="min-width-150 column-sort" data-sort="desc"
                            data-column="{{Crypt::encrypt('contact_person')}}">@lang('Owner contact No.') <span
                                class="sort-icon"><i class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class=" column-sort" data-sort="desc" data-column="{{Crypt::encrypt('status')}}">
                            @lang('Status') <span class="sort-icon"><i
                                    class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class="text-center">@lang('Action')</th>
                    </tr>
                </thead>
                <tbody>
                    @include('center.table')
                </tbody>
            </table>
        </div>
    </div>
</div>
{!! $centers->render() !!}
<!--Add or Update Modal -->

@include('partials.AddUpdateModel' , ['edit' => $edit , 'form' => 'center.create' , 'title' => 'Centers'])

@stop

@section('scripts')
{!! HTML::script('assets/js/center/center.js') !!}
@stop
