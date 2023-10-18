@extends('layouts.app')



@section('page-title', __('Transactions'))
@section('page-heading', __('Transactions'))

@section('breadcrumbs')
<li class="breadcrumb-item active">
    @lang('Transactions')
</li>
@stop

@section('content')

@include('partials.messages')

<div class="card">
    <div class="card-body">
        <form action="{{ route('students.index') }}" method="GET" id="students-form"
            class="pb-2 mb-3 border-bottom-light">
            <div class="row my-3 flex-md-row flex-column-reverse">
                <div class="col-md-4 mt-md-0 mt-2">
                    <div class="input-group custom-search-form">
                        <input type="text" class="form-control input-solid" name="search"
                            value="{{ Request::get('search') }}" placeholder="@lang('Search for transactions...')">

                        <span class="input-group-append">
                            @if (Request::has('search') && Request::get('search') != '')
                            <a href="{{ route('users.index') }}"
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
            </div>
        </form>
        <div class="table-responsive" id="users-table-wrapper">
            <table class="table table-borderless table-striped">
                <thead>
                <tr>
                    <th class="text-center min-width-80">@lang('Email')</th>
                    <th class="text-center min-width-80">@lang('Transaction ID')</th>
                    <th class="text-center min-width-60">@lang('Method')</th>
                    <th class="text-center min-width-60">@lang('Amount')</th>
                    <th class="text-center min-width-80">@lang('Description')</th>
                    <th class="text-center min-width-80">@lang('Bank')</th>
                    <th class="text-center min-width-150">@lang('Payment Date')</th>
                    <th class="text-center min-width-60">@lang('Status')</th>
                    <th class="text-center min-width-80">@lang('Action')</th>
                </tr>
                </thead>
                <tbody>
                    @if (count($transactions))
                    @foreach ($transactions as $transaction)
                    @include('transactions.partials.row')
                    @endforeach
                    @else
                    <tr>
                        <td colspan="7"><em>@lang('No records found.')</em></td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
{!! $transactions->render() !!}
@stop
