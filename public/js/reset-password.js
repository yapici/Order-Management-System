$(document).ready(function () {
    $("#password-repeat").keyup(function (event) {
        if (event.keyCode === 13) {
            resetPassword();
        }
    });

});

function resetPassword() {
    var code = $("#code").val();
    var email = $("#email").val();
    var password = $("#password").val();
    var password_repeat = $("#password-repeat").val();
    var error_div = $('#reset-password-error-div');
    error_div.html('&nbsp;');
    error_div.css('color', '#cc0000');

    if (password === '' || password_repeat === ''
            || password === 'Password' || password_repeat === 'Password') {
        error_div.html("Please fill both password fields");
    } else if (password !== password_repeat) {
        error_div.html("Passwords do not match");
    } else {
        showProgressCircle();
        blockUI();
        $.ajax({
            url: "ajax/reset-password.php",
            type: "POST",
            data: "email=" + email +
                    "&code=" + code +
                    "&password=" + password,
            cache: false,
            dataType: "json",
            success: function (json_response) {
                if (json_response.status === "success") {
                    window.location = "/";
                } else if (json_response.status.trim() === "wrong_password_reset_code") {
                    error_div.html("<div>The password reset code couldn't be found for this e-mail address.</div><div>Please use the link in the e-mail without modifying it. If it still doesn't work, please contact the webmaster.</div>");
                } else if (json_response.status === 'no_password_reset_request_found_for_this_email') {
                    error_div.html("<div>No password request is found for this e-mail address.</div><div>Please send a new request from <a href='/forgot-password'><u>Forgot Password</u></a>.</div>");
                } else {
                    error_div.html('Something went wrong. Please try again.');
                }
                hideProgressCircle();
                unblockUI();
            }
        });
    }
}