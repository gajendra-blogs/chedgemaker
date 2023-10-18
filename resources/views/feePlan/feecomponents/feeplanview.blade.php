<div class="card" style="background-color:#ffc600">

    <div class="card-body">
        <div class="d-flex align-items-center flex-column pt-3">
            <h5 class="mt-0 pt-0">{{ $feeData[0]->name }}
                @if ($feeData[0]->status==1)
                <a href="#" class="badge badge-success">active</a>
                @else
                <a href="#" class="badge badge-warning">inactive</a>
                @endif
            </h5>
        </div>
        <div class="">
            <div class="col-md-12" style="line-height: 0.5">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <td><strong>@lang('Plan Name')</strong></td>
                            <td>{{ $feeData[0]->name }}</td>
                        </tr>


                        <tr>
                            <td scope="row"> <strong>@lang('course_name')</strong></td>
                            <td> {{ $feeData[0]->course_name }}</td>
                        </tr>
                        <tr>
                            <td scope="row"> <strong>@lang('Fee Type')</strong></td>
                            <td> {{ $feeData[0]->fee_type }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="row">
            <div class="col-md-6">
                <h3 class="text-center">@lang('Fee distribution'):</h3>
                <table class="table jumbotron">
                    <tbody>
                        @foreach($feedetails as $feedetail)
                        <tr>
                            <th> {{ $feedetail->fee_heads_title }} :</th>
                            <td>{{ $feedetail->amount }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($feeData[0]->fee_type == 'installment')
            <div class="col-md-6">
                <h4 class="text-center">@lang('Fee Installments'): Except (Booking)</h4>
                <table class="table jumbotron">
                    <tbody>
                        @foreach($installments as $installment)
                        <tr>
                            <th>Istallment {{ $loop->iteration }} :</th>
                            <td>{{ $installment->installment_amount }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif

        </div>


    </div>
</div>
