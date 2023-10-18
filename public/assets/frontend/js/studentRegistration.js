$(() => {
    $('#academicInformation').hide();
    if ($("#studentRegForm").length > 0) {
        $("#studentRegForm").validate({
            rules: {
                first_name: {
                    required: true,
                    maxlength: 50
                },
                email: {
                    required: true,
                    maxlength: 50
                },
                phone: {
                    required: true,
                    maxlength: 50
                },
                country: {
                    required: true,
                    maxlength: 50
                },
                state: {
                    required: true,
                    maxlength: 50
                },
                city: {
                    required: true,
                    maxlength: 50
                },
                centers: {
                    required: true
                },
                courses: {
                    required: true
                },
                paymentType: {
                    required: true
                },
                password: {
                    required: true,
                    minlength: 5
                },
                confirmPassword: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
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
                    required: "Please enter first name",
                },
                state: {
                    required: "Please select state",
                },
                city: {
                    required: "Please select city",
                },
                courses: {
                    required: "Please select Course",
                },
                centers: {
                    required: "Please select Center",
                },
                paymentType: {
                    required: "Please select Payment Type",
                },
                password: {
                    required: "please enter password to create"
                },
                confirmPassword: {
                    required: "confirm your password"
                }


            },
        })
    }

    $("#centers").on('change', function () {


        $.ajax({
            url: $("#GetCoursesUrl").attr('data-href'),
            method: "GET",
            data: {
                centerId: $("#centers").val()
            },
            success: function (resp) {
                // console.log(resp);
                $("#courses").html('<option value="#">Select Course</option>');
                resp.courses.forEach(course => {
                    $("#courses").append(`<option value="${course.course_id}">${course.course_name}</option>`);
                });

            },
            error: function (error) {
                console.log(error);
            }
        });
    });
    $("#courses").on('change', function () {
        // alert($("#courses").val());
        $.ajax({
            url: $("#getCourse").attr('data-href'),
            method: "GET",
            data: {
                // centerId: $("#centers").val(),
                courseId: $("#courses").val(),
            },
            success: function (resp) {
                // console.log(resp);
                $("#courseDescription").empty();
                $("#paymentTypeDiv").removeClass('d-none')
                $("#courseDescription").append(`
                <h1>Course content</h1>
                <h2>${resp.courses[0].course_name}</h2>
                <p>${resp.courses[0].course_description}</p>
                <p><b>Duration :</b>${resp.courses[0].course_duration} Days</p>
                 `)
                // var resp = JSON.parse(resp);
                // $("#feePlanDetails").empty();
                // $("#feePlanDetails").append(resp.template);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });


    $("#paymentType").change(function () {
        if ($("#paymentType").val() == 'null') {
            $("#feePlanDetails").empty();
            return false;
        }
        $.ajax({
            url: $("#GetFeePlanUrl").attr('data-href'),
            method: "GET",
            data: {
                centerId: $("#centers").val(),
                courseId: $("#courses").val(),
                feePlanType: $("#paymentType").val()
            },
            success: function (resp) {
                // console.log(resp);
                var resp = JSON.parse(resp);
                $("#feePlanDetails").empty();
                $("#feePlanDetails").append(resp.template);
            },
            error: function (error) {
                console.log(error);
            }
        });
    })


});


var clickEvent = document.querySelector('.showAcademicForm');

clickEvent.addEventListener('click', () => {
    $('#academicInformation').toggle('fast');
});

$(document).ready(function () {
    $("#12_icon_cancle").hide();
    $("#10_th_icon_cancle").hide();
    $("#graduation_icon_cancle").hide();
    $("#postGraduation_icon_cancle").hide();
    //*************************12 th image preview *****************************//
    $('#12_th_marksheet_File').change(function (e) {
        var fileName = e.currentTarget.value;
        fileName = fileName.replace(/C:\\fakepath\\/i, '');
        $("#12_th_marksheet_File_preview").html(fileName);
        $("#12_icon_cancle").show();
    });
    $("#12_icon_cancle").click(() => {
        $("#12_th_marksheet_File").val('');
        $("#12_th_marksheet_File_preview").html('');
        $("#12_icon_cancle").hide();
    });


    //*************************10 th image preview *****************************//
    $('#10_th_marksheet_file').change(function (e) {
        var fileName = e.currentTarget.value;
        fileName = fileName.replace(/C:\\fakepath\\/i, '');
        console.log(fileName);
        $("#10_th_marksheet_File_preview").html(fileName);
        $("#10_th_icon_cancle").show();
    });
    $("#10_th_icon_cancle").click(() => {
        $("#10_th_marksheet_File").val('');
        $("#10_th_marksheet_File_preview").html('');
        $("#10_th_icon_cancle").hide();
    });



    //*************************graduation image preview *****************************//
    $('#graduation_file').change(function (e) {
        var fileName = e.currentTarget.value;
        fileName = fileName.replace(/C:\\fakepath\\/i, '');
        $("#graduation_marksheet_File_preview").html(fileName);
        $("#graduation_icon_cancle").show();
    });
    $("#graduation_icon_cancle").click(() => {
        $("#graduation_file").val('');
        $("#graduation_marksheet_File_preview").html('');
        $("#graduation_icon_cancle").hide();
    });



    //*************************postGraduation image preview *****************************//

    $('#post_graduation_file').change(function (e) {
        var fileName = e.currentTarget.value;
        fileName = fileName.replace(/C:\\fakepath\\/i, '');
        $("#postGraduation_marksheet_File_preview").html(fileName);
        $("#postGraduation_icon_cancle").show();
    });
    $("#postGraduation_icon_cancle").click(() => {
        $("#post_graduation_file").val('');
        $("#postGraduation_marksheet_File_preview").html('');
        $("#postGraduation_icon_cancle").hide();
    });
});
