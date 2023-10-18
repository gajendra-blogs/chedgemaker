@extends('layouts.home')
@section('page-title', __('Payment History'))
@section('page-heading', __('Payment History'))

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12 mt-2">
        <h4 class="text-center mb-4">@lang('Payment History')</h4>
        <table class="table table-sm" style="line-height: 13px;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Transaction ID</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Date & Time</th>
                            <th>Bank</th>
                            <th>Received BY</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paymentHistory as $history)
                        <tr>
                            <th>{{$loop->iteration-0}}</th>
                            <th>{{$history->transaction_id}}</th>
                            <td>{{$history->amount}}</td>
                            <td>{{$history->payment_method}}</td>
                            <td>{{Carbon\Carbon::parse($history->created_at)->format('d-M-Y  g:i:s A' )}}</td>
                            <td>{{$history->bank}}</td>
                            <td>{{$history->first_name}}</td>
                            <td><a class="text-primary" href="{{route('payment.invoice.download' , $history->id)}}">Print Invoice</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
</div>
@stop
