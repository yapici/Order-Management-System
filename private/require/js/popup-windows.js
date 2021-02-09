var selectedUserId;
var selectedUserEmail;

$(function () {
    var initial_input_value = '';

    $("#vendors-popup-window-vendors-table tbody").on('focus', 'input', function () {
        initial_input_value = $(this).val();
    });

    $("#vendors-popup-window-vendors-table tbody").on('blur', 'input', function () {
        if ($(this).val() !== initial_input_value) {
            var vendor_id = $(this).parent().parent().prop('id');
            var input_id = $(this).prop('id');
            updateVendorDetails(vendor_id, input_id);
        }
    });

    $("#vendors-popup-window-vendors-table tbody").on('keyup', 'input', function (event) {
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

    $("#projects-popup-window-projects-table tbody").on('focus', 'input', function () {
        initial_input_value = $(this).val();
    });

    $("#projects-popup-window-projects-table tbody").on('blur', 'input', function () {
        if ($(this).val() !== initial_input_value) {
            var project_id = $(this).parent().parent().prop('id');
            var input_id = $(this).prop('id');
            updateProjectDetails(project_id, input_id);
        }
    });

    $("#projects-popup-window-projects-table tbody").on('keyup', 'input', function (event) {
        if (event.keyCode === 13) {
            if ($(this).val() !== initial_input_value) {
                var project_id = $(this).parent().parent().prop('id');
                var input_id = $(this).prop('id');
                updateProjectDetails(project_id, input_id);
                initial_input_value = $(this).val();
                $(this).blur();
            }
        }
    });

    $("#cost-centers-popup-window-cost-centers-table tbody").on('focus', 'input', function () {
        initial_input_value = $(this).val();
    });

    $("#cost-centers-popup-window-cost-centers-table tbody").on('blur', 'input', function () {
        if ($(this).val() !== initial_input_value) {
            var id = $(this).parent().parent().prop('id');
            var input_id = $(this).prop('id');
            updateCostCenterDetails(id, input_id);
        }
    });

    $("#cost-centers-popup-window-cost-centers-table tbody").on('keyup', 'input', function (event) {
        if (event.keyCode === 13) {
            if ($(this).val() !== initial_input_value) {
                var id = $(this).parent().parent().prop('id');
                var input_id = $(this).prop('id');
                updateCostCenterDetails(id, input_id);
                initial_input_value = $(this).val();
                $(this).blur();
            }
        }
    });

    $("#users-popup-window-users-table tbody").on('focus', 'input', function () {
        initial_input_value = $(this).val();
    });

    $("#users-popup-window-users-table tbody").on('blur', 'input', function () {
        if ($(this).val() !== initial_input_value) {
            var id = $(this).parent().parent().prop('id');
            var input_id = $(this).prop('id');
            updateUserDetails(id, input_id);
        }
    });

    $("#users-popup-window-users-table tbody").on('keyup', 'input', function (event) {
        if (event.keyCode === 13) {
            if ($(this).val() !== initial_input_value) {
                var id = $(this).parent().parent().prop('id');
                var input_id = $(this).prop('id');
                updateUserDetails(id, input_id);
                initial_input_value = $(this).val();
                $(this).blur();
            }
        }
    });

    $("#users-popup-window-users-table tbody").on('change', 'select', function () {
        var id = $(this).parent().parent().prop('id');
        var input_id = $(this).prop('id');
        updateUserDetails(id, input_id);
    });

    $("#vendors-popup-window-vendors-table tbody").on('change', 'select', function () {
        var id = $(this).parent().parent().prop('id');
        var input_id = $(this).prop('id');
        updateVendorDetails(id, input_id);
    });
});

function showVendorsPopupWindow() {
    blockUI();
    $("#vendors-popup-window").fadeIn();
}

function showProjectsPopupWindow() {
    blockUI();
    $("#projects-popup-window").fadeIn();
}

function showCostCentersPopupWindow() {
    blockUI();
    $("#cost-centers-popup-window").fadeIn();
}

function showUsersPopupWindow() {
    blockUI();
    $("#users-popup-window").fadeIn();
}

function updateVendorDetails(vendor_id, input_id) {
    var value = $("#" + vendor_id + " ." + input_id).val();
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
            url: "../ajax/admin/update-vendor-details.php",
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
                } else if (json_data.status === "unauthorized_access") {
                    location.reload();
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
    var vendor_phone = $("#add-new-vendor-phone").val();
    var vendor_website = $("#add-new-vendor-website").val();
    var vendor_address = $("#add-new-vendor-address").val();
    var vendor_contact_person = $("#add-new-vendor-contact_person").val();
    var vendor_account_no = $("#add-new-vendor-account_number").val();

    var vendors_popup_window = $("#vendors-popup-window");
    var vendors_table_tbody = $("#vendors-popup-window-vendors-table tbody");

    var error_div = $("#vendors-popup-window-error-div");
    error_div.html('');

    if (vendor_name === ''
            || vendor_phone === ''
            || vendor_name === 'Name'
            || vendor_phone === 'Phone') {
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
        if (vendor_account_no === 'Account No') {
            vendor_account_no = '';
        }
        vendors_popup_window.css('z-index', '9');
        showProgressCircle();
        blockUI();
        $.ajax({
            url: "../ajax/admin/add-new-vendor.php",
            type: "POST",
            data: {
                name: vendor_name,
                phone: vendor_phone,
                website: vendor_website,
                address: vendor_address,
                contact_person: vendor_contact_person,
                account_number: vendor_account_no
            },
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
                    $("#add-new-vendor-account_number").val('');
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

function showDeleteVendorConfirmPopup(element) {
    var vendor_id = $(element).parent().parent().prop('id');
    $("#delete-vendor-confirmation-button").attr("onclick", "deleteVendor(" + vendor_id + ")");

    blockUI();
    var popup_window = $("#delete-vendor-confirmation-popup-window");
    popup_window.fadeIn();
    popup_window.css('z-index', '9999999');
    $(".gray-out-div").css('z-index', '999999');
}

function hideDeleteVendorConfirmationWindow() {
    hidePopupWindow('delete-vendor-confirmation-popup-window');
    $("#delete-vendor-confirmation-button").removeAttr('onclick');
}

function deleteVendor(vendor_id) {
    $("#delete-vendor-confirmation-popup-window").css('z-index', '99999');
    var vendors_popup_window = $("#vendors-popup-window");
    var vendors_table_tbody = $("#vendors-popup-window-vendors-table tbody");

    var error_div = $("#vendors-popup-window-error-div");
    error_div.html('');

    vendors_popup_window.css('z-index', '9');
    showProgressCircle();
    blockUI();
    $.ajax({
        url: "../ajax/admin/delete-vendor.php",
        type: "POST",
        data: "vendor_id=" + vendor_id,
        cache: false,
        dataType: "json",
        success: function (json_data) {
            if (json_data.status === 'success') {
                vendors_table_tbody.html(json_data.html_tbody);
            } else if (json_data.status === "no_session") {
                showLoginPopupWindow();
            } else if (json_data.status === "unauthorized_access") {
                location.reload();
            } else {
                error_div.html(json_data.status);
            }
            vendors_popup_window.css('z-index', '9999');
            hideDeleteVendorConfirmationWindow();
            hideProgressCircle();
        }
    });
}

function updateProjectDetails(tr_id, input_id) {
    var value = $("#" + tr_id + " ." + input_id).val();
    var project_id = tr_id.split('-').pop().trim();
    var field_name = input_id.split('-').pop().trim();
    var projects_popup_window = $("#projects-popup-window");
    var error_div = $("#projects-popup-window-error-div");
    error_div.html('');

    if (field_name === 'active' && value != '0' && value != '1') {
        error_div.html('Please enter either "0" or "1" for the active status where "1" meaning active');
    } else {
        projects_popup_window.css('z-index', '9');
        showProgressCircle();
        blockUI();
        $.ajax({
            url: "../ajax/admin/update-project-details.php",
            type: "POST",
            data: "project_id=" + project_id +
                    "&field_name=" + field_name +
                    "&value=" + value,
            cache: false,
            dataType: "json",
            success: function (json_data) {
                if (json_data.status === 'success') {
                } else if (json_data.status === "no_session") {
                    showLoginPopupWindow();
                } else if (json_data.status === "unauthorized_access") {
                    location.reload();
                } else {
                    error_div.html(json_data.status);
                }
                projects_popup_window.css('z-index', '9999');
                hideProgressCircle();
            }
        });
    }
}

function addNewProject() {
    var project_name = $("#add-new-project-name").val();
    var project_number = $("#add-new-project-number").val();

    var projects_popup_window = $("#projects-popup-window");
    var projects_table_tbody = $("#projects-popup-window-projects-table tbody");

    var error_div = $("#projects-popup-window-error-div");
    error_div.html('');

    if (project_name === ''
            || project_number === ''
            || project_name === 'Name'
            || project_number === 'Project Number') {
        error_div.html('Please fill all the fields');
    } else {
        projects_popup_window.css('z-index', '9');
        showProgressCircle();
        blockUI();
        $.ajax({
            url: "../ajax/admin/add-new-project.php",
            type: "POST",
            data: "name=" + project_name +
                    "&number=" + project_number,
            cache: false,
            dataType: "json",
            success: function (json_data) {
                if (json_data.status === 'success') {
                    projects_table_tbody.html(json_data.html_tbody);
                    $("#add-new-project-name").val('');
                    $("#add-new-project-number").val('');
                } else if (json_data.status === "no_session") {
                    showLoginPopupWindow();
                } else {
                    error_div.html(json_data.status);
                }
                projects_popup_window.css('z-index', '9999');
                hideProgressCircle();
            }
        });
    }
}

function updateCostCenterDetails(tr_id, input_id) {
    var value = $("#" + tr_id + " ." + input_id).val();
    var cost_center_id = tr_id.split('-').pop().trim();
    var field_name = input_id.split('-').pop().trim();
    var cost_centers_popup_window = $("#cost-centers-popup-window");
    var error_div = $("#cost-centers-popup-window-error-div");
    error_div.html('');

    if (field_name === 'active' && value != '0' && value != '1') {
        error_div.html('Please enter either "0" or "1" for the active status where "1" meaning active');
    } else {
        cost_centers_popup_window.css('z-index', '9');
        showProgressCircle();
        blockUI();
        $.ajax({
            url: "../ajax/admin/update-cost-center-details.php",
            type: "POST",
            data: "cost_center_id=" + cost_center_id +
                    "&field_name=" + field_name +
                    "&value=" + value,
            cache: false,
            dataType: "json",
            success: function (json_data) {
                if (json_data.status === 'success') {
                } else if (json_data.status === "no_session") {
                    showLoginPopupWindow();
                } else if (json_data.status === "unauthorized_access") {
                    location.reload();
                } else {
                    error_div.html(json_data.status);
                }
                cost_centers_popup_window.css('z-index', '9999');
                hideProgressCircle();
            }
        });
    }
}

function addNewCostCenter() {
    var cost_center_name = $("#add-new-cost-center-name").val();

    var cost_centers_popup_window = $("#cost-centers-popup-window");
    var cost_centers_table_tbody = $("#cost-centers-popup-window-cost-centers-table tbody");

    var error_div = $("#cost-centers-popup-window-error-div");
    error_div.html('');

    if (cost_center_name === ''
            || cost_center_name === 'Name') {
        error_div.html('Please enter the cost center name');
    } else {
        cost_centers_popup_window.css('z-index', '9');
        showProgressCircle();
        blockUI();
        $.ajax({
            url: "../ajax/admin/add-new-cost-center.php",
            type: "POST",
            data: "name=" + cost_center_name,
            cache: false,
            dataType: "json",
            success: function (json_data) {
                if (json_data.status === 'success') {
                    cost_centers_table_tbody.html(json_data.html_tbody);
                    $("#add-new-cost-center-name").val('');
                } else if (json_data.status === "no_session") {
                    showLoginPopupWindow();
                } else {
                    error_div.html(json_data.status);
                }
                cost_centers_popup_window.css('z-index', '9999');
                hideProgressCircle();
            }
        });
    }
}

function updateUserDetails(tr_id, input_id) {
    var value = $("#" + tr_id + " ." + input_id).val();
    var user_id = tr_id.split('-').pop().trim();
    var field_name = input_id.split('-').pop().trim();
    var users_popup_window = $("#users-popup-window");
    var error_div = $("#users-popup-window-error-div");
    error_div.html('');

    users_popup_window.css('z-index', '9');
    showProgressCircle();
    blockUI();
    $.ajax({
        url: "../ajax/admin/update-user-details.php",
        type: "POST",
        data: "user_id=" + user_id +
                "&field_name=" + field_name +
                "&value=" + value,
        cache: false,
        dataType: "json",
        success: function (json_data) {
            if (json_data.status === 'success') {
            } else if (json_data.status === "no_session") {
                showLoginPopupWindow();
            } else if (json_data.status === "unauthorized_access") {
                location.reload();
            } else {
                error_div.html(json_data.status);
            }
            users_popup_window.css('z-index', '9999');
            hideProgressCircle();
        }
    });
}

function showResetPasswordConfirmationPopup(element) {
    var elementId = $(element).parent().parent().attr("id");
    selectedUserId = elementId.split('-').pop().trim();
    selectedUserEmail = $("#" + elementId + " td:first-child").attr("title");
    $("#reset-password-confirmation-popup-window-p").html("Are you sure you want to reset the password for <b><i>" + selectedUserEmail + "</i></b>?");

    blockUI();
    var popup_window = $("#reset-password-confirmation-popup-window");
    popup_window.fadeIn();
    popup_window.css('z-index', '9999999');
    $(".gray-out-div").css('z-index', '999999');
}

function hideResetPasswordConfirmationWindow() {
    hidePopupWindow('reset-password-confirmation-popup-window');
    selectedUserId = "";
    selectedUserEmail = "";
}

function adminResetUserPassword() {
    var error_div = $("#users-popup-window-error-div");

    $("#reset-password-confirmation-popup-window").css('z-index', '99999');
    showProgressCircle();
    blockUI();
    $.ajax({
        url: "../ajax/admin/reset-user-password.php",
        type: "POST",
        data: {user_id: selectedUserId},
        cache: false,
        dataType: "json",
        success: function (json_data) {
            if (json_data.status === 'success') {
                error_div.html("Password for the user '" + selectedUserEmail + "' has been changed to 'password'.");
            } else if (json_data.status === "no_session") {
                showLoginPopupWindow();
            } else if (json_data.status === "unauthorized_access") {
                location.reload();
            } else {
                error_div.html(json_data.status);
            }
            hideResetPasswordConfirmationWindow();
            hideProgressCircle();
        }
    });
}

function sortVendor(element, column) {
    var error_div = $('#vendors-popup-window-error-div');

    showProgressCircle();
    $.ajax({
        url: "../ajax/admin/sort-vendors.php",
        type: "GET",
        data: {column: column},
        cache: false,
        dataType: "json",
        success: function (json_data) {
            if (json_data.status === 'success') {
                $('#vendors-popup-window-vendors-table tbody').html(json_data.html_tbody);

                $('#vendors-popup-window-vendors-table thead tr td a').html('&#9650;');
                $('#vendors-popup-window-vendors-table thead tr td a').css('opacity', '0.5');

                if (element.length) {
                    var up_or_down = json_data.up_or_down;

                    if (up_or_down === 'up') {
                        element.find('a').html('&#9660;');
                    } else {
                        element.find('a').html('&#9650;');
                    }
                    element.find('a').css('opacity', '1');
                }
            } else if (json_data.status === "no_session") {
                showLoginPopupWindow();
            } else {
                error_div.html("Something went wrong, please try again later.");
            }
            hideProgressCircle();
        }
    });
}


if (msieversion() < 10 && msieversion()) {
    $("#admin-file-upload-td").html('File upload function is not supported in Internet Explorer 9. Please use a different browser to upload attachments.');
}