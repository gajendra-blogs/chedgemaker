// change offline fee status registration
$(document).ready(function(){
//$("#changeStatus").on("change", function (e) {
    $('.changeStatus').on('change',function(){
        var $el = $(this).closest('tr');
    var newStatus = $(this).val();
    console.log("offline pay");
    var url = $("#newStatusUpdateUrl").val();
    var paymentid = $el.find(".statustokenPageId").val();
    var studentRegistrationId = $("#studentRegistrationId").val();
    // console.log(newStatus);
    // console.log(url);
    // console.log(id);
    // console.log($el);
    $.ajax({
        url: url,
        method: "POST",
        data: {
            newStatus: newStatus,
            id:paymentid,
            studentRegistrationId: studentRegistrationId
        },
        success: function (response) {
           swal(
            response.type +'!',
            response.message,
            response.type,
        )},
        error: function (error) {
            swal(
                'Failed!',
                error.message,
                'warning',
            );
        },
    });
  });
});


// add discount for registration
$("#discountAddBtn").on("click", function (e) {
    console.log("hello");
    var newDiscount = $("#newDiscount").val();
    var url = $("#newDiscountUpdateUrl").val();
    var id = $("#tokenPageId").val();
    console.log(newDiscount);
    console.log(url);
    console.log(id);
    if (newDiscount != " " && newDiscount>=0) {
    
    $.ajax({
        url: url,
        method: "POST",
        data: {
            newDiscount: newDiscount,
            id:id
        },
        success: function (response) {
          
           swal(
            response.type +'!',
            response.message,
            response.type,
        );
           
        },
        error: function (error) {
            swal(
                'Failed!',
                error.message,
                'warning',
            );
        },
    });
    }else{
        $('#newDiscountError').empty();
        $('#newDiscountError').append('Please Enter Valid Discount.')
    }
});

function approveDiscount(id) {
    console.log('hello2')
    var url = $("#approvedDiscountUrl").val();

    $.ajax({
        url: url,
        method: "POST",
        data: {
            id: id,
        },
        success: function (response) {
          
            swal(
             response.type +'!',
             response.message,
             response.type,
         );
           window.location.href="" 
         },
         error: function (error) {
             swal(
                 'Failed!',
                 error.message,
                 'warning',
             );
         },
    });
}

function CencelDiscount(id) {
    console.log('hello2')
    var url = $("#cencelDiscountUrl").val();

    $.ajax({
        url: url,
        method: "POST",
        data: {
            id: id,
        },
        success: function (response) {
          
            swal(
             response.type +'!',
             response.message,
             response.type,
         );
        //  setTimeout(()=>{
            window.location.href="";
        //  },3000)
         },
         error: function (error) {
             swal(
                 'Failed!',
                 error.message,
                 'warning',
             );
         },
    });
}

// add fee installment
$("#studentInstallmentShow_btn").on("click", function (e) {
    console.log("hello");
    var totalFee = $("#TotalPayableFeeStudent").val();
    var totalInstallments = $("#totalStudentsInstallments").val();
    var downPayment = $("#DownPayment").val();
    $("#installmentsCountFormGroupError").empty();
    $("#downPaymentFormGroupError").empty();
    
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
    
    
    $("#otherStudentInstallmentsDiv").empty();


    for (let i = 0; i < totalInstallments; i++) {
        $("#otherStudentInstallmentsDiv")
            .append(`<div class="row"><div class="form-group col-6" id="InstallmentAmountFormGroup${i+1}">
          <label class="control-label col" for="number"><strong> Installment ${i + 1
                }:</strong></label>
          <div class="col">
          <input type="number" class="form-control input-solid" min="0" id="Installment${i + 1
                }" name="Installment${i+1}">
          </div>
          </div>
          <div class="form-group col-6" id="InstallmentTimeFormGroup${i+1}">
          <label class="control-label col" for="number"><strong> Due Time for Installment ${i + 1
                } (Days):</strong></label>
          <div class="col">
          <input type="number" class="form-control input-solid" min="0" id="dueInstallment${i + 1
                }" name="dueInstallment${i+1}">
          </div>
          </div>
          </div>`);
    }
    // $("#installmentShow_btn").addClass("d-none");
});


$("#student-fee-plan-form").submit(function(e){
    e.preventDefault();
    var url = $(this).attr('action');
    var totalFee = $("#TotalPayableFeeStudent").val();
    var totalInstallments = $("#totalStudentsInstallments").val();
    var downPayment = $("#DownPayment").val();
    $("#installmentsCountFormGroupError").empty();
    $("#downPaymentFormGroupError").empty();
    
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
    
    var totalPayableFee=Number(totalFee);
    var installmentTotal=Number(downPayment);
    var totalInstallmentsCount= Number(totalInstallments)+1;

    for (let i = 1; i < totalInstallmentsCount; i++) {
    $("#InstallmentAmountFormGroupError"+i).empty();
    $("#InstallmentTimeFormGroupError"+i).empty();

        var installmentAmount=$('#Installment'+i).val();
        var installmentduetime=$('#dueInstallment'+i).val();
       
        if (installmentAmount=='') {
            $("#InstallmentAmountFormGroup"+i).append(
                '<p class="text-danger" id="InstallmentAmountFormGroupError'+i+'">Please Enter Amount</p>'
            );
            return false;
            break;
        }
        if (installmentduetime=='') {
            $("#InstallmentTimeFormGroup"+i).append(
                '<p class="text-danger" id="InstallmentTimeFormGroupError'+i+'">Please Enter Due Time</p>'
            );
            return false;
            break;
        }
        if (Number(installmentAmount)!=NaN) {
            installmentTotal += Number(installmentAmount);
        }
        console.log(installmentTotal);
    }
    
    if (totalPayableFee == installmentTotal) {
    $.ajax({
        url: url,
        method: "POST",
        data:$(this).serialize(),
        success: function (response) {
       
            swal(
             response.type +'!',
             response.message,
             response.type,
         );
       
            window.location.href="";
       
         },
         error: function (error) {
            
             swal(
                 'Failed!',
                 error.message,
                 'warning',
             );
         },
    });
}else{
    $("#student-fee-plan-form-errors").empty();
    $("#student-fee-plan-form-errors").append(
        '<p class="text-danger"><strong>Sum Of Installments and total payable amount mismatch</strong></p>'
    );
    return false;
}
});

