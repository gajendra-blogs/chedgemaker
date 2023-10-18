$(document).ready(function () {

    $(document).on('click', 'a.edit', function (e) {
        e.preventDefault();
        showLoading();
        var dataUrl = $(this).attr('href');
        var section = $(this).attr('data-section');
        console.log(section)
        $.ajax({
            url: dataUrl,
            type: 'GET',
            success: function (response) {
                if (section == 'academic') {
                    $('#add-academic').hide();
                    $('#edit-academic').empty().append(response);
                    $('#AddAcademicModal').modal('show');
                    updateAcademic();
                } else {
                    $('#edit').empty();
                    $('#edit').append(response);
                    if (section == 'address') {
                        countryState();
                    }
                    $('#StudentEditModel').modal('show');
                    $('#birthday').datepicker({
                        maxDate: new Date()
                    });
                    if (section == 'details') {
                        updateDetails();
                    }
                    if (section == 'address') {
                        updateAddress();
                    }
                }
            },
            complete: function () {
                hideLoading();
            }
        })
    });

    $('form#academic-form').validate({
        rules: {
            qualification: {
                required: true
            },
            institute: {
                required: true
            },
            university: {
                required: true
            },
            passout_year: {
                required: true,
                digits: true,
                maxlength: 4,
                minlength: 4
            },
            marks: {
                required: true,
                digits: true
            },
            place: {
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
            qualification: {
                required: 'Please Select Qualification'
            },
            institute: {
                required: 'Please Enter Institute'
            },
            university: {
                required: 'Please Enter University'
            },
            passout_year: {
                required: 'Please Enter Passout Year',
                digits: 'Please Enter Valid Year',
                maxlength: 'Enter Valid Passout Year',
                minlength: 'Enter Valid Passout Year'
            },
            marks: {
                required: 'Please Enter Marks',
                digits: 'Please Enter Valid Marks',
            },
            place: {
                required: 'Please Enter Place'
            }
        },
        submitHandler: function (form) {
            var url = $(form).attr('action');
            showLoading();
            $.ajax({
                url: url,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                data: new FormData(form),
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.success === true) {
                        $('#academic-section').append(response.template);
                        $('#academic-form').trigger('reset');
                        $('#AddAcademicModal').modal('hide');
                        createSuccessNotification(response.message);
                    }
                },
                error: function (error) {
                    var errorResponse = JSON.parse(error.responseText);
                    var errors = errorResponse.errors;
                    for (const key in errors) {
                        console.log(errors[key])
                        errors[key].forEach(element => {
                            createErrorMeesage(element, $(`form#academic-forma#${key}`), key);
                        });
                    }
                    hideLoading();
                },
                complete: function () {
                    hideLoading()
                }
            })

        }
    })

})

function updateDetails() {
    $('form#update-detials-form').validate({
        rules: {
            first_name: {
                required: true
            },
            last_name: {
                required: true
            },
            birthday: {
                required: true
            },
            phone: {
                required: true,
                digits: true,
                maxlength: 10,
                minlength: 10
            },
            father_name: {
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
            first_name: {
                required: 'Please Enter First Name'
            },
            last_name: {
                required: 'Please Enter Last Name'
            },
            birthday: {
                required: 'Please Enter Your birth day'
            },
            phone: {
                required: 'Please Enter Phone',
                digits: 'Please Enter valid Phone Number',
                maxlength: 'Please Enter valid Phone Number',
                minlength: 'Please Enter valid Phone Number'
            },
            father_name: {
                required: 'Please Enter Father Name'
            }
        },
        submitHandler: function (form) {
            showLoading();
            var url = $(form).attr('action');
            var method = $(form).attr('method');
            $.ajax({
                url: url,
                type: method,
                dataType: 'json',
                data: $(form).serialize(),
                success: function (response) {
                    if (response.success == true) {
                        $('#student-detials').empty().append(response.template);
                        $('#StudentEditModel').modal('hide');
                        $('#edit').empty();
                        hideLoading();
                        $('#avtar-text').empty().text(`${response.user.first_name} ${response.user.last_name}`)
                        createSuccessNotification(response.message);
                    }
                },
                error: function (error) {
                    var errorResponse = JSON.parse(error.responseText);
                    var errors = errorResponse.errors;
                    for (const key in errors) {
                        console.log(errors[key])
                        errors[key].forEach(element => {
                            createErrorMeesage(element, $(`form#update-detials-form #${key}`), key);
                        });
                    }
                    hideLoading();
                }
            })
        }
    });
}

function updateAddress(section) {
    $(`form#update-address-form`).validate({
        rules: {
            address1: {
                required: true
            },
            country: {
                required: true
            },
            state: {
                required: true
            },
            pincode: {
                required: true,
                digits: true,
                maxlength: 6,
                minlength: 6
            },
            city: {
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
            address1: {
                required: 'Please Enter Address Field 1'
            },
            country: {
                required: 'Please Select Country'
            },
            state: {
                required: 'Please Select State'
            },
            pincode: {
                required: 'Please Enter Pin Code',
                digits: 'Please Enter valid Pin Code',
                maxlength: 'Please Enter valid Pin Code',
                minlength: 'Please Enter valid Pin Code'
            },
            city: {
                required: 'Please Select City'
            }
        },
        submitHandler: function (form) {
            showLoading();
            var url = $(form).attr('action');
            var method = $(form).attr('method');
            $.ajax({
                url: url,
                type: method,
                dataType: 'json',
                data: $(form).serialize(),
                success: function (response) {
                    if (response.success == true) {
                        $(`#student-${section}`).empty().append(response.template);
                        $('#StudentEditModel').modal('hide');
                        $('#edit').empty();
                        hideLoading();
                        createSuccessNotification(response.message);
                    }
                },
                error: function (error) {
                    var errorResponse = JSON.parse(error.responseText);
                    var errors = errorResponse.errors;
                    for (const key in errors) {
                        console.log(errors[key])
                        errors[key].forEach(element => {
                            createErrorMeesage(element, $(`form#update-address-form #${key}`), key);
                        });
                    }
                    hideLoading();
                }
            })
        }
    });
}

function countryState() {
    $("#country").on('change', function () {
        $.ajax({
            url: $("#country-url").attr('data-href'),
            method: "GET",
            data: {
                countryId: $("#country").val()
            },
            success: function (resp) {
                var resp = JSON.parse(resp);
                var states = resp.states;
                $("#state").empty();
                $("#state").html('<option value="#">Select States</option>');
                states.forEach(state => {
                    $("#states").append(`<option value="${state.id}">${state.name}</option>`);
                });

                // console.log(resp);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $("#states").on('change', function () {
        $.ajax({
            url: $("#cityUrl").attr('data-href'),
            method: "GET",
            data: {
                stateId: $("#states").val()
            },
            success: function (resp) {
                var resp = JSON.parse(resp);
                var cities = resp.cities;
                $("#cities").empty();
                $("#cities").html('<option value="">Select City</option>');
                cities.forEach(city => {
                    $("#cities").append(`<option value="${city.id}">${city.city}</option>`);
                });
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
}


function updateAcademic() {
    $('form#academic-form-edit').validate({
        rules: {
            qualification: {
                required: true
            },
            institute: {
                required: true
            },
            university: {
                required: true
            },
            passout_year: {
                required: true,
                digits: true,
                maxlength: 4,
                minlength: 4
            },
            marks: {
                required: true,
                digits: true
            },
            place: {
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
            qualification: {
                required: 'Please Select Qualification'
            },
            institute: {
                required: 'Please Enter Institute'
            },
            university: {
                required: 'Please Enter University'
            },
            passout_year: {
                required: 'Please Enter Passout Year',
                digits: 'Please Enter Valid Year',
                maxlength: 'Enter Valid Passout Year',
                minlength: 'Enter Valid Passout Year'
            },
            marks: {
                required: 'Please Enter Marks',
                digits: 'Please Enter Valid Marks',
            },
            place: {
                required: 'Please Enter Place'
            }
        },
        submitHandler: function (form) {
            var url = $(form).attr('action');
            var files = $('#marksheet_file')[0].files;
            var fd = new FormData(form);
            fd.append('marksheet_file', files[0]);
            showLoading();
            $.ajax({
                url: url,
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                data: fd,
                success: function (response) {
                    response = JSON.parse(response);
                    if (response.success === true) {
                        $(`#academic-section-${response.academic.qualification}`).empty().append(response.template);
                        $('#AddAcademicModal').modal('hide');
                    }
                    createSuccessNotification(response.message);
                },
                error: function (error) {
                    var errorResponse = JSON.parse(error.responseText);
                    var errors = errorResponse.errors;
                    for (const key in errors) {
                        console.log(errors[key])
                        errors[key].forEach(element => {
                            createErrorMeesage(element, $(`form#academic-form-edit #${key}`), key);
                        });
                    }
                    hideLoading();
                },
                complete: function () {
                    hideLoading()
                }
            })

        }
    })
}
