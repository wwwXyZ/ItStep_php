function check_login(login) {
    $.ajax({
        type: "GET",
        url: "/api/user_check_params_exist/login/" + login,
        success: function (msg) {
            if (msg.exist) {
                $(".input_error[name='login']").text('Логин занят!');
                $(".input_field[name='login']").addClass('error')
            }
            else
                $(".input_error[name='login']").empty();
            //console.log('success');
        }
    });
}
function compare_passwords(pass, rePass) {
    if (pass.length < 6)
        $(".input_error[name='password']").text('Короткий пароль!');
    if (rePass.length < 6)
        $(".input_error[name='rePassword']").text('Короткий пароль!');
    if (pass != rePass)
        $(".input_error[name='rePassword']").text('Парли не совпадают!');
    else{
        $(".input_error[name='rePassword']").empty();
        $(".input_error[name='password']").empty();
    }
}
function isValidDate(year, month, day) {
    //console.log(year + " " + month + " " + day);
    --month;
    var d = new Date(year, month, day);
    if (d.getFullYear() == year && d.getMonth() == month && d.getDate() == day) {
        return true;
    }
    return false;
}
function checkDate() {
    if (!isValidDate($(".birth_year").val(), $(".birth_month").val(), $(".birth_day").val()))
        $(".input_error[name='birthday']").text('Неверная дата!');
    else
        $(".input_error[name='birthday']").empty();
}
function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (re.test(email)) {
        $(".input_error[name='email']").empty();
        $.ajax({
            type: "GET",
            url: "/api/user_check_params_exist/email/" + email,
            success: function (msg) {
                if (msg.exist)
                    $(".input_error[name='email']").text('Владелец этого адреса уже зарегистрирован!');
                else
                    $(".input_error[name='login']").empty();
                //console.log('success');
            }
        });
    }
    else
        $(".input_error[name='email']").text('Некорректный e-mail!');
}

function updateRegions(id) {
    $.ajax({
        type: "GET",
        url: "/api/get_regions_by_country/" + id,
        success: function (msg) {
            $('#region_list').empty();
            $('#city_list').empty();
            $("#region").val('');
            for (key in msg.regions) {
                regionOption = "<option data-value='" + key + "'>" + msg.regions[key] + "</option>";
                $('#region_list').append(regionOption);
            }
            document.querySelector('#region').addEventListener('input', fixGeoNameRegions);
        }
    });
}

function updateCities(id) {
    $.ajax({
        type: "GET",
        url: "/api/get_cities_by_region/" + id,
        success: function (msg) {
            $('#city_list').empty();
            $("#city").val('');
            for (key in msg.cities) {
                cityOption = "<option data-value='" + key + "'>" + msg.cities[key] + "</option>";
                $('#city_list').append(cityOption);
            }
            document.querySelector('#city').addEventListener('input', fixGeoName);
        }
    });
}

function fixGeoName(e) {
    var input = e.target,
        list = input.getAttribute('list'),
        options = document.querySelectorAll('#' + list + ' option'),
        hiddenInput = document.getElementById(input.id + '-hidden'),
        inputValue = input.value,
        isExist = false;

    hiddenInput.value = inputValue;

    for (var i = 0; i < options.length; i++) {
        var option = options[i];

        if (option.innerText === inputValue) {
            hiddenInput.value = option.getAttribute('data-value');
            isExist = true;
            break;
        }

    }
    if (!isExist)
        input.value = '';
}
function fixGeoNameCountry(e) {
    fixGeoName(e);
    updateRegions($("#country-hidden").val());
}
function fixGeoNameRegions(e) {
    fixGeoName(e);
    updateCities($("#region-hidden").val());
}

$(function () {
    var pass = '';
    var rePass = '';
    $(".input_field[name='login']").on('change', function () {
        check_login(this.value);
    })
    $(".input_field[name='password']").on('change', function () {
        pass = this.value;
        compare_passwords(pass, rePass);
    })
    $(".input_field[name='rePassword']").on('change', function () {
        rePass = this.value;
        compare_passwords(pass, rePass);
    })
    $(".input_field[name='email']").on('change', function () {
        validateEmail(this.value);
    })

    document.querySelector('#country').addEventListener('input', fixGeoNameCountry);
    document.querySelector(".birth_day").addEventListener('input', checkDate);
    document.querySelector(".birth_month").addEventListener('input', checkDate);
    document.querySelector(".birth_year").addEventListener('input', checkDate);

    $("#registration_form").validate({
        submitHandler: function (form) {

            $.ajax({

                type: "POST",
                url: "/user/registration",
                data: $(form).serialize(),
                beforeSend: function () {

                    sLoader.fadeIn();

                },
                success: function (msg) {
                    console.log(msg);
                    /*
                     // Message was sent
                     if (msg == 'OK') {
                     location.reload();
                     sLoader.fadeOut();
                     $('#message-warning').hide();
                     $('#addProductForm').fadeOut();
                     $('#message-success').fadeIn();
                     }
                     // There was an error
                     else {
                     sLoader.fadeOut();
                     $('#message-warning').html(msg);
                     $('#message-warning').fadeIn();
                     }
                     */
                },
                error: function () {

                    sLoader.fadeOut();
                    $('#message-warning').html("Something went wrong. Please try again.");
                    $('#message-warning').fadeIn();

                }
            });
        }
    });

});