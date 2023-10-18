$(() => {
    appySorting();


    // $("#selectBatch").change(function (ev) {
    //     var selectedBatchId = $(this).val();

    //     if (selectedBatchId == "#") {
    //         $("#select_center").empty();
    //         $("#select_course").empty();
    //         return false;
    //     }
    //     var url = $("#ajaxUrlCenterCourse").val();
    //     var method = "post";
    //     $.ajax({
    //         url: url,
    //         type: method,
    //         dataType: "json",
    //         data: { batch_id: selectedBatchId },
    //         success: function (response) {
    //             console.log(response);
    //             console.log(response.center_id);
    //             console.log(response.course_id);
    //             $("#select_center")
    //                 .empty()
    //                 .append(
    //                     `<option value="${response.center_id}">${response.center_name}</option>`
    //                 );
    //             $("#select_course")
    //                 .empty()
    //                 .append(
    //                     `<option value="${response.course_id}">${response.course_name}</option>`
    //                 );
    //         },
    //     });
    // });

    // $("#fee_type").change(function (ev) {
    //     var selectedFeeType = $(this).val();
    //     // if(selectedFeeType=="#"){
    //     $("#fee_type_div").empty();
    //     $("#fee_head_div").empty();
    //     $("#installmentShow_div").empty();
    //     $("#feeHead").addClass("d-none");
    //     $("#installmentShow_btn").addClass("d-none");
    //     // return false ;
    //     // }
    //     var fee_type_div = $("#fee_type_div");
    //     console.log(selectedFeeType);
    //     if (selectedFeeType != "lumpsum") {
    //         var setDiv = `<div class='row' >
    //         <div class='col-md-12' id="totalFeeFormGroup">
    //         <label>Total Fee </label>
    //         <input type='text' class='form-control' id='total_fee'  name='total_fee'>
    //         </div>
    //         </div> 
    //         `;
    //         fee_type_div.append(setDiv);
    //         $("#feeHead").removeClass("d-none");
    //     }
    //     if (selectedFeeType != "installment") {
    //         var setDiv = `<div class='row' >
    //       <div class='col-md-12' id="totalFeeFormGroup">
    //       <label>Total Fee </label>
    //       <input type='text' class='form-control input-solid' id='total_fee'  name='total_fee'>
    //       </div>
    //       </div> 
    //       `;
    //         fee_type_div.append(setDiv);
    //         $("#feeHead").removeClass("d-none");
    //     }
    // });

});

$('#select_center').on('change', function () {
    var selectedCenter = $(this).val();
    if (selectedCenter != '') {

        var url = `{{ url('/feePlan/getCoursesByCenter/${selectedCenter}')}}`;
        showLoading();
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.success == true) {
                    $('#no-courses').empty();
                    $('#select_course').empty();
                    $('#select_course').append(`<option value="">Select Courses</option>`);
                    if (response.courses.length <= 0) {
                        $('#no-courses').append('No Courses alloted for the center Please Allot Course')
                    } else {
                        response.courses.forEach(function (val) {
                            $('#select_course').append(`<option value="${val.course_id}">${val.course_name} </option>`);
                            $('#select_course').attr('disabled', false)
                        })
                        $('#no-courses').empty();
                    }
                }
            },
            complete: function () {
                hideLoading();
            }
        })
    }
})
// add fee head
$("#fee_type").change(function () {
    // $("#fee_head_div").empty();
    $("#installmentShow_div").empty();
    $("#totalFeeFormGroupError").empty();
    $("#installmentShow_btn").addClass("d-none");
    var url = $("#ajaxUrlfeeHeads").val();
    var totalFee = 0;
    // if (totalFee == "") {
    //     $("#totalFeeFormGroup").append(
    //         '<p class="text-danger" id="totalFeeFormGroupError">Please enter Total fee</p>'
    //     );
    //     return false;
    // }
    var selectedFeeType = $("#fee_type").val();

    console.log(url);
    $.ajax({
        url: url,
        type: "post",
        dataType: "json",
        data: {
            totalFee: totalFee
        },
        success: function (response) {
            // $("#fee_head_div").append(response.template);
            var BookingAmount = $("#Booking").val();
            $("#feeHead").addClass("d-none");
            if (selectedFeeType == "installment") {
                $("#installmentShow_btn").removeClass("d-none");

                $("#installmentShow_div")
                    .append(`

        <div class="row mb-2" >
          <div class="col-md-6" id="downPaymentFormGroup">
        <label class="control-label col" for="text"><strong>Down Payment:</strong></label>

             <input type="number" class="form-control input-solid" min="0" id="downPayment"  name="Installment">
             <input type="hidden" class="form-control input-solid" min="0" id="dueInstallment" value='0'  name="dueInstallment" required>
          </div>
          <div class="col-md-6" id="installmentsCountFormGroup">
          <label class="control-label col" for="text"><strong>No Of Installments:</strong></label>

             <input type="number" class="form-control input-solid" min="0" id="totalInstallments"  name="totalInstallments" required>
          </div>
        </div>`);
            }
        },
        error: function (error) {
            console.log(error);
        },
    });
});

// add fee installment
$("#installmentShow_btn").on("click", function (e) {
    console.log("hello");
    var totalFee = $("#total_fee").val();
    $("#installmentsCountFormGroupError").empty();
    $("#downPaymentFormGroupError").empty();

    var downPayment = $("#downPayment").val();
    var totalInstallments = $("#totalInstallments").val();
    if (downPayment == "") {
        $("#downPaymentFormGroup").append(
            '<p class="text-danger" id="downPaymentFormGroupError">Please enter Down Payment</p>'
        );
        return false;
    }

    if (totalInstallments == "") {
        $("#installmentsCountFormGroup").append(
            '<p class="text-danger" id="installmentsCountFormGroupError">Please enter number of installments</p>'
        );
        return false;
    }

    var restAmount = totalFee - downPayment;
    $("#installmentShow_div_ins").empty();


    for (let i = 0; i < totalInstallments; i++) {
        $("#installmentShow_div_ins")
            .append(`<div class="row"><div class="form-group col-6">
          <label class="control-label col" for="number"><strong> Installment ${i + 1
                }:</strong></label>
          <div class="col">
          <input type="number" class="form-control input-solid" min="0" id="Installment"${i + 1
                }  name="Installment"${i}>
          </div>
          </div>
          <div class="form-group col-6">
          <label class="control-label col" for="number"><strong> Due Time for Installment ${i + 1
                } (Days):</strong></label>
          <div class="col">
          <input type="number" class="form-control input-solid" min="0" id="dueInstallment"${i + 1
                }  name="dueInstallment"${i}>
          </div>
          </div>
          </div>`);
    }
    // $("#installmentShow_btn").addClass("d-none");
});

$(document).ready(function () {
    $("#fee-plan-form").submit(function (e) {
        e.preventDefault();


    });
    $(document).on("click", "#add-btn-head", function () {
        $("#fee-plan-form").trigger("reset");
        $("#edit-fee-plan").empty();
        $("#add-fee-plan").css("display", "block");
    });

    $('#fee-plan-form').validate({
        rules: {
            course_id: {
                required: true
            },
            fee_plan_name: {
                required: true
            },
            fee_type: {
                required: true
            },
            fee_heads_sequence: {
                required: true,
                digits: true
            },
            charges_default_value: {
                required: true,
                digits: true
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
                required: 'Please Select course'
            },
            fee_type: {
                required: 'Please Select Fee Plan Type'
            },
            fee_heads_sequence: {
                required: 'Please Enter Sequence',
                digits: 'Please Enter Valid Number of day'
            },
            charges_default_value: {
                required: 'Please Enter Charges',
                digits: 'Please Enter Valid Amount'
            }
        },
        submitHandler: function (form) {

            var fee_plan_name = $('#fee_plan_name').val();
            var fee_type = $('#fee_type').val();
            var total_fee = $('#total_fee').val();
            var center_id = $("#select_center").val();
            var course_id = $("#select_course1").val();
            var module_id = $("#select_module").val();

            var arr = $('input[name="feeHeads[]"]');
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
                checkTotalFee += Number($(arr[i]).val());
            }
            //    console.log(total_fee);
            //    console.log(checkTotalFee);
            if (total_fee == checkTotalFee) {


                //for Installments
                var total_installment = 0;
                for (var i = 0; i < installment.length; i++) {

                    installments.push({
                        'amount': $(installment[i]).val(),
                        'time': $(dueInstallment[i]).val()
                    });
                    total_installment += $(installment[i]).val();
                }
                console.log('installments');
                console.log(total_installment);
                var formData = {
                    fee_plan_name: fee_plan_name,
                    fee_type: fee_type,
                    total_fee: total_fee,
                    feeHeadId: feeHeadId,
                    installments: installments,
                    course_id: course_id,
                    center_id: center_id,
                    module_id: module_id
                }
                console.log(formData);


                var url = $(form).attr('data-href');
                // console.log(url)
                // return false;


                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        var response = JSON.parse(response);
                        if (response.success == true) {
                            $('#fee-plan-form').trigger("reset");
                            $('#exampleModalLong').modal('hide');
                            if (response.total_record == '1') {
                                $("#fee-head-table").find("tbody tr:last").after(response.template);
                                $("#fee-head-table").find("tbody tr:last").prev().remove();
                            } else {
                                $("#fee-head-table").find("tbody tr:last").after(response.template);
                            }
                            $('#success-message').append(response.message);
                            $('#success-div').css('display', 'block');
                            window.location.href = ""
                        }
                        if (response.success == false) {
                            $("#fee-plan-form-errors").empty();
                            $('#fee-plan-form-errors').append(response.message);
                        }

                        //   console.log(response);
                    },
                    error: function (error) {
                        var errorResponse = JSON.parse(error.responseText);
                        var errors = errorResponse.errors;
                        for (const key in errors) {
                            //   console.log(errors[key])
                            errors[key].forEach(element => {
                                //   console.log(element)
                                createErrorMeesage(element, $(`#${key}`), key);
                            });
                        }

                    }
                })
            } else {
                $("#fee-plan-form-errors").empty();
                $("#fee-plan-form-errors").append("<p class='text-danger'>Total fee is not equal to Total of fee head Distribution</p>")
                return false;
            }
        }
    });
});

function viewFeePlanDetail(feePlanId) {
    var url = $('#viewFeePlanDetailUrl').val();
    //   console.log(url);
    $("#FeePlandtailviewModalBody").empty();

    $.ajax({
        url: url,
        type: "post",
        dataType: "json",
        data: {
            feePlanId: feePlanId
        },
        success: function (response) {
            $("#FeePlandtailviewModal").modal();
            $("#FeePlandtailviewModalBody").append(response.template)
            //  console.log(response)
        },
        error: function (error) {
            // console.log(error);
        },
    });
}

function viewFeePlanDetail(feePlanId) {
    var url = $('#viewFeePlanDetailUrl').val();
    //   console.log(url);
    $("#FeePlandtailviewModalBody").empty();

    $.ajax({
        url: url,
        type: "post",
        dataType: "json",
        data: {
            feePlanId: feePlanId
        },
        success: function (response) {
            $("#FeePlandtailviewModal").modal();
            $("#FeePlandtailviewModalBody").append(response.template)
            //  console.log(response)
        },
        error: function (error) {
            // console.log(error);
        },
    });

}


function editFeePlan(feePlanId, url) {
    var url = $("#editFeePlanDetails").attr("data-href");
    // console.log(feePlanId);
    // console.log(url);
    $("#FeePlandetailEditModalBody").empty();

    $.ajax({
        url: url,
        type: "get",
        dataType: "json",
        data: {
            feePlanId: feePlanId
        },
        success: function (response) {
            $("#FeePlandetailEditModal").modal();
            $("#FeePlandetailEditModalBody").append(response.template)
            //  console.log(response)
        },
        error: function (error) {
            // console.log(error);
        },
    });
}
