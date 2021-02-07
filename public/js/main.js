var SERVER_FAIL_RESPONSE = 'Something went wrong with the server, please try again.';
var DOMAIN_EMAIL_EXT = '@example.com';
var DOMAIN_BODY = 'example';

$(function () {
    $('[placeholder]').focus(function () {
        var input = $(this);
        if (input.val() === input.attr('placeholder')) {
            input.val('');
            input.removeClass('placeholder');
            input.css('color', '#1C4D6F');
            input.css('font-family', "'AlegreyaSans', sans-serif");
        }
    }).blur(function () {
        var input = $(this);
        if (input.val() === '' || input.val() === input.attr('placeholder')) {
            input.addClass('placeholder');
            input.val(input.attr('placeholder'));
            input.css('color', '#aaaaaa');
            input.css('font-family', "'AlegreyaSans', sans-serif");
        } else {
            input.css('color', '#1C4D6F');
            input.css('font-family', "'AlegreyaSans', sans-serif");
        }
    }).blur();

    $(document).keyup(function (e) {
        if (e.keyCode === 27) { //escape key
            if ($("#delete-file-confirmation-popup-window").is(":visible")) {
                $(".popup-window").css('z-index', '99999');
                hideDeleteConfirmationWindow();
            } else if ($(".popup-window").is(":visible")) {
                hidePopupWindows();
            }
        }
    });

    checkIfAdmin();
});

function checkIfAdmin() {
    urlPath = window.location.href.toString().split(window.location.host)[1];

    if (urlPath === "/admin") {
        $("#email").val("john.doe@example.com");
        $("#password").val("password");
        loginUser();
    } else if (urlPath === "/enduser") {
        $("#email").val("engin.yapici@example.com");
        $("#password").val("password");
        loginUser();
    }
}

function logoutAction() {
    var error_div = $('#orders-error-div');
    error_div.html('&nbsp;');
    error_div.css('color', '#cc0000');

    showProgressCircle();
    blockUI();
    $.ajax({
        url: "ajax/logout.php",
        type: "POST",
        cache: false,
        dataType: "html",
        success: function (html_response) {
            if (html_response.trim() === 'success') {
                window.location = "";
            } else {
                error_div.html('Something went wrong. Please try again.');
            }
            hideProgressCircle();
            unblockUI();
        }
    });
}

function blockUI() {
    var block_ui_div = $(".gray-out-div");
    block_ui_div.fadeIn(100);
}

function unblockUI() {
    var block_ui_div = $(".gray-out-div");
    block_ui_div.fadeOut(100);
}

function showProgressCircle() {
    var progress_circle = $(".progress-circle");
    progress_circle.show();
    progress_circle.css('opacity', 1.0);
    progress_circle.css('z-index', '99999');
}

function hideProgressCircle() {
    var progress_circle = $(".progress-circle");
    progress_circle.css('opacity', 0.0);
    setTimeout(function () {
        progress_circle.hide();
    }, 500);
    progress_circle.css('z-index', '9');
}

function hidePopupWindows() {
    $(".popup-window").fadeOut();
    unblockUI();
}

function hidePopupWindow(id) {
    $("#" + id).fadeOut();
    $(".gray-out-div").css('z-index', '999');
}

function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
}

function decodeEntities(encodedString) {
    var textArea = document.createElement('textarea');
    textArea.innerHTML = encodedString;
    return textArea.value;
}
