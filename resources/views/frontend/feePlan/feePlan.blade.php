<div class="card container mt-3">

    <div class="card-body">
        <div class="d-flex align-items-center flex-column pt-3">
        </div>
        <div class="">

        </div>
        <div class="row">
            <div class="col-md-4" style="line-height: 0.5">
                <table class="table">
                    <tbody>
                        <tr>
                            <td><strong>Total Fees</strong></td>
                            <td>{{$feeData[0]->total_fee}}</td>
                        </tr>
                        <!-- <table>
                        @foreach($feedetails as $feedetail)
                        <tr>
                            <th> {{ $feedetail->fee_heads_title }} :</th>
                            <td>{{ $feedetail->amount }}</td>
                        </tr>
                        @endforeach
                        </table> -->

                    </tbody>
                </table>
            </div>
        </div>


        <div class="row">
            <div class="col-md-6">
                <!-- <h3 class="text-center">@lang('Fee distribution'):</h3> -->
                <table class="table jumbotron" style="background-color: #ffc600;line-height: 0.5;">
                    <tbody>
                        <tr>
                            <td colspan="2" style="background-color: #07294d;color:#ffc600">
                                <h5 class="text-center" style="color:#ffc600">@lang('Fee Destribution')
                                </h5>
                            </td>
                        </tr>
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
                <table class="table jumbotron" style="background-color: #ffc600;line-height: 0.5">
                    <tbody>
                        <tr>
                            <td colspan="2" style="background-color: #07294d;">
                                <h5 class="text-center" style="color:#ffc600">@lang('Fee Installments')
                                </h5>
                            </td>
                        </tr>
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
