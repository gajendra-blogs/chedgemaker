$(document).ready(function () {
    appySorting();

    $(document).on('click' , '#add-btn-center' , function(){
        $('#center-form').trigger('reset');
        $('#edit').empty();
        $('#add').css('display' , 'block');
    })

    $('#center-form').validate({
        rules: {
            center_name: {
                required: true
            },
            center_location: {
                required: true
            },
            center_email: {
                required: true,
                email: true
            },
            contact_number: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10
                },
                contact_person: {
                    required: true
                },
                center_code:{
                    required : true 
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
            center_name: {
                required: 'Please Enter Center Name'
            },
            center_location: {
                required: 'Please Enter Center Location'
            },
            center_email: {
                required: 'Please Enter Center Email'
            },
            contact_number: {
                required: 'Please Enter Contact Person'
            }
        },
        submitHandler: function(form){
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
                        $('#center-form').trigger("reset");
                        $('#AddUpdateModel').modal('hide');
                        if (response.total_record == '1') {
                            $("#center-table").find("tbody tr:first").before(response.template);
                            $("#center-table").find("tbody tr:first").next().remove();
                        }
                        else
                        {
                            $("#center-table").find("tbody tr:first").before(response.template);
                        }
                        $('#success-message').append(response.message);
                        createSuccessNotification(response.message);
                        $.each($('#center-table tbody tr a.edit'), function (index, item) {
                            $(item).attr('data-row', index+1);
                            console.log($(item).attr('data-row'))
                        });
                    }
                    hideLoading();
                },
                error: function(error){
                    var errorResponse = JSON.parse(error.responseText);
                    var errors = errorResponse.errors;
                    for (const key in errors) {
                        console.log(errors[key])
                        errors[key].forEach(element => {
                            createErrorMeesage(element , $(`#${key}`) , key);
                        });
                    }
                    hideLoading();
                }
            })
        }
    });
    // Fetch data for edit
    $(document).on('click' , 'a.edit' , function(e){
        e.preventDefault();
        showLoading();
        var dataUrl = $(this).attr('href');
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
                updateCenter(rowCount);
                hideLoading();
            }
        })
    });
});


//Update Fee head
function updateCenter(rowCount){
    $('form#center-form-edit').validate({
        rules: {
            center_name: {
                required: true
            },
            center_location: {
                required: true
            },
            center_email: {
                required: true,
                email: true
            },
            contact_number: {
                required: true,
                number: true,
                minlength: 10,
                maxlength: 10
                },
                contact_person: {
                    required: true
                },
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
            center_name: {
                required: 'Please Enter Center Name'
            },
            center_location: {
                required: 'Please Enter Center Location'
            },
            center_email: {
                required: 'Please Enter Center Email'
            },
            contact_person: {
                required: 'Please Enter Contact Person'
            }
        },
        submitHandler: function(form)
        {
            var url = $(form).attr('data-href');
            var method = $(form).attr('method');
            showLoading();
            $.ajax({
                url: url,
                type: method,
                dataType: 'json',
                data: $(form).serialize(),
                success: function(response){
                    if (response.success == true) {
                        $('#course-form').trigger("reset");
                        $('#AddUpdateModel').modal('hide');
                        $('#success-message').append(response.message);
                        $('#success-div').css('display' , 'block');
                        $(`#center-table tbody tr:nth-child(${rowCount})`).after(response.template)
                        $(`#center-table tbody tr:nth-child(${rowCount})`).remove();
                        createSuccessNotification(response.message)
                        hideLoading();
                    }
                },
                error: function(error){
                    var errorResponse = JSON.parse(error.responseText);
                    var errors = errorResponse.errors;
                    for (const key in errors) {
                        console.log(errors[key])
                        errors[key].forEach(element => {
                            createErrorMeesage(element , $(`form#center-form-edit #${key}`) , key);
                        });
                    }
                    hideLoading();
                }
            })
        }
    });
}


