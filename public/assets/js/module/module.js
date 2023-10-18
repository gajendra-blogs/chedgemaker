$(document).ready(function () {
    appySorting();
    $(document).on('click', '#add-couse', function () {
        $('#module-form').trigger('reset');
        $('#edit').empty();
        $('#add').css('display', 'block');
    })

    $('#module-form').validate({
        rules: {
            name: {
                required: true
            },
            description: {
                required: true
            },
            duration: {
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
            name: {
                required: 'Please Enter Module Name'
            },
            description: {
                required: 'Please Enter Module Description'
            },
            duration: {
                required: 'Please Enter Module Duration',
                digits: 'Please Enter Valid Number of day'
            }
        },
        submitHandler: function (form) {
            showLoading();
            var url = $(form).attr('data-href');
            var method = $(form).attr('method');
            $.ajax({
                url: url,
                type: method,
                dataType: 'json',
                data: $(form).serialize(),
                success: function (response) {
                    if (response.success == true) {
                        $('#module-form').trigger("reset");
                        $('#AddUpdateModel').modal('hide');
                        if (response.total_record == '1') {
                            $("#module-table").find("tbody tr:first").before(response.template);
                            $("#module-table").find("tbody tr:first").next().remove();
                        }
                        else {
                            $("#module-table").find("tbody tr:first").before(response.template);
                        }
                        $('#success-message').append(response.message);
                        $('#success-div').css('display', 'block');
                        $.each($('#module-table tbody tr a.edit'), function (index, item) {
                            $(item).attr('data-row', index + 1);
                            console.log($(item).attr('data-row'))
                        });
                        createSuccessNotification(response.message);
                    }
                },
                error: function (error) {
                    var errorResponse = JSON.parse(error.responseText);
                    var errors = errorResponse.errors;
                    for (const key in errors) {
                        console.log(errors[key])
                        errors[key].forEach(element => {
                            createErrorMeesage(element, $(`#${key}`), key);
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
    $(document).on('click', '.edit', function (e) {
        e.preventDefault();
        showLoading();
        var dataUrl = $(this).attr('data-href');
        var rowCount = $(this).attr('data-row');
        $.ajax({
            url: dataUrl,
            type: 'GET',
            success: function (response) {
                $('#add').css('display', 'none');
                $('#edit').empty();
                $('#edit').append(response);
                $('#AddUpdateModel').modal('show');
                $('.row-count').val(rowCount);
                updateModule(rowCount);
            },
            complete: function(){
                hideLoading();
            }
        })
    })

   

})


//Update Fee head
function updateModule(rowCount) {
    $('form#module-form-edit').validate({
        rules: {
            name: {
                required: true
            },
            description: {
                required: true
            },
            duration: {
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
            name: {
                required: 'Please Enter Module Name'
            },
            description: {
                required: 'Please Enter Module Description'
            },
            duration: {
                required: 'Please Enter Module Duration',
                digits: 'Please Enter Valid Number of day'
            }
        },
        submitHandler: function (form) {
            var url = $(form).attr('data-href');
            var method = $(form).attr('method');
            showLoading();
            $.ajax({
                url: url,
                type: method,
                dataType: 'json',
                data: $(form).serialize(),
                success: function (response) {
                    if (response.success == true) {
                        $('#module-form').trigger("reset");
                        $('#AddUpdateModel').modal('hide');
                        $('#success-message').append(response.message);
                        $('#success-div').css('display', 'block');
                        $(`#module-table tbody tr:nth-child(${rowCount})`).after(response.template)
                        $(`#module-table tbody tr:nth-child(${rowCount})`).remove();
                        createSuccessNotification(response.message);
                    }
                },
                error: function (error) {
                    var errorResponse = JSON.parse(error.responseText);
                    var errors = errorResponse.errors;
                    for (const key in errors) {
                        console.log(errors[key])
                        errors[key].forEach(element => {
                            createErrorMeesage(element, $(`form#module-form-edit #${key}`), key);
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
