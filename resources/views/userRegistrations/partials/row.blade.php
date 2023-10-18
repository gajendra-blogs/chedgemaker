<tr>
    <td style="width: 40px;">
        @if ($registrationData->avatar!='')
        <a href="{{ url('upload/users/') . '/' . $registrationData->avatar }}">
            <img class="rounded-circle img-responsive" width="40"
                src="{{ url('upload/users/') . '/' . $registrationData->avatar }}" alt="profile">
        </a>
        @else
        <a href="{{ url('assets/img/profile.png') }}">
            <img class="rounded-circle img-responsive" width="40" src="{{ url('assets/img/profile.png') }}"
                alt="profile">
        </a>
        @endif
        {{ $registrationData->first_name . ' ' . $registrationData->last_name }}</td>

    <td>{{ $registrationData->email }}</td>
    <td>{{ $registrationData->phone }}</td>
    <td>
        <p>{{ $registrationData->student_registration_code }}</p>
    </td>
    <td>{{ $registrationData->center_name }}</td>
    <td>{{ $registrationData->course_name }}</td>
    <td>{{ $registrationData->total_bill_amount }}</td>
    <td> {{ $registrationData->total_payable_amount }}</td>
    <td>{{ $registrationData->selected_fee_type }}</td>
    <td>{{ $registrationData->amount_paid }}</td>

    <td>

        @if ($registrationData->registration_status=='pending')
        <a href="" class="badge badge-warning">Pending</a>

        @elseif($registrationData->registration_status=='booked')
        <a href="" class="badge badge-info">Booked</a>
        @else
        <a href="" class="badge badge-success">Registered</a>

        @endif

    </td>
    <td>
        @if(auth()->user()->role_id != 1)
        @if ($registrationData->discountApproveStatus=='approved')
        <a href="#" class="badge badge-success">Approved</a>
        @elseif($registrationData->discountApproveStatus=='cenceled')
        <a href="#" class="badge badge-danger">cenceled</a>
        @elseif($registrationData->discountApproveStatus == 'pending')
        <a href="#" class="badge badge-warning">pending</a>
        @else
        <a href="#" class="badge badge-info">No Discount</a>

        @endif

        @else

        @if ($registrationData->discountApproveStatus=='approved')
        <a href="#" class="badge badge-success p-1">Approved</a>
        @elseif($registrationData->discountApproveStatus=='cenceled')
        <a href="#" class="badge badge-danger">cenceled</a>
        @elseif($registrationData->discountApproveStatus=='pending')

        ₹ {{ $registrationData->newDiscount }}

        <br>

        <button class="btn btn-success p-1" title="approve Discout Request"
            onclick="approveDiscount('{{ Crypt::encrypt($registrationData->enroll_id) }}')">&#10003</button>
        <button class="btn btn-danger p-1" title="cencel Discout Request"
            onclick="CencelDiscount('{{ Crypt::encrypt($registrationData->enroll_id) }}')">&#10005</button>
            @else
        <a href="#" class="badge badge-info">No Discount</a>

            @endif
        @endif
    </td>
    <td class="text-center">

        <a href="{{ route('userRegistrations.show',Crypt::encrypt($registrationData->enroll_id)) }}" type="submit"
            class="btn btn-icon" title="@lang('View Registration detail')" data-toggle="tooltip" data-placement="top">
            <i class="fas fa-eye mr-2"></i>
        </a>
        <a href="{{ route('userRegistrations.destroy',Crypt::encrypt($registrationData->enroll_id)) }}"
            class="btn btn-icon" title="@lang('Delete Registration')" data-toggle="tooltip" data-placement="top"
            data-method="DELETE" data-confirm-title="@lang('Please Confirm')"
            data-confirm-text="@lang('Are you sure that you want to delete this registration?')"
            data-confirm-delete="@lang('Yes, delete it!')">
            <i class="fas fa-trash"></i>
        </a>
    </td>
</tr>
