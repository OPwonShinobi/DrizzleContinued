function validateregistration() {
    var has_empty = false;
    var password_n_match = false;
    var input_short = false;
    var input_long = false;
    var special_char = false;
    $('form').find('.errormessage').each(function() {
        $(this).css("display", "none");

    });
    /*empty field*/
    $('form').find('input[type!="hidden"]' ).each(function() {
        $(this).css("borderColor", "#FFFFFF");
        if(! $(this).val() ) {
            has_empty = true;
            $(this).css("borderColor", "#ff0000");
            $(this).prop("required", true);
            var errorlocation = $(this).attr("name") + "error";
            $("#" + errorlocation).css("display", "block");
            $("#" + errorlocation).text("Field empty");
        }
    });

    /*special characters in name fields*/
    $('form').find('.nospchar').each(function() {
        var pattern = new RegExp(/[~`!#$%\^&*+=\-\[\]\\;,/{}|\\":<>\?]/);
        if(pattern.test($(this).val() )) {
            special_char = true;
            $(this).css("borderColor", "#ff0000");
            $(this).prop("required", true);
            errorlocation = $(this).attr("name") + "error";
            $("#" + errorlocation).css("display", "block");
            $("#" + errorlocation).text("No Special Characters Allowed");
        }
    });



    if($('#stateId').val() == 'British Columbia') {
        /*password character restriction*/
        var pwdpattern = new RegExp(/^[ !#$%&*+\-0-9@-Z_a-z]+$/);
        if (!pwdpattern.test($('#password').val())) {
            $('#password').css("borderColor", "#ff0000");
            $("#passworderror").text("Alphanumeric and " +
                "certain special characters (_ ! # $ % & * + - @) only");
            $("#passworderror").css("display", "block");
            $('#password').prop("required", true);
            special_char = true;
        } else {
            $('#password').prop("required", false);
            special_char = false;
        }

        /*password and confirm password do not match*/
        if ($('#password').val() != $('#cpassword').val()) {
            $('#cpassword').css("borderColor", "#ff0000");
            $("#cpassworderror").text("Password does not match");
            $("#cpassworderror").css("display", "block");
            $('#cpassword').prop("required", true);
            password_n_match = true;
        } else {
            $('#cpassword').prop("required", false);
            password_n_match = false;
        }

        /*password incorrect length*/
        //too short
        if ($('#password').val().length > 0 && $('#password').val().length < 8) {
            $('#password').css("borderColor", "#ff0000");
            $("#passworderror").text("Password too short");
            $("#passworderror").css("display", "block");
            $('#password').prop("required", true);
            input_short = true;
        } else {
            $('#password').prop("required", false);
            input_short = false;
        }
        //too long
        if ($('#password').val().length > 20) {
            $('#password').css("borderColor", "#ff0000");
            $("#passworderror").text("Password too long");
            $("#passworderror").css("display", "block");
            $('#password').prop("required", true);
            input_long = true;
        } else {
            $('#password').prop("required", false);
            input_long = false;
        }
    } else {
        $('#password').prop("required", false);
        $('#cpassword').prop("required", false);
    }

    $('form').find('.flname').each(function() {
        if($(this).val().length > 30) {
            input_long = true;
            $(this).css("borderColor", "#ff0000");
            $(this).prop("required", true);
            errorlocation = $(this).attr("name") + "error";
            $("#" + errorlocation).css("display", "block");
            $("#" + errorlocation).text("Name is too Long");
        }
    });

    /*stop the submit if any of the above error occurs and display those errors to the user*/
    if (has_empty || password_n_match || input_short || input_long || special_char) {return false;}

}