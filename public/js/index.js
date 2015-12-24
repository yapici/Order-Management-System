$(document).ready(function() {
    var wasTrailingTextAdded = false;
    $("#email").click(function() {
        var currentValue = $(this).val();
        if (currentValue.indexOf('@') !== -1 && currentValue.indexOf('@example.com') < 0) {
            currentValue = currentValue.substring(0, currentValue.indexOf('@'));
        }

        if (currentValue.indexOf('@example.com') < 0 && currentValue !== "Example E-mail Address") {
            $(this).val(currentValue + "@example.com");
            wasTrailingTextAdded = true;
        }
        if (!wasTrailingTextAdded) {
            $(this)[0].setSelectionRange(0, 0);
        }
        if (currentValue === "@example.com" || currentValue === "" || currentValue === "Example E-mail Address") {
            $(this).val('@example.com');
            $(this)[0].setSelectionRange(0, 0);
        }
    });

    $("#email").blur(function() {
        var error_div = $('#login-error-div');
        error_div.html('&nbsp;');
        var currentValue = $(this).val();
        var trimmedValue = currentValue.substring(0, currentValue.indexOf('@'));
        if (currentValue.indexOf('@') < 0 && currentValue !== "Example E-mail Address" && currentValue !== "") {
            $(this).val(currentValue + "@example.com");
            $(this).css('color', '#1C4D6F');
        } else if (currentValue.indexOf('@') !== -1 && currentValue.indexOf('@example.com') < 0) {
            currentValue = currentValue.substring(0, currentValue.indexOf('@'));
            $(this).val(currentValue + "@example.com");
            $(this).css('color', '#1C4D6F');
        } else if (currentValue.indexOf('@example.com') !== 0 && trimmedValue !== "") {
            $(this).css('color', '#1C4D6F');
        }

        if ($(this).val() === "@example.com") {
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
            loginUser();
        }
    });
});

function loginUser() {
    var email = $("#email").val();
    var password = $("#password").val();
    var error_div = $('#login-error-div');
    error_div.html('&nbsp;');
    error_div.css('color', '#cc0000');

    if (email.length < 1 || password.length < 1) {
        error_div.html("Please fill all the fields properly");
    } else if (!isValidEmailAddress(email)) {
        error_div.html('Please enter a valid e-mail address.');
    } else {
        showProgressCircle();
        blockUI();
        $.ajax({
            url: "ajax/login.php",
            type: "POST",
            data: "email=" + email +
                    "&password=" + password,
            cache: false,
            dataType: "html",
            success: function(html_response) {
                if (html_response.trim() === "success") {
                    window.location = "/orders";
                } else if (html_response.trim() === "invalid_info"
                        || html_response.trim() === "wrong_combination") {
                    error_div.html("Information you entered does not match with our records");
                } else if (html_response.trim() === "invalid_domain_name") {
                    error_div.html("Please use your 'example' email");
                } else if (html_response.trim() === "invalid_email_address") {
                    error_div.html("Please enter a valid email address");
                } else if (html_response.trim() === "no_activation") {
                    window.location = "/activation";
                } else {
                    error_div.html(html_response);
                }
                hideProgressCircle();
                unblockUI();
            }
        });
    }
}