@include('partials.messages')
<div class="card">
    <div class="card-body">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="alert alert-danger print-error-msg" style="display:none">
        <ul></ul>
    </div>
        <input type="hidden" id="ajaxUrlCenterCourse" value="{{ route('feePlan.getCourseAndCenterName') }}">
        <input type="hidden" id="ajaxUrlfeeHeads" value="{{ route('feePlan.getFeeHeads') }}">
        <form method="POST" action="" data-hrefEdit="{{ route('feePlan.update_feePlan') }}" id="fee-plan-form-update">
            @csrf
            @method('PUT')
            <input type="hidden" id="feeplanid" value="{{$feeData->id}}">

            <div class="row">
                <!-- <div class="col-md-6">
                    <div class="form-group">
                        <label for="fee_heads_title">@lang('Center Name')</label>
                        <select id="center_id" class="form-select form-control input-solid"
                            aria-label="Default select example" name="center_id">
                            <option value="">select center</option>
                            
                        </select>
                    </div>
                </div> -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fee_heads_title">@lang('Course Name')</label>
                        <select id="course_id" name="course_id" class="form-select form-control input-solid"
                            aria-label="Default select example" name="course_id">
                            <option value="{{ $feeData->course_id }}">{{ $feeData->course_name }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fee_heads_title">@lang('Fee Plan Name')</label>
                        <input type="text" class="form-control input-solid" id="fee_plan_name_edit"
                            name="fee_plan_name_edit" placeholder="Enter Fee Plan Name" value="{{$feeData->name}}">
                        </select>
                    </div>
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="fee_heads_title">@lang('Fee Plan Type')</label>
                        <select id="fee_type_edit" class="form-select form-control input-solid"
                            aria-label="Default select example" name="fee_type_edit" disabled>
                            <option value="#">Select Type</option>
                            <option value="lumpsum" {{ "lumpsum" == $feeData->fee_type  ? 'selected' : ''}}>Lumpsum
                            </option>
                            <option value="installment" {{"installment"== $feeData->fee_type  ? 'selected' : ''}}>
                                Installment</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-6" id="fee_type_div">
                    <label>Total Fee </label>
                    <input type='text' value={{$feeData->total_fee  }} class='form-control input-solid'
                        id='total_fee_edit' name='total_fee_edit'>
                </div>
            </div>
            <!-- <button type='button' id='feeHead' class='btn btn-success btn-sm d-none'>Define Fee Head</button> -->
            <div class="row" id='fee_head_div'>
                @foreach($feeHeads as $feehead)
                @php
                $value=0;
                @endphp
                @foreach($feedetails as $feedetail)
                @if($feedetail->fee_head_id==$feehead->id)
                @php
                $value=$feedetail->amount;
                @endphp
                @endif
                @endforeach
                <div class="form-group">
                    <label class="control-label col"
                        for="text"><strong>@lang($feehead->fee_heads_title):</strong></label>
                    <div class="col">
                        <input type="text" data-id="{{ $feehead->id }}" class="form-control input-solid"
                            value="{{ $value   }}" id="{{$feehead->fee_heads_title}}" name="feeHeadsEdit[]"
                            data-feeHeads=" {{$feehead->id }}">
                    </div>
                </div>

                @endforeach
            </div>


            @if($feeData->fee_type == "installment")

            <div class="row">
                <div class="col-md-4">
                    <button type='button' id='installmentShow_btn_edit' onclick="defineInstallment()"
                        class='btn btn-success btn-sm '>Define
                        Installment</button>
                </div>
                <div class="col-md-8 text-danger" id="errorTotal">

                </div>
            </div>

            <div id='installmentShow_div_ins_edit'>

                <div id="installmentShow_div_ins_Edit">

                    <?php $i =1 ; ?>
                    @foreach($installments as $installment)


                    @if($installment->due_time==0)
                    <div class="row">

                        <div class="col-md-6">
                            <label class="control-label" for="text"><strong>Down Payment:</strong></label>
                            <input type="number" class="form-control input-solid valid" min="0" id="downPayment"
                                value="{{$installment->installment_amount}}" name="Installment" aria-invalid="false">
                            <input type="hidden" class="form-control input-solid" min="0" id="dueInstallment" value="0"
                                name="dueInstallment" }="">
                        </div>
                        <div class="col-md-6">
                            <label class="control-label" for="text"><strong>No Of Installments:</strong></label>
                            <input type="number" class="form-control input-solid valid" min="0" id="totalInstallments"
                                value="{{count($installments)-1 }}" name="totalInstallments" aria-invalid="false">
                        </div>
                    </div>

                    @else
                    @if($i ==1)
                    <div id="installmentError" class="text-danger"></div>
                    <?php  $i++; ?>
                    @endif
                    <div class="row installmentDiv">
                        <div class="form-group col-md-6">
                            <label class="control-label" for="number"><strong> Installment
                                    {{$loop->iteration-1}}</strong></label>
                            <input type="number" class="form-control input-solid" min="0" id="Installment"
                                value="{{$installment->installment_amount}}" name="Installment" 0="">
                        </div>

                        <div class="form-group col-6">
                            <label class="control-label" for="number"><strong> Due Time for Installment
                                    {{$loop->iteration-1}} (Days):</strong></label>
                            <input type="number" class="form-control input-solid" min="0" id="dueInstallment" 1=""
                                value="{{$installment->due_time}}" name="dueInstallment" 0="">
                        </div>
                    </div>

                    @endif
                    @endforeach

                </div>
            </div>
            <div id="insDiv"></div>
            @endif

            <div class="text-center mb-3">
                <button type="submit" id="" class="btn btn-success bg-success">Update</button>
            </div>
        </form>
    </div>
</div>

<script>
    // update fee plaan 


    $('#fee-plan-form-update').validate({
        rules: {
            course_id: {
                required: true
            },
            fee_plan_name_edit: {
                required: true
            },
            fee_type_edit: {
                required: true
            },
            total_fee_edit: {
                required: true
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        },
        messages: {
            course_id: {
                required: 'Please Select Course'
            },
            fee_plan_name_edit: {
                required: 'Please Enter Fee Plan Name'
            },
            fee_type_edit: {
                required: 'Please Select Fee Type'
            },
            total_fee_edit: {
                required: 'Please Enter Total Fee Amount'
            }
        },
        submitHandler: function (form) {
            var fee_plan_name_edit = $('#fee_plan_name_edit').val();
            var fee_type = $('#fee_type_edit').val();
            var total_fee = $('#total_fee_edit').val();
            //var center_id = $("#center_id").val();
            var course_id = $("#course_id").val();

            var arr = $('input[name="feeHeadsEdit[]"]');

            var feeHeadId = [];
            var installment = $('input[name="Installment"]');
            var dueInstallment = $('input[name="dueInstallment"]');
            var installments = [];
            var checkTotalFee = 0;
            for (var i = 0; i < arr.length; i++) {
                feeHeadId.push({
                    'id': $(arr[i]).attr('data-feeHeads'),
                    'amount': $(arr[i]).val()
                });
                checkTotalFee = Number($(arr[i]).val()) + Number(checkTotalFee);
            }

            for (var i = 0; i < installment.length; i++) {
                installments.push({
                    'amount': $(installment[i]).val(),
                    'time': $(dueInstallment[i]).val()
                });
            }

            var formData = {
                fee_plan_name_edit: fee_plan_name_edit,
                fee_type: fee_type,
                total_fee: total_fee,
                feeHeadId: feeHeadId,
                installments: installments,
                course_id: course_id
                //,
                //center_id: center_id,
            }



            var feePlanId = $("#feeplanid").val();
            console.log("feePlanId");
            console.log(feePlanId);

            formData.feePlanId = feePlanId;
            console.log(formData);
            // return false ;
            var url = $(form).attr('data-hrefEdit');
            var method = $(form).attr('method');


            if ($("#fee_type_edit").val() == "installment") {
                // console.log(feeHeadId);
                var feeAmountSum = 0;
                feeHeadId.filter((val) => {
                    return feeAmountSum = parseInt(feeAmountSum) + parseInt(val.amount)
                })
                // console.log(feeAmountSum)
                if (feeAmountSum != total_fee) {
                    $("#errorTotal").empty();
                    $("#errorTotal").html("Fee head Amount is not match with total amount");
                    return false;
                }
                var installmentsSum = 0;
                var downPayment;
                installments.filter((val) => {
                    if (parseInt(val.time) != 0) {
                        return installmentsSum = parseInt(installmentsSum) + parseInt(val.amount);
                    } else {
                        downPayment = val.amount;
                    }
                });
                if (total_fee - downPayment != installmentsSum) {
                    $("#installmentError").empty();
                    $("#installmentError").html('Total installments is not match with total amount');
                    return false;
                }

            }
            $.ajax({
                url: url,
                type: method,
                data: formData,
                dataType: "json",
                success: function (response) {

                    if (response.success == true) {
                        $('#FeePlandetailEditModal').modal('hide');
                        $('#success-message').append(response.message);
                        $('#success-div').css('display', 'block');
                        window.location.href=""
                    }
                    else{
                $(".print-error-msg").find("ul").append('<li>'+response.message+'</li>');
                       
                    }

                }
            })
            function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
           }
        }
    });


    function defineInstallment() {
        var totalInstallments = $("#totalInstallments").val();
        $("#installmentError").empty();
        $(".installmentDiv").empty();
        $("#errorTotal").empty();
        $("#insDiv").empty();
        for (let i = 0; i < totalInstallments; i++) {
            $("#insDiv").append(`<div class="row">
             <div class="form-group col-6">
                 <label class="control-label " for="number"><strong> Installment ${
                         i + 1
                         }:</strong></label>
                 <div class="">
                     <input type="number" class="form-control input-solid" min="0" id="Installment" ${ i + 1 }
                         name="Installment" ${i}>
                 </div>
             </div>
             <div class="form-group col-6">
                 <label class="control-label " for="number"><strong> Due Time for Installment ${
                         i + 1
                         } (Days):</strong></label>
                 <div class="">
                     <input type="number" class="form-control input-solid" min="0" id="dueInstallment" ${ i + 1 }
                         name="dueInstallment" ${i}>
                 </div>
             </div>
             </div>`);
        }
        console.log(totalInstallments);
    }

</script>
