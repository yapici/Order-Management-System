$(function () {
    var initial_input_value = '';

    $("#vendors-popup-window-vendors-table tbody input").focus(function () {
        initial_input_value = $(this).val();
    });

    $("#vendors-popup-window-vendors-table tbody input").blur(function () {
        if ($(this).val() !== initial_input_value) {
            var vendor_id = $(this).parent().parent().prop('id');
            var input_id = $(this).prop('id');
            updateVendorDetails(vendor_id, input_id);
        }
    });

    $("#vendors-popup-window-vendors-table tbody input").keyup(function (event) {
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
        error_div.html('Please enter either "0" or "1" for the approved status where "1" meaning approved');
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
                } else if (json_data.status === "no_session") {
                    showLoginPopupWindow();
                } else {
                    error_div.html(json_data.status);
                }
                vendors_popup_window.css('z-index', '9999');
                hideProgressCircle();
            }
        });
    }
}

function addNewVendor() {
    var vendor_name = $("#add-new-vendor-name").val();
    var vendo_phone = $("#add-new-vendor-phone").val();
    var vendor_website = $("#add-new-vendor-website").val();
    var vendor_address = $("#add-new-vendor-address").val();
    var vendor_contact_person = $("#add-new-vendor-contact_person").val();

    var vendors_popup_window = $("#vendors-popup-window");
    var vendors_table_tbody = $("#vendors-popup-window-vendors-table tbody");

    var error_div = $("#vendors-popup-window-error-div");
    error_div.html('');

    if (vendor_name === ''
            || vendo_phone === ''
            || vendor_name === 'Name'
            || vendo_phone === 'Phone') {
        error_div.html('Please enter the vendor name and phone number');
    } else {
        if (vendor_website === 'Website') {
            vendor_website = '';
        } else {
            if (vendor_website !== '') {
                if (!/^https?:\/\//i.test(vendor_website)) {
                    vendor_website = 'http://' + vendor_website;
                }
            }
        }
        if (vendor_address === 'Address') {
            vendor_address = '';
        }
        if (vendor_contact_person === 'Contact Person') {
            vendor_contact_person = '';
        }
        vendors_popup_window.css('z-index', '9');
        showProgressCircle();
        blockUI();
        $.ajax({
            url: "../ajax/add-new-vendor.php",
            type: "POST",
            data: "name=" + vendor_name +
                    "&phone=" + vendo_phone +
                    "&website=" + vendor_website +
                    "&address=" + vendor_address +
                    "&contact_person=" + vendor_contact_person,
            cache: false,
            dataType: "json",
            success: function (json_data) {
                if (json_data.status === 'success') {
                    vendors_table_tbody.html(json_data.html_tbody);
                    $("#add-new-vendor-name").val('');
                    $("#add-new-vendor-phone").val('');
                    $("#add-new-vendor-website").val('');
                    $("#add-new-vendor-address").val('');
                    $("#add-new-vendor-contact_person").val('');
                } else if (json_data.status === "no_session") {
                    showLoginPopupWindow();
                } else {
                    error_div.html(json_data.status);
                }
                vendors_popup_window.css('z-index', '9999');
                hideProgressCircle();
            }
        });
    }
}

function deleteVendor(element) {
    var vendor_id = $(element).parent().parent().prop('id');

    var vendors_popup_window = $("#vendors-popup-window");
    var vendors_table_tbody = $("#vendors-popup-window-vendors-table tbody");

    var error_div = $("#vendors-popup-window-error-div");
    error_div.html('');

    vendors_popup_window.css('z-index', '9');
    showProgressCircle();
    blockUI();
    $.ajax({
        url: "../ajax/delete-vendor.php",
        type: "POST",
        data: "vendor_id=" + vendor_id,
        cache: false,
        dataType: "json",
        success: function (json_data) {
            if (json_data.status === 'success') {
                vendors_table_tbody.html(json_data.html_tbody);
            } else if (json_data.status === "no_session") {
                showLoginPopupWindow();
            } else {
                error_div.html(json_data.status);
            }
            vendors_popup_window.css('z-index', '9999');
            hideProgressCircle();
        }
    });
}