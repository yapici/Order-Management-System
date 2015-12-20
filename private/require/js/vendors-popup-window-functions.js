$(function () {
    blockUI();
    $("#vendors-popup-window").fadeIn();

    var initial_input_value = '';

    $("#vendors-popup-window-vendors-table input").focus(function () {
        initial_input_value = $(this).val();
    });

    $("#vendors-popup-window-vendors-table input").blur(function () {
        if ($(this).val() !== initial_input_value) {
            var vendor_id = $(this).parent().parent().prop('id');
            var input_id = $(this).prop('id');
            updateVendorDetails(vendor_id, input_id);
        }
    });

    $("#vendors-popup-window-vendors-table input").keyup(function (event) {
        if (event.keyCode === 13) {
            if ($(this).val() !== initial_input_value) {
                var vendor_id = $(this).parent().parent().prop('id');
                var input_id = $(this).prop('id');
                updateVendorDetails(vendor_id, input_id);
                initial_input_value = $(this).val();
                $(this).blur();
            }
        }
    });
});

function showVendorsPopupWindow() {
    blockUI();
    $("#vendors-popup-window").fadeIn();
}

function updateVendorDetails(vendor_id, input_id) {
    var value = $("#" + vendor_id + " #" + input_id).val();
    var field_name = input_id.split('-').pop().trim();
    var vendors_popup_window = $("#vendors-popup-window");
    var error_div = $("#vendors-popup-window-error-div");
    error_div.html('');

    if (field_name === 'approved' && value != '0' && value != '1') {
        error_div.html('Please enter either "0" or "1" for the approved status where "1" meaning approved.');
    } else {
        vendors_popup_window.css('z-index', '9');
        showProgressCircle();
        blockUI();
        $.ajax({
            url: "../ajax/update-vendor-details.php",
            type: "POST",
            data: "vendor_id=" + vendor_id +
                    "&field_name=" + field_name +
                    "&value=" + value,
            cache: false,
            dataType: "json",
            success: function (json_data) {
                if (json_data.status === 'success') {
                } else {
                    error_div.html(json_data.status);
                }
                vendors_popup_window.css('z-index', '9999');
                hideProgressCircle();
            }
        });
    }
}