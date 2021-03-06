$(document).ready(function() {
    var wasTrailingTextAdded = false;
    $("#email").click(function() {
        var currentValue = $(this).val();
        if (currentValue.indexOf('@') !== -1 && currentValue.indexOf(DOMAIN_EMAIL_EXT) < 0) {
            currentValue = currentValue.substring(0, currentValue.indexOf('@'));
        }

        if (currentValue.indexOf(DOMAIN_EMAIL_EXT) < 0 && currentValue !== "E-mail Address") {
            $(this).val(currentValue + DOMAIN_EMAIL_EXT);
            wasTrailingTextAdded = true;
        }
        if (!wasTrailingTextAdded) {
            $(this)[0].setSelectionRange(0, 0);
        }
        if (currentValue === DOMAIN_EMAIL_EXT || currentValue === "" || currentValue === "E-mail Address") {
            $(this).val(DOMAIN_EMAIL_EXT);
            $(this)[0].setSelectionRange(0, 0);
        }
    });

    $("#email").blur(function() {
        var error_div = $('#register-error-div');
        error_div.html('&nbsp;');
        var currentValue = $(this).val();
        var trimmedValue = currentValue.substring(0, currentValue.indexOf('@'));
        if (currentValue.indexOf('@') < 0 && currentValue !== "E-mail Address" && currentValue !== "") {
            $(this).val(currentValue + DOMAIN_EMAIL_EXT);
            $(this).css('color', '#1C4D6F');
        } else if (currentValue.indexOf('@') !== -1 && currentValue.indexOf(DOMAIN_EMAIL_EXT) < 0) {
            currentValue = currentValue.substring(0, currentValue.indexOf('@'));
            $(this).val(currentValue + DOMAIN_EMAIL_EXT);
            $(this).css('color', '#1C4D6F');
        } else if (currentValue.indexOf(DOMAIN_EMAIL_EXT) !== 0 && trimmedValue !== "") {
            $(this).css('color', '#1C4D6F');
        }

        if ($(this).val() === DOMAIN_EMAIL_EXT) {
            $(this).addClass('placeholder');
            $(this).val($(this).attr('placeholder'));
            $(this).css('color', '#aaaaaa');
        }

        if (!isValidEmailAddress($(this).val())) {
            error_div.css('color', '#cc0000');
            error_div.html('Please enter a valid e-mail address.');
        }
    });
    
    $("#password").keyup(function(event) {
        if (event.keyCode === 13) {
            registerUser();
        }
    });
    
    $("#password-repeat").keyup(function(event) {
        if (event.keyCode === 13) {
            registerUser();
        }
    });
    
    $("#email").keyup(function(event) {
        if (event.keyCode === 13) {
            registerUser();
        }
    });
});

function registerUser() {
    var email = $("#email").val();
    var password = $("#password").val();
    var password_repeat = $("#password-repeat").val();
    var error_div = $('#register-error-div');
    error_div.html('&nbsp;');
    error_div.css('color', '#cc0000');

    if (email.length < 1 || password.length < 1|| password_repeat.length < 1) {
        error_div.html("Please fill all the fields properly");
    } else if (password !== password_repeat) {
        error_div.html('Password do not match');
    } else if (!isValidEmailAddress(email)) {
        error_div.html('Please enter a valid e-mail address');
    } else {
        showProgressCircle();
        blockUI();
        $.ajax({
            url: "ajax/register.php",
            type: "POST",
            data: "email=" + email +
                    "&password=" + password,
            cache: false,
            dataType: "html",
            success: function(html_response) {
                if (html_response.trim() === "success") {
                    error_div.html("An activation link has been sent to your e-mail address. Please activate your account by clicking the link.");
                } else if (html_response.trim() === "invalid_domain_name") {
                    error_div.html("Please use your '" + DOMAIN_BODY +"' email");
                } else if (html_response.trim() === "invalid_email_address") {
                    error_div.html("Please enter a valid email address");
                } else if (html_response.trim() === "already_exists") {
                    error_div.html("This e-mail address is already in use");
                } else if (html_response.trim() === "mail_fail") {
                    error_div.html("Your account has been created, however, an error occured when sending the activation e-mail. Please contact an administrator to activate your account.");
                } else {
                    error_div.html(html_response);
                }
                hideProgressCircle();
                unblockUI();
            }
        });
    }
}