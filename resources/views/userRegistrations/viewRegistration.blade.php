@extends('layouts.app')

@section('page-title', __(' Registrations Detail'))
@section('page-heading', __(' Registrations Detail'))

@section('breadcrumbs')
<li class="breadcrumb-item">
    <a href="{{ route('userRegistrations.index') }}">@lang('user Registrations')</a>
</li>
<li class="breadcrumb-item active">
    Registration Detail
</li>
@stop

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="card">
           
            <div class="card-body">
                <div class="d-flex align-items-center flex-column pt-3">
                    <div>
                        @if ($registrationsDetail[0]->avatar!='')
                        <a href="{{ url('upload/users/') . '/' . $registrationsDetail[0]->avatar }}">
                            <img class="rounded-circle img-responsive" width="40"
                                src="{{ url('upload/users/') . '/' . $registrationsDetail[0]->avatar }}" alt="profile">
                        </a>
                        @else
                        <a href="{{ url('assets/img/profile.png') }}">
                            <img class="rounded-circle img-responsive" width="40"
                                src="{{ url('assets/img/profile.png') }}" alt="profile">
                        </a>
                        @endif
                    </div>


                    <h5>{{ $registrationsDetail[0]->student_registration_code }}</h5>


                    <a href="mailto:{{ $registrationsDetail[0]->email }}" class="text-muted font-weight-light mb-2">
                        {{ $registrationsDetail[0]->email }}
                    </a>
                </div>
                <h5>Student Informations:</h5>
                <table class="table">
                    <tr>
                        <td>
                            <strong>@lang('Name'):</strong>
                        </td>
                        <td>
                            {{ $registrationsDetail[0]->first_name }} {{ $registrationsDetail[0]->last_name}}
                        </td>
                    </tr>
                   
                    <tr>
                        <td><strong>@lang('Center Name')</strong></td>
                        <td> {{ $registrationsDetail[0]->center_name}}</td>
                    </tr>
                   
                    <tr>
                        <td><strong>@lang('Course Name')</strong></td>
                        <td> {{ $registrationsDetail[0]->course_name}}</td>
                    </tr>
                    @if ($registrationsDetail[0]->phone)
                    <tr>
                        <td> <strong>@lang('Phone'):</strong></td>
                        <td>
                            <a
                                href="telto:{{ $registrationsDetail[0]->phone }}">{{ $registrationsDetail[0]->phone }}</a>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td><strong>@lang('Registration Status')</strong></td>
                        <td><strong class="badge badge-info"> {{ $registrationsDetail[0]->registration_status}} </strong></td>
                    </tr>
                </table>
                <hr>
                <h5>Edit Fee Section:</h5>
                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="hidden" id="newDiscountUpdateUrl" value="{{ route('updateDiscount') }}">
                                        <input type="hidden" id="tokenPageId" value="{{ Crypt::encrypt($registrationsDetail[0]->enroll_id) }}">
                                        <label for="center_code">@lang('Add Discount(in ₹)')</label>
                                        <input type="number" class="form-control input-solid " min="0" id="newDiscount" name="newDiscount" value="{{ $registrationsDetail[0]->newDiscount }}" placeholder="Enter discount for this registration">
                                        <span id="newDiscountError" class="text-danger"></span>
                                    </div>
                                    <button type="submit" class="btn btn-primary" id="discountAddBtn">
                                    @lang('Add Discount')
                                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-6 m-0 p-0">
        <div class="card m-0 p-0">
            <div class="card-body">
             <h5>Student Fee Plan Informations:</h5>
                <table class="table" style="line-height: 13px;">
                    <tr>
                        <th>Fee Plan Name</th>
                        <td><strong>{{$registrationsDetail[0]->name}}</strong></td>
                    </tr>
                    <tr>
                        <th>Fee Plan Type</th>
                        <td><strong>{{$registrationsDetail[0]->selected_fee_type}}</strong></td>
                    </tr>
                    <tr>
                        <th>Total Fee Amount</th>
                        <td><strong>{{$registrationsDetail[0]->total_bill_amount}}</strong></td>
                    </tr>
                    <tr>
                        <th>Discount</th>
                        <td class="text-success"><strong>₹ {{$registrationsDetail[0]->discount_value}}</strong></td>
                    </tr>
                    <tr>
                        <th>Discount Status</th>
                        <td><strong> {{$registrationsDetail[0]->discountApproveStatus}}</strong></td>
                    </tr>
                    <tr>
                        <th>Total Payable Fee Amount (₹)</th>
                        <td><strong>{{$registrationsDetail[0]->total_payable_amount }}</strong></td>
                    </tr>
                    <tr>
                        <th>Amount Paid (₹)</th>
                        <td><strong>{{$registrationsDetail[0]->amount_paid}}</strong></td>
                    </tr>
                    @if($registrationsDetail[0]->amount_paid != 0)
                    <tr>
                        <th>Due Amount (₹)</th>
                        <td><strong>{{$registrationsDetail[0]->total_due_amount}}</strong></td>
                    </tr>
                    @endif
                    <hr>
                </table>
                @if(count($userInstallments)>0)
                <h4 class="text-center">@lang('Fee Installments')</h4>
                <table class="table" style="line-height: 13px;">
                    <thead>
                        <tr>
                            <th>Installment</th>
                            <th>Installment Amount</th>
                            <th>Due Time</th>
                            <th>Paid Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($userInstallments as $installment)
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $installment->installment_amount }} @if($installment->due_time==0)
                                <span class="text-danger"><br><strong>Down payment</strong> </span> @endif
                            </td>
                            <td>{{ $installment->due_time }} Days</td>
                            <td>{{ $installment->paid_amount }}</td>
                            <td><span class="badge badge-warning">{{ $installment->status }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>

      @if($registrationsDetail[0]->selected_fee_type == 'installment')
      @if(count($userInstallments)>0)
     <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5>Edit Student Fee Installments Section:</h5>
                <form method="POST" action="{{ route('userRegistrations.update',Crypt::encrypt($registrationsDetail[0]->enroll_id)) }}" id="student-fee-plan-form">
                <input type="hidden" class="d-none" id="TotalPayableFeeStudent" value="{{$registrationsDetail[0]->total_payable_amount }}">
            @csrf
            <div id="student-fee-plan-form-errors" class="text-center text-danger"></div>
            <div id='installmentShow_div_ins_edit'>

                <div id="installmentShow_div_ins_Edit">

                    <?php $i =1 ; ?>
                    <div class="row">
                    @foreach($userInstallments as $installment)
                    @if($installment->due_time==0)
                        <div class="col-md-6" id="downPaymentFormGroup">
                            <label class="control-label" for="text"><strong>Down Payment:</strong></label>
                            <input type="number" class="form-control input-solid valid" min="0" id="DownPayment"
                                value="{{$installment->installment_amount}}" name="DownPayment" aria-invalid="false">

                        </div>
                        @endif
                        @endforeach
                        <div class="col-md-6" id="installmentsCountFormGroup">
                            <label class="control-label" for="text"><strong>No Of Installments:</strong></label>
                            <input type="number" class="form-control input-solid valid" min="0" id="totalStudentsInstallments"
                                value="{{count($userInstallments)-1 }}" name="totalStudentsInstallments" aria-invalid="false">
                        </div>
                    </div>
                    <div class="text-center mb-3 m-3">
                       <button type='button' id='studentInstallmentShow_btn' class='btn btn-success '>ReDefine Installment</button>
                    </div>
                    <div id="otherStudentInstallmentsDiv">
                    @foreach($userInstallments as $installment)
                    @if($installment->due_time!=0)
                    <div class="row installmentDiv">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="number"><strong> Installment
                                    {{$loop->iteration-1}}</strong></label>
                            <input type="number" class="form-control input-solid" min="0" id="Installment{{$loop->iteration-1}}"
                                value="{{$installment->installment_amount}}" name="Installment{{$loop->iteration-1}}" 0="">
                        </div>

                        <div class="form-group col-6">
                            <label class="control-label" for="number"><strong> Due Time for Installment
                                    {{$loop->iteration-1}} (Days):</strong></label>
                            <input type="number" class="form-control input-solid" min="0" id="dueInstallment{{$loop->iteration-1}}" 1=""
                                value="{{$installment->due_time}}" name="dueInstallment{{$loop->iteration-1}}" 0="">
                        </div>
                    </div>
                    @endif
                    @endforeach
                    </div>
                </div>
            </div>
            <div id="insDiv"></div>
            <div class="text-center mb-3">
                <button type="submit" id="" class="btn btn-success bg-success">Update</button>
            </div>
            </form>
            </div>
        </div>
    </div>
   @endif
   @endif
</div>

<div class="row">
    <div class="col-md-12">
    <div class="card mt-2 p-0">
    
          <div class="card-body">
          <h4 class="text-center">@lang('Payment History')</h4>
                <table class="table" style="line-height: 13px;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Date</th>
                            <th>Bank</th>
                            <th>Received BY</th>
                            <th>Screenshot</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($paymentHistory as $history)
                        <tr>
                            <th>{{$loop->iteration-1}}</th>
                            <td id="offlineAmount" class="offlineAmount">{{$history->amount}}</td>
                            <td>{{$history->payment_method}}</td>
                            <td>{{$history->created_at}}</td>
                            <td>{{$history->bank}}</td>
                            <td>{{$history->first_name}}</td>
                            <td><a class="text-primary" target="_blank" href="{{ url('payments/'.$history->screenshot) }}">View</a></td>
                            <td>
                            <input type="hidden" id="newStatusUpdateUrl" value="{{ route('updateStatus') }}">
                            <input type="hidden" id="statustokenPageId" class="statustokenPageId" value="{{ $history->id }}">
                            <input type="hidden" id="studentRegistrationId" class="statustokenPageId" value="{{ $history->user_registration_id }}">
                            <select id="changeStatus" aria-label="Default select example" name="newStatus" class="form-select form-control input-solid changeStatus">
                                <option value="captured" {{ "captured" == $history->status  ? 'selected' : ''}}>Approved</option>
                                <option value="canceled" {{ "canceled" == $history->status  ? 'selected' : ''}}>Cancelled</option>
                                <option value="pending" {{ "pending" == $history->status  ? 'selected' : ''}}>Pending</option>
                            </select>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
          </div>
        </div>
    </div>
</div>


@stop
@section('scripts')
{!! HTML::script('assets/js/feePlan/studentFeePlan.js') !!}
@stop