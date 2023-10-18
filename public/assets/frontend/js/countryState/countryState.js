$(() => {
    $.ajax({
        url: $("#studentRegForm").attr('data-href'),
        method: "GET",
        data: {
            countryId: $("#country").val()
        },
        success: function (resp) {
            var resp = JSON.parse(resp);
            var states = resp.states;
            console.log(states);
            $("#state").empty();
            $("#state").html('<option value="#">Select State</option>');
            states.forEach(state => {
                $("#states").append(`<option value="${state.id}">${state.name}</option>`);
            });

            // console.log(resp);
        },
        error: function (error) {
            console.log(error);
        }
    });
    $("#country").on('change', function () {


        $.ajax({
            url: $("#studentRegForm").attr('data-href'),
            method: "GET",
            data: {
                countryId: $("#country").val()
            },
            success: function (resp) {
                var resp = JSON.parse(resp);
                var states = resp.states;
                console.log(states);
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
                console.log(cities);
                $("#cities").empty();
                $("#cities").html('<option value="">Select City</option>');
                cities.forEach(city => {
                    $("#cities").append(`<option value="${city.id}">${city.city}</option>`);
                });

                // console.log(resp);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
});
