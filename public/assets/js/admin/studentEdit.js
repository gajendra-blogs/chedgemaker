$(document).ready(function(){
    $(document).on('click', '.edit', function (e) {
        e.preventDefault();
        showLoading();
        var dataUrl = $(this).attr('href');
        var rowCount = $(this).attr('data-row');
        $.ajax({
            url: dataUrl,
            type: 'GET',
            success: function (response) {
                $('#add').css('display', 'none');
                $('#edit').empty();
                $('#edit').append(response);
                $('#StudentEditModal').modal('show');
                $('#rowCount').val(rowCount);
                update(rowCount);
            },
            complete: function(){
                hideLoading();
            }
        })
    });

})

//Update Fee head
function update(rowCount) {
    $('form#update10').validate({
        // rules: {
        //     course_name: {
        //         required: true
        //     },
        //     course_description: {
        //         required: true
        //     },
        //     course_duration: {
        //         required: true,
        //         digits: true
        //     },
        //     status: {
        //         required: true
        //     }
        // },
        // errorElement: 'span',
        // errorPlacement: function (error, element) {
        //     error.addClass('invalid-feedback');
        //     element.closest('.form-group').append(error);
        // },
        // highlight: function (element, errorClass, validClass) {
        //     $(element).addClass('is-invalid');
        // },
        // unhighlight: function (element, errorClass, validClass) {
        //     $(element).removeClass('is-invalid');
        // },
        // messages: {
        //     course_name: {
        //         required: 'Please Enter Course Name'
        //     },
        //     course_description: {
        //         required: 'Please Enter Course Description'
        //     },
        //     course_duration: {
        //         required: 'Please Enter Course Duration',
        //         digits: 'Please Enter Valid Number of day'
        //     },
        //     status: {
        //         required: 'Please Select Status'
        //     }
        // },
        submitHandler: function (form) {
            showLoading();
            var url = $(form).attr('action');
            var method = $(form).attr('method');
            $.ajax({
                url: url,
                type: method,
                processData: false,
                async: false,
                data: $(form).serialize(),
                success: function (response) {
                    if (response.success == true) {
                        $('#update10').trigger("reset");
                        $('#StudentEditModal').modal('hide');
                        $(`#academic-table tbody tr:nth-child(${rowCount})`).after(response.template)
                        $(`#academic-table tbody tr:nth-child(${rowCount})`).remove();
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
