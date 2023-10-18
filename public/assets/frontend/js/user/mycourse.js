$("#payButton").click(function (e) {
    var amountObj = {
        amount: "",
        amountType: ""
    }
    $("input[type=radio]:checked").each(function () {
        var row = $(this).closest("tr")[0];
        if (row.cells[1].innerHTML == "Other Amount") {
            var amount = document.getElementById('other_amount').value;
            if (!amount || amount < 3000) {
                $("#error").html('Please Enter amount atleast 3000');
                return false;
            } else {
                $("#error").empty();
            }
            amountObj.amount = amount;
            amountObj.amountType = row.cells[1].innerHTML;

        } else {
            amountObj.amountType = row.cells[1].innerHTML;
            amountObj.amount = row.cells[2].innerHTML;
        }

        var amount = amountObj.amount;
        var registrationId = $("#registration_id").val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "post",
            url: $("#orderIdRoute").val(),
            data: {
                amount: amount,
                registrationId: registrationId
            },
            success: function (data) {
                console.log(data)
                var order_id = '';
                if (data.order_id) {
                    order_id = data.order_id;
                }

                var options = {
                    "key": "rzp_test_S5AxOvqcyspV3y", // Enter the Key ID generated from the Dashboard
                    "amount": amount, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                    "currency": "INR",
                    "name": "CH Edge Maker",
                    "description": "dddd",
                    "image": "",
                    "order_id": order_id, //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                    "handler": function (response) {

                        $('#razorpay_payment_id').val(response.razorpay_payment_id);
                        $('#razorpay_order_id').val(response.razorpay_order_id);
                        $('#razorpay_signature').val(response.razorpay_signature);
                        $('#paymentSubmit').submit();
                    },
                    "prefill": {
                        "name": "",
                        "email": "",
                        "contact": ""
                    },
                    "notes": {
                        "address": ""
                    },
                    "theme": {
                        "color": "#3399cc"
                    }
                };
                var rzp1 = new Razorpay(options);

                rzp1.on('payment.failed', function (response) {
                    console.log(response)
                    console.log('fail')
                });
                console.log(rzp1);

                rzp1.open();


            },

        });


    });
    e.preventDefault();

    // var form = $(this);
    // var actionUrl = form.attr('action');

    // $.ajax({
    //     type: "POST",
    //     url: actionUrl,
    //     data: form.serialize(), // serializes the form's elements.
    //     success: function (data) {
    //         alert(data); // show response from the php script.
    //     }
    // });

});



$('#addAppointButton').on('click', function (e) {
    e.preventDefault();
    var amount = $('#payment').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        type: "post",
        url: "orderid-generate",
        data: $("#addPaymentForm").serialize(),
        success: function (data) {
            var order_id = '';
            if (data.order_id) {
                order_id = data.order_id;
            }

            var options = {
                "key": "{{ config('app.razorpay_api_key') }}", // Enter the Key ID generated from the Dashboard
                "amount": amount, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
                "currency": "{{ config('app.currency') }}",
                "name": "{{ config('app.account_name') }}",
                "description": remarks,
                "image": "{{ asset('images/logo-black.svg') }}",
                "order_id": order_id, //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
                "handler": function (response) {
                    $('#razorpay_payment_id').val(response.razorpay_payment_id);
                    $('#razorpay_order_id').val(response.razorpay_order_id);
                    $('#razorpay_signature').val(response.razorpay_signature);
                    $('#addPaymentForm').submit();
                },
                "prefill": {
                    "name": "{{ auth()->user()->name }}",
                    "email": "{{ auth()->user()->email }}",
                    "contact": "{{ auth()->user()->mobile }}"
                },
                "notes": {
                    "address": "Razorpay Corporate Office"
                },
                "theme": {
                    "color": "#3399cc"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.on('payment.failed', function (response) {

            });

            rzp1.open();


        },

    });

});
