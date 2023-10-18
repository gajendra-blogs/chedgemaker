
$(document).ready(function(){

    appySorting();

    $(document).on('click' , '#add-btn-head' , function(){
        $('#fee-head-form').trigger('reset');
        $('#edit').empty();
        $('#add').css('display' , 'block');
    })

    // validate form and saving the data by ajax
    $('#fee-head-form').validate({
        rules: {
            fee_heads_title: {
                required: true
            },
            charges_type: {
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
            fee_heads_title: {
                required: 'Please Enter Fee Head Title'
            },
            charges_type: {
                required: 'Please Select Charges Type'
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
        submitHandler: function(form)
        {
            showLoading();
            var url = $(form).attr('data-href');
            var method = $(form).attr('method');
            $.ajax({
                url: url,
                type: method,
                dataType: 'json',
                data: $(form).serialize(),
                success: function(response){
                    if (response.success == true) {
                        $('#fee-head-form').trigger("reset");
                        $('#AddUpdateModel').modal('hide');
                        if (response.total_record == '1') {
                            $("#fee-head-table").find("tbody tr:last").after(response.template);
                            $("#fee-head-table").find("tbody tr:last").prev().remove();
                        }
                        else
                        {
                            $("#fee-head-table").find("tbody tr:last").after(response.template);
                        }
                        $('#success-message').append(response.message);
                        $('#success-div').css('display' , 'block');
                        createSuccessNotification(response.message);
                        $.each($('#course-table tbody tr a.edit'), function (index, item) {
                            $(item).attr('data-row', index + 1);
                            console.log($(item).attr('data-row'))
                        });

                    }
                },
                error: function(error){
                    var errorResponse = JSON.parse(error.responseText);
                    var errors = errorResponse.errors;
                    for (const key in errors) {
                        console.log(errors[key])
                        errors[key].forEach(element => {
                            console.log(element)
                            createErrorMeesage(element , $(`#${key}`) , key);
                        });
                    }
                    hideLoading();
                },
                complete: function(){
                    hideLoading();
                }
            })
        }
    });

    // Fetch data for edit
    $(document).on('click' , '.edit' , function(e){
        e.preventDefault();
        showLoading();
        var dataUrl = $(this).attr('data-href');
        var rowCount = $(this).attr('data-row');
        $.ajax({
            url: dataUrl,
            type: 'GET',
            success: function(response){
                $('#add').css('display' , 'none');
                $('#edit').empty();
                $('#edit').append(response);
                $('#AddUpdateModel').modal('show');
                $('.row-count').val(rowCount);
                updateFeeHead(rowCount);
            },
            complete: function(){
                hideLoading();
            }
        })
    })


})

//Update Fee head
function updateFeeHead(rowCount){
    $('form#fee-head-form-edit').validate({
        rules: {
            fee_heads_title: {
                required: true
            },
            charges_type: {
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
            fee_heads_title: {
                required: 'Please Enter Fee Head Title'
            },
            charges_type: {
                required: 'Please Select Charges Type'
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
        submitHandler: function(form)
        {
            showLoading();
            var url = $(form).attr('data-href');
            var method = $(form).attr('method');
            $.ajax({
                url: url,
                type: method,
                dataType: 'json',
                data: $(form).serialize(),
                success: function(response){
                    if (response.success == true) {
                        $('#fee-head-form').trigger("reset");
                        $('#AddUpdateModel').modal('hide');
                        $(`#fee-head-table tbody tr:nth-child(${rowCount})`).after(response.template)
                        $(`#fee-head-table tbody tr:nth-child(${rowCount})`).remove();
                        createSuccessNotification(response.message);
                    }
                },
                error: function(error){
                    var errorResponse = JSON.parse(error.responseText);
                    var errors = errorResponse.errors;
                    for (const key in errors) {
                        console.log(errors[key])
                        errors[key].forEach(element => {
                            createErrorMeesage(element , $(`form#fee-head-form-edit #${key}`) , key);
                        });
                    }
                    hideLoading();
                },
                complete: function(){
                    hideLoading();
                }
            })
        }
    });
}
