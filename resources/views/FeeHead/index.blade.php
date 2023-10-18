@extends('layouts.app')

@section('page-title', __('Fee Head'))
@section('page-heading', __('Fee Head'))

@section('breadcrumbs')
<li class="breadcrumb-item active">
    @lang('Fee Head')
</li>
@stop

@section('content')

@include('partials.messages')
<div id="notification-logging">

</div>
<div class="card">
    <div class="card-body">
        <form action="" method="GET" id="feeHead-form" class="pb-2 mb-3 border-bottom-light">
            <div class="row my-3 flex-md-row flex-column-reverse">
                <div class="col-md-4 mt-md-0 mt-2">
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control input-solid" name="search" value="{{ Request::get('search') }}" placeholder="@lang('Search for feeHeads...')">

                        <span class="input-group-append">
                            @if (Request::has('search') && Request::get('search') != '')
                            <a href="{{ route('feehead.index') }}" class="btn btn-light d-flex align-items-center text-muted" role="button">
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
                    <a href="" type="button" id="add-btn-head" data-toggle="modal" data-target="#AddUpdateModel" class="btn btn-primary btn-rounded float-right">
                        <i class="fas fa-plus mr-2"></i>
                        @lang('Add')
                    </a>
                </div>
            </div>
        </form>

        <div class="table-responsive" id="users-table-wrapper">
            <table id="fee-head-table" class="table table-striped table-borderless">
                <thead>
                    <tr>
                        <th class="min-width-100 column-sort" data-sort="desc" data-column="{{Crypt::encrypt('fee_heads_title')}}">@lang('Title') <span class="sort-icon"><i class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class="min-width-150 column-sort" data-sort="desc" data-column="{{Crypt::encrypt('fee_heads_sequence')}}">@lang('Sequence') <span class="sort-icon"><i class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class="min-width-150 column-sort" data-sort="desc" data-column="{{Crypt::encrypt('status')}}">@lang('Status') <span class="sort-icon"><i class="fa-solid fa-arrow-up-wide-short"></i></span></th>
                        <th class="text-center">@lang('Action')</th>
                    </tr>
                </thead> 
                <tbody>
                    @include('FeeHead.table')
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--Add or Update Modal -->
@include('partials.AddUpdateModel' , ['edit' => $edit , 'form' => 'FeeHead.create' , 'title' => 'Fee Head'])

    @stop