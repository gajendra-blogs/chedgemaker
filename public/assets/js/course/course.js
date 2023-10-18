$(document).ready(function () {
    appySorting();
    $(document).on('click', '#add-couse', function () {
        $('#course-form').trigger('reset');
        $('#edit').empty();
        $('#add').css('display', 'block');
    })

    $('#course-form').validate({
        rules: {
            course_name: {
                required: true
            },
            course_description: {
                required: true
            },
            course_duration: {
                required: true,
                digits: true
            },
            status: {
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
            course_name: {
                required: 'Please Enter Course Name'
            },
            course_description: {
                required: 'Please Enter Course Description'
            },
            course_duration: {
                required: 'Please Enter Course Duration',
                digits: 'Please Enter Valid Number of day'
            },
            status: {
                required: 'Please Select Status'
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
                        $('#course-form').trigger("reset");
                        $('#AddUpdateModel').modal('hide');
                        if (response.total_record == '1') {
                            $("#course-table").find("tbody tr:first").before(response.template);
                            $("#course-table").find("tbody tr:first").next().remove();
                        }
                        else {
                            $("#course-table").find("tbody tr:first").before(response.template);
                        }
                        $('#success-message').append(response.message);
                        $('#success-div').css('display', 'block');
                        $.each($('#course-table tbody tr a.edit'), function (index, item) {
                            $(item).attr('data-row', index + 1);
                            console.log($(item).attr('data-row'))
                        });
                        createSuccessNotification(response.message);
                        hideLoading();
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
                updateCourse(rowCount);
            },
            complete: function(){
                hideLoading();
            }
        })
    })

   

})

function createErrorMeesage(msg, targetedElement, key) {
    var message = `<span id="${key}-error" class="error invalid-feedback" style="display: block;">${msg}</span>`;
    targetedElement.after(message);
    $(targetedElement).addClass('is-invalid');
}

//Update Course
function updateCourse(rowCount) {
    $('form#course-form-edit').validate({
        rules: {
            course_name: {
                required: true
            },
            course_description: {
                required: true
            },
            course_duration: {
                required: true,
                digits: true
            },
            status: {
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
            course_name: {
                required: 'Please Enter Course Name'
            },
            course_description: {
                required: 'Please Enter Course Description'
            },
            course_duration: {
                required: 'Please Enter Course Duration',
                digits: 'Please Enter Valid Number of day'
            },
            status: {
                required: 'Please Select Status'
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
                        $('#course-form').trigger("reset");
                        $('#AddUpdateModel').modal('hide');
                        $('#success-message').append(response.message);
                        $('#success-div').css('display', 'block');
                        $(`#course-table tbody tr:nth-child(${rowCount})`).after(response.template)
                        $(`#course-table tbody tr:nth-child(${rowCount})`).remove();
                        createSuccessNotification(response.message);
                    }
                },
                error: function (error) {
                    var errorResponse = JSON.parse(error.responseText);
                    var errors = errorResponse.errors;
                    for (const key in errors) {
                        console.log(errors[key])
                        errors[key].forEach(element => {
                            createErrorMeesage(element, $(`form#course-form-edit #${key}`), key);
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
