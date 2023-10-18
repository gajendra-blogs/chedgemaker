@extends('layouts.home')
@section('page-title', __('My Course'))
@section('page-heading', __('My Course'))

@section('content')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-6 p-3" style="box-shadow: 0 2px 20px 0 rgb(0 0 0 / 15%);">
            <div class="section-title m-3">
                 <h5> <strong>Course Invoice</strong> </h5>
            </div>
        <div class="card">
            <table class="table table-sm">
               
                <tbody>
                    <tr>
                        <th scope="row">Center Name</th>
                        <td>{{$studentCoursePlan[0]->center_name}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Course Name</th>
                        <td>{{$studentCoursePlan[0]->course_name}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Fee Plan Type</th>
                        <td>{{$studentCoursePlan[0]->selected_fee_type}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Total Fee (in ₹)</th>
                        <td>{{$studentCoursePlan[0]->total_bill_amount}}</td>
                    </tr>

                    @if($studentCoursePlan[0]->discount_value >0)
                    <tr>
                        <th scope="row">Discount (in ₹)</th>
                        <td class="text-success">- <strong>{{ $studentCoursePlan[0]->discount_value }}</strong></td>
                    </tr>
                    @endif
                    <tr>
                        <th scope="row">Total Payable Amount (in ₹)</th>
                        <td>{{$studentCoursePlan[0]->total_payable_amount}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Amount Paid (in ₹)</th>
                        <td>{{$studentCoursePlan[0]->amount_paid}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Due Amount (in ₹)</th>
                        <td>{{$studentCoursePlan[0]->total_payable_amount - $studentCoursePlan[0]->amount_paid}}</td>
                    </tr>
                    <tr>
                        <th scope="row">Registration Status</th>

                        <td style="text-transform: uppercase;"><strong>{{$studentCoursePlan[0]->registration_status}}</strong></td>
                    </tr>
                    @if(count($installments)>0)
                    <tr>
                        <th>
                        <div class="section-title m-3">

<h5> <strong>Installment</strong> </h5>
</div>
                        </th>
                    </tr>
                    @foreach($installments as $installment)

                    <tr>
                        <th> @if($installment->due_time==0) <span
                                class="text-danger">Down Payment</span>
                                @else
                                Installment {{ $loop->iteration -1 }}
                                 @endif :
                        </th>
                        <td>

                            {{ $installment->installment_amount }}
                            @if($installment->status=="pending")
                            &nbsp;&nbsp;&nbsp;<span class="badge badge-warning">pending</span>
                            @else
                            &nbsp;&nbsp;&nbsp;<span class="badge badge-success">Paid</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    @endif
                    <tr>
                        <th scope="row">Payment Status</th>
                        <td>
                            @if($studentCoursePlan[0]->registration_status=="pending")
                            <span class="badge badge-warning">pending</span>
                            @elseif($studentCoursePlan[0]->registration_status=="registered")
                            <span class="badge badge-success">completed</span>
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        </div>
        @if($studentCoursePlan[0]->registration_status!="registered")
        <div class=" col-md-6 p-3" style="box-shadow: 0 2px 20px 0 rgb(0 0 0 / 15%);">
            <div class="section-title m-3">

                <h5> <strong>Payment Section</strong> </h5>
            </div>
        <div class="card row">
        <ul class="nav nav-tabs" id="nav-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="online-tab" data-toggle="tab" href="#online-form" role="tab" aria-controls="home" aria-selected="true">
                    @lang('Online Payment')
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="offline-tab" data-toggle="tab" href="#offline-form" role="tab" aria-controls="home" aria-selected="true">
                    @lang('Offline Payment')
                </a>
            </li>
        </ul>
        </div>
        <div class="tab-content mt-4" id="nav-tabContent">
        <div class="tab-pane fade show active px-2" id="online-form" role="tabpanel" aria-labelledby="nav-home-tab">

            <form action="{{route('payment-submit')}}" id="paymentSubmit" method="post">
                @csrf
                <input type="hidden" value="{{route('orderid.generate')}}" id="orderIdRoute">
                <input type="hidden" name="registration_id" value="{{ $studentCoursePlan[0]->id }}">
                <input type="hidden" name="razorpay_payment_id" value="" id="razorpay_payment_id">
                <input type="hidden" name="razorpay_order_id" value="" id="razorpay_order_id">
                <input type="hidden" name="razorpay_signature" value="" id="razorpay_signature">
                <input type="hidden" name="generated_signature" value="" id="generated_signature">

                <table class="table">
                    <tr>
                        <th colspan="3" class="text-center">
                            <h3>Amount To Pay</h3>
                        </th>
                    </tr>
                    @if($studentCoursePlan[0]->selected_fee_type=="lumpsum")
                    <tr>
                        <td class="text-right"><input type="radio" class="cb" name="amount" checked></td>
                        <th>Total Amount</th>
                        <td>{{$studentCoursePlan[0]->total_payable_amount - $studentCoursePlan[0]->amount_paid}}
                        </td>
                        <input type="hidden" name="installment_id" id="installment_id" value="0">
                    </tr>
                    @else
                    @if(count($installments)>0)
                    @php
                      $due_day=0;  
                        @endphp
                   @foreach($installments as $installment)
                   @php
                      $due_day += $installment->due_time; 
                     
                        @endphp
                   @if($installment->status=="pending")
                    <tr>
                        <td class="text-right"><input type="radio" class="cb" name="amount" checked></td>
                        @if($installment->due_time == 0)
                        <th>Down Payment</th>
                        @else
                       
                        <th>Installments {{$loop->iteration-1}}
                        <p class="text-danger">Last Date:
                        @php
                        $old_date= $studentCoursePlan[0]->booked_on;
                        $next_due_date = date('d-m-Y', strtotime($old_date. ' +'.$due_day.' days'));
                        echo $next_due_date;
                        
                        @endphp
                    </p></th>
                        @endif
                        <td>{{$installment->installment_amount - $installment->paid_amount }}</td>
                        <input type="hidden" name="installment_id" id="installment_id" value="{{$installment->id}}">
                       
                    </tr>
                    @break
                    @endif

                    @endforeach
                    @endif
                    @endif
                    @if($studentCoursePlan[0]->registration_status=="pending")
                    <tr>
                        <td class="text-right"><input type="radio" class="cb" name="amount"></td>
                        <th>Booking Amount</th>
                        <td>{{$booking_fee_head[0]->amount}}</td>
                    </tr>
                    @if($studentCoursePlan[0]->selected_fee_type=="lumpsum")
                    <tr>
                        <td class="text-right"><input type="radio" class="cb" name="amount"></td>
                        <th>Other Amount</th>
                        <td><input type="text" name="other_amount" value="" id="other_amount"
                                placeholder="Enter Amount"></td>
                    </tr>
                    @endif
                    @endif
                    <!-- <tr colspan="3">
                    <td><button type="button" class="btn btn-primary">Pay Now</button></td>
                </tr> -->
                    <tr>

                        <td colspan="3" class="text-center">
                            <p id="error" class="text-danger text-left"></p>

                            <label for="pay">

                                <input type="hidden" name="_token" value="{!!csrf_token()!!}">
                                <button type="button" id="payButton" class="btn"
                                    style="background-color:#07294d ; color:#ffc600">
                                    Pay Now</button>
                            </label>
                        </td>
                    </tr>
                </table>
                <!-- <script src="https://checkout.razorpay.com/v1/checkout.js" id="setAmount"
                    data-key="{{ env('RAZORPAY_KEY') }}" data-amount="" data-buttontext="Pay 10 INR"
                    data-name="LaravelTuts.com" data-description="Rozerpay"
                    data-image="https://laraveltuts.com/wp-content/uploads/2022/08/laraveltuts-rounde-logo.png"
                    data-prefill.name="name" data-prefill.email="email" data-theme.color="#ff7529">
                </script> -->
            </form>
        </div>
        <div class="tab-pane fade px-2" id="offline-form" role="tabpanel" aria-labelledby="nav-profile-tab">

            <div class="text-center">
               
              </div>
              <form action="{{route('offlinePayment')}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="registration_id" value="{{ $studentCoursePlan[0]->id }}">
                @csrf
                <div class="form-group">
                    <label for="select_mode">@lang('Payment Mode')</label>
                        <select id="select_mode" class="form-select form-control input-solid "
                                    aria-label="Default select example" name="payment_method" required>
                        <option value="">Choose Mode</option>
                        <option value="offline/cash">Cash</option>
                        <option value="offline/bank">Bank Transfer</option>
                        <option value="offline/cheque">Cheque</option>
                        <option value="offline/upi">Direct UPI</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="transaction_id">@lang('Transaction ID')</label>
                    <input type="text" class="form-control input-solid" id="transaction_id"
                           name="transaction_id" placeholder="@lang('cheque/bank/upi')" value="" required>
                </div>
                <div class="form-group">
                    <label for="bank">@lang('Bank Name')</label>
                    <input type="text" class="form-control input-solid" id="bank"
                           name="bank" placeholder="@lang('cheque/bank')" value="">
                </div>
                <div class="form-group">
                    <label for="transaction_date">@lang('Transaction Date')</label>
                    <input type="date" class="form-control input-solid" id="transaction_date"
                           name="bank_check_date" placeholder="@lang('transaction date')" value="">
                </div>
                <div class="form-group">
                    <label for="amount">@lang('Amount')</label>
                    <input type="text" class="form-control input-solid" id="amount"
                           name="amount" placeholder="@lang('Amount')" value="" required>
                </div>
                <div class="form-group">
                    <label for="screenshot">@lang('Screenshot')</label>
                    <input type="file" class="form-control input-solid" id="screenshot"
                           name="screenshot" placeholder="@lang('payment screenshot')" value="" required>
                </div>
                <div class="m-3">
                    <button type="submit" class="btn btn-primary w-100" id="update-details-btn" style="background-color:#07294d ; color:#ffc600">
                        @lang('Submit Details')
                    </button>
                </div>
              </form>
        </div>
        </div>
        </div>
        @endif

    </div>
</div>
@section('scripts')
{!! HTML::script('assets/frontend/js/user/mycourse.js') !!}
@stop
@stop
