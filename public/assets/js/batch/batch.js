
$(document).ready(function () {
    appySorting();
    $('#center_id').select2({
        minimumSelectionLength: 1,
        placeholder: 'Please Select Courses',
	});
    $(document).on('click' , '#add-btn-batch' , function(){
        $('#batch-form').trigger('reset');
        $('#edit').empty();
        $('#add').css('display' , 'block');
    })

    $('#batch-form').validate({
        rules: {
            center_id: {
                required: true
            },
            course_id: {
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
            center_id: {
                required: 'Please Select Center Name'
            },
            course_id: {
                required: 'Please Select Course Name'
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
                        $('#batch-form').trigger("reset");
                        $('#AddUpdateModel').modal('hide');
                        // $(`#center-div${response.center}`).find('.courses-div').empty();
                        $(`#center-div${response.center}`).find('.courses-div').append(response.template);
                        createSuccessNotification(response.message);
                    }
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
                },
                complete: function(){
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
                updateBatch(rowCount);
                hideLoading();
            }
        })
    });
});

//Update Fee head
function updateBatch(rowCount){
    $('form#batch-form-edit').validate({
        rules: {
            center_id: {
                required: true
            },
            course_id: {
                required: true
            },
            batch_name: {
                required: true
            },
            batch_duration: {
                required: true
            },
            batch_start: {
                required: true
            },
            batch_end: {
                required: true
            },
            batch_time: {
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
            center_id: {
                required: 'Please Select Center Name'
            },
            course_id: {
                required: 'Please Select Course Name'
            },
            batch_name: {
                required: 'Please Enter Batch Name'
            },
            batch_duration: {
                required: 'Please Enter Batch Days'
            },
            batch_start: {
                required: 'Please Choose Start Date'
            },
            batch_end: {
                required: 'Please Choose End Date'
            },
            batch_time: {
                required: 'Please Enter Batch Time'
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
                        $('#course-form').trigger("reset");
                        $('#AddUpdateModel').modal('hide');
                        $('#success-message').append(response.message);
                        $('#success-div').css('display' , 'block');
                        $(`#batch-table tbody tr:nth-child(${rowCount})`).after(response.template)
                        $(`#batch-table tbody tr:nth-child(${rowCount})`).remove();
                        createSuccessNotification(response.message);
                        hideLoading();
                    }
                },
                error: function(error){
                    var errorResponse = JSON.parse(error.responseText);
                    var errors = errorResponse.errors;
                    for (const key in errors) {
                        console.log(errors[key])
                        errors[key].forEach(element => {
                            createErrorMeesage(element , $(`form#batch-form-edit #${key}`) , key);
                        });
                    }
                    hideLoading();
                }
            })
        }
    });
}

