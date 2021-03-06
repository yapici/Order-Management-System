var onFocusTableUpdateFlag = true;
var setIntervalForRefreshFlag;

$(function () {
    setIntervalForRefreshFlag = true;
    $("#orders-search-input").keyup(function (event) {
        if (event.keyCode === 13) {
            searchAction('search');
        }
    });

    datepickerFunctions();
    popupLoginWindowInputFunctions();

    $("#add-new-item-popup-window").on('input', function () {
        showHideClearButton();
    });

    $("#add-new-item-popup-window").on('change', 'select', function () {
        showHideClearButton();
    });

    setInterval(function () {
        if (setIntervalForRefreshFlag) {
            refreshOrdersTable();
        }
    }, 30000);
});

window.onfocus = function () {
    if (onFocusTableUpdateFlag) {
        refreshOrdersTable();
        onFocusTableUpdateFlag = false;
    }
    setIntervalForRefreshFlag = true;
};

window.onblur = function () {
    onFocusTableUpdateFlag = true;
    setIntervalForRefreshFlag = false;
};

function showHideClearButton() {
    if ($("#add-new-item-popup-window input").filter(function () {
        return $(this).val();
    }).length > 0
            || $("#add-new-item-vendor").val() !== 'Please Choose a Vendor'
            || $("#add-new-item-project").val() !== 'Please Choose a Project'
            || $("#add-new-item-cost-center").val() !== '') {
        $("#add-new-item-popup-window-clear-button").show();
    } else {
        $("#add-new-item-popup-window-clear-button").hide();
    }
}

function clearText() {
    $("#add-new-item-popup-window input").val('');
    $("#add-new-item-vendor")[0].selectedIndex = 0;
    $("#add-new-item-project")[0].selectedIndex = 0;
    $("#add-new-item-cost-center")[0].selectedIndex = 0;
    $("#add-new-item-popup-window-clear-button").hide();
    $(".add-new-item-vendor-details-holder-tr").hide();
}

function showItemDetailsPopupWindow(
        orderNo,
        description,
        quantity,
        uom,
        vendor,
        catalogNo,
        price,
        weblink,
        costCenter,
        project,
        comments,
        requestedByUsername,
        requestedDate,
        statusUpdatedByUsername,
        statusUpdatedDate,
        status,
        itemNeededByDate,
        ordered,
        orderedDate,
        orderedByUsername,
        delivered,
        deliveredDate,
        deliveredByUsername,
        editable,
        sds,
        vendorId) {
    blockUI();
    $('.popup-error-div').html('');

    if (msieversion() < 10 && msieversion()) {
        $("#item-details-popup-window-file-upload-elements-wrapper").html('File upload function is not supported in Internet Explorer 9. Please use a different browser to upload attachments.');
    }

    if (weblink !== '') {
        var weblink = "<a target='_blank' href='" + weblink + "'>Link</a>";
    }

    var totalPrice = price * quantity;
    $("#popup-item-order-number").html("Order " + orderNo);
    $("#popup-item-description").html(description);
    $("#popup-item-quantity").html(quantity);
    $("#popup-item-uom").html(uom);
    $("#popup-item-vendor").html(vendor);
    $("#popup-item-vendor").attr("vendor-id", vendorId);
    $("#popup-item-catalog-no").html(catalogNo);
    $("#popup-item-price").html("$" + price);
    $("#popup-item-total-price").html("$" + totalPrice.toFixed(2));
    $("#popup-item-weblink").html(weblink);
    $("#popup-item-cost-center").html(costCenter);
    $("#popup-item-project").html(project);
    $("#popup-item-comments").html(comments);
    $("#popup-item-sds").html(sds);
    $("#popup-item-status-updated-date").html(statusUpdatedDate);
    $("#popup-item-requested-date").html(requestedDate);
    $('#popup-item-requested-by').html(requestedByUsername);
    $("#popup-item-status-updated-by").html(statusUpdatedByUsername);
    $("#popup-item-item-needed-by").html(itemNeededByDate);
    $("#popup-item-status").html(status);
    $("#file-upload-order-id").val(orderNo);

    if (ordered === '1') {
        $("#popup-item-status-ordered-tr").show();
        $("#popup-item-status-ordered-by").html(orderedByUsername);
        $("#popup-item-status-ordered-date").html(orderedDate);
    } else {
        $("#popup-item-status-ordered-tr").hide();
    }

    if (delivered === '1') {
        $("#popup-item-status-delivered-tr").show();
        $("#popup-item-status-delivered-by").html(deliveredByUsername);
        $("#popup-item-status-delivered-date").html(deliveredDate);
    } else {
        $("#popup-item-status-delivered-tr").hide();
    }

    if (editable === "true") {
        $("#item-details-popup-window-user-edit-icon-wrapper").css("display", "inline-block");
    } else {
        $("#item-details-popup-window-user-edit-icon-wrapper").css("display", "none");
    }

    showProgressCircle();
    $.ajax({
        url: "ajax/populate-attachments.php",
        type: "GET",
        data: {
            order_id: orderNo
        },
        cache: false,
        dataType: "json",
        success: function (json_response) {
            if (json_response.html_response !== 'no_session') {
                $("#item-details-attachments-holder").html(json_response.html_response);
                $("#item-details-popup-window").fadeIn();
            } else {
                showLoginPopupWindow();
            }
            hideProgressCircle();
        }
    });
}

function reorder() {
    $("#item-details-popup-window").fadeOut();
    $("#add-new-item-description").val(decodeEntities($("#popup-item-description").html()));
    $("#add-new-item-quantity").val(decodeEntities($("#popup-item-quantity").html()));
    $("#add-new-item-uom").val(decodeEntities($("#popup-item-uom").html()));
    $('#add-new-item-vendor option[value="' + $("#popup-item-vendor").attr("vendor-id") + '"]').prop('selected', true);
    $("#add-new-item-catalog-no").val(decodeEntities($("#popup-item-catalog-no").html()));
    $("#add-new-item-price").val(decodeEntities($("#popup-item-price").html().substring(1)));
    $("#add-new-item-weblink").val(decodeEntities($($("#popup-item-weblink").html()).attr('href')));
    $('#add-new-item-cost-center option:contains("' + $("#popup-item-cost-center").html() + '")').prop('selected', true);
    $('#add-new-item-project option:contains("' + $("#popup-item-project").html() + '")').prop('selected', true);
    $("#add-new-item-comments").val(decodeEntities($("#popup-item-comments").html()));
    showAddNewItemPopupWindow();
}

function showAddNewItemPopupWindow() {
    blockUI();
    $("#add-new-item-popup-window").fadeIn();
    $(".popup-error-div").html('');

    if ($("#add-new-item-popup-window input").filter(function () {
        return $(this).val();
    }).length > 0) {
        $("#add-new-item-popup-window-clear-button").show();
    }

    if (msieversion() < 10 && msieversion()) {
        $("#add-new-item-popup-window-file-upload-elements-wrapper").html('File upload function is not supported in Internet Explorer 9. Please use a different browser to upload attachments.');
    }
}

function addNewItem() {
    var add_new_item_popup_window = $("#add-new-item-popup-window");
    var description = encodeURIComponent($("#add-new-item-description").val());
    var quantity = encodeURIComponent($("#add-new-item-quantity").val());
    var uom = encodeURIComponent($("#add-new-item-uom").val());
    var vendor = $("#add-new-item-vendor").val();
    var catalog_no = encodeURIComponent($("#add-new-item-catalog-no").val());
    var price = encodeURIComponent($("#add-new-item-price").val());
    var cost_center = encodeURIComponent($("#add-new-item-cost-center").val());
    var project = $("#add-new-item-project").val();
    var comments = encodeURIComponent($("#add-new-item-comments").val());
    var sds = $("#add-new-item-sds").val();
    var date_needed = encodeURIComponent($("#add-new-item-date-needed").val());
    var weblink = encodeURIComponent($("#add-new-item-weblink").val());

    // New Vendor Details
    var new_vendor_name = encodeURIComponent($("#add-new-item-new-vendor-name").val());
    var new_vendor_phone = encodeURIComponent($("#add-new-item-new-vendor-phone").val());
    var new_vendor_website = encodeURIComponent($("#add-new-item-new-vendor-website").val());
    var new_vendor_address = encodeURIComponent($("#add-new-item-new-vendor-address").val());

    // Error div
    var error_div = $('#add-new-item-error-div');
    error_div.html("");

    if (description === ''
            || quantity === ''
            || uom === ''
            || vendor === 'Please Choose a Vendor'
            || catalog_no === ''
            || date_needed === ''
            || project === 'Please Choose a Project'
            || sds === '') {
        error_div.html("Please fill all the mandatory fields");
    } else if (vendor === "Add New Vendor"
            && (new_vendor_name === ''
                    || new_vendor_phone === ''
                    || new_vendor_website === '')) {
        error_div.html('Please enter all the required vendor details.');
    } else if (!$.isNumeric(quantity)) {
        error_div.html('Please enter only numberic values for the quantity.');
    } else if (price !== '' && !$.isNumeric(price)) {
        error_div.html('Please enter only numberic values for the price.');
    } else {
        add_new_item_popup_window.css('z-index', '9');
        showProgressCircle();
        blockUI();
        $.ajax({
            url: "../ajax/add-new-item.php",
            type: "POST",
            data: "description=" + description +
                    "&quantity=" + quantity +
                    "&uom=" + uom +
                    "&vendor=" + encodeURIComponent(vendor) +
                    "&new_vendor_name=" + new_vendor_name +
                    "&new_vendor_phone=" + new_vendor_phone +
                    "&new_vendor_website=" + new_vendor_website +
                    "&new_vendor_address=" + new_vendor_address +
                    "&catalog_no=" + catalog_no +
                    "&price=" + price +
                    "&cost_center=" + cost_center +
                    "&project=" + encodeURIComponent(project) +
                    "&date_needed=" + date_needed +
                    "&weblink=" + weblink +
                    "&comments=" + comments +
                    "&sds=" + sds,
            cache: false,
            dataType: "json",
            success: function (json_data) {
                if (json_data.status === 'success') {
                    $('#orders-table tbody').html(json_data.html_tbody);
                    $('#add-new-item-popup-window').html(json_data.add_new_item_popup);
                    $('#orders-search-cancel-button').hide();
                    $('#orders-search-input').val('');
                    $('.reset-sort-button').hide();
                    unblockUI();
                    add_new_item_popup_window.fadeOut();
                } else if (json_data.status === "no_session") {
                    showLoginPopupWindow();
                } else {
                    error_div.html(json_data.status);
                }
                add_new_item_popup_window.css('z-index', '99999');
                hideProgressCircle();
            }
        });
    }
}

function showDeleteConfirmationWindow(file) {
    blockUI();
    popup_window = $("#delete-file-confirmation-popup-window");
    popup_window.fadeIn();
    popup_window.css('z-index', '9999999');
    $(".gray-out-div").css('z-index', '999999');
    $("#delete-file-confirmation-button").attr('onclick', 'deleteAttachment("' + file + '")');
}

function hideDeleteConfirmationWindow() {
    hidePopupWindow('delete-file-confirmation-popup-window');
    $("#delete-file-confirmation-button").removeAttr('onclick');
}

function deleteAttachment(file) {
    var popup_window = $(".popup-window");
    var error_div = $(".popup-error-div");
    showProgressCircle();
    popup_window.css('z-index', '9');
    $.ajax({
        url: "ajax/delete-attachment.php",
        type: "GET",
        data: "file=" + file,
        cache: false,
        dataType: "json",
        success: function (json_response) {
            if (json_response.status === 'success') {
                if ($("#add-new-item-popup-window").is(":visible")) {
                    $("#add-new-item-attachments-holder").html(json_response.html_response);
                } else {
                    $("#item-details-attachments-holder").html(json_response.html_response);
                }
            } else if (json_response.status === 'get_out_of_here') {
                error_div.html("You sneaky sun of a gun. Stop doing that.");
            } else if (json_response.status === "no_session") {
                showLoginPopupWindow();
            } else {
                error_div.html("Something went wrong, please try again later.");
            }
            popup_window.css('z-index', '99999');
            hideDeleteConfirmationWindow();
            ;
            hideProgressCircle();
        }
    });
}

function sortByColumn(element) {
    var error_div = $('#orders-error-div');
    var column = '';
    var reset_sort_button = $('.reset-sort-button');
    if (element.length) {
        column = element.html().substring(0, 3);
    } else {
        reset_sort_button.hide();
    }
    showProgressCircle();
    blockUI();
    $.ajax({
        url: "ajax/update-table-with-sort.php",
        type: "GET",
        data: "column=" + column,
        cache: false,
        dataType: "json",
        success: function (json_data) {
            if (json_data.status === 'success') {
                $('#orders-table tbody').html(json_data.html_tbody);
                $("#pagination-holder-div").html(json_data.html_pagination);

                $('#orders-table thead tr td a').html('&#9650;');
                $('#orders-table thead tr td a').css('opacity', '0.5');

                if (element.length) {
                    var up_or_down = json_data.up_or_down;

                    if (up_or_down === 'up') {
                        element.find('a').html('&#9660;');
                    } else {
                        element.find('a').html('&#9650;');
                    }
                    element.find('a').css('opacity', '1');
                    reset_sort_button.show();
                }
                unblockUI();
            } else if (json_data.status === "no_session") {
                showLoginPopupWindow();
            } else {
                error_div.html("Something went wrong, please try again later.");
                unblockUI();
            }
            hideProgressCircle();
        }
    });
}

function searchAction(action) {
    var error_div = $('#orders-error-div');
    var keywords;
    if (action === 'search') {
        keywords = $('#orders-search-input').val();
    } else {
        keywords = "";
    }
    showProgressCircle();
    blockUI();
    $.ajax({
        url: "ajax/update-table-with-search.php",
        type: "GET",
        data: "search_keywords=" + keywords,
        cache: false,
        dataType: "json",
        success: function (json_data) {
            if (json_data.status === 'success') {
                $('#orders-table tbody').html(json_data.html_tbody);
                $("#pagination-holder-div").html(json_data.html_pagination);
                if (action === 'search') {
                    $("#number-of-search-results-holder").html(json_data.number_of_items);
                } else {
                    $("#number-of-search-results-holder").html("");
                }

                if (action === 'search' && keywords !== "") {
                    $('#orders-search-cancel-button').show();
                } else {
                    $('#orders-search-cancel-button').hide();
                    $('#orders-search-input').val('');
                }
                unblockUI();
            } else if (json_data.status === "no_session") {
                showLoginPopupWindow();
            } else {
                error_div.html("Something went wrong, please try again later.");
                unblockUI();
            }
            hideProgressCircle();
        }
    });
}

function goToPage(page_number) {
    var error_div = $('#orders-error-div');
    showProgressCircle();
    blockUI();
    $.ajax({
        url: "ajax/update-table-with-page-number.php",
        type: "GET",
        data: "page_number=" + page_number,
        cache: false,
        dataType: "json",
        success: function (json_data) {
            if (json_data.status === 'success') {
                $('#orders-table tbody').html(json_data.html_tbody);
                $("#pagination-holder-div").html(json_data.html_pagination);
                unblockUI();
            } else if (json_data.status === "no_session") {
                showLoginPopupWindow();
            } else {
                error_div.html("Something went wrong, please try again later.");
                unblockUI();
            }
            hideProgressCircle();
        }
    });
}

function datepickerFunctions() {
    $(function () {
        $(document).on('focus', '.datepicker', function () {
            $(this).datepicker({
                dateFormat: 'dd-M-yy',
                onSelect: function (dateText) {
                    var input = $(this);
                    input.css('color', '#1C4D6F');
                    input.change();
                }
            });

        });
    });
}

function uploadFile(popup) {
    if (popup === 'new-item') {
        var file_input = $('#new-item-file-to-upload');
    } else if (popup === 'item-details') {
        var file_input = $('#item-details-file-to-upload');
    }
    var file_data = file_input.prop('files')[0];
    var form_data = new FormData();
    form_data.append('file-to-upload', file_data);
    if ($("#item-details-popup-window").is(":visible")) {
        form_data.append('file_upload_order_id', $("#file-upload-order-id").val());
    }

    var popup_window = $(".popup-window");
    var error_div = $('.popup-error-div');
    error_div.html("");

    if (file_input.val() === '') {
        error_div.html('No file was chosen. Please choose a file to upload.');
    } else if (file_data.size > 10485760) {
        error_div.html('Maximum file upload size is 10 MB');
    } else {
        blockUI();
        showProgressCircle();
        popup_window.css('z-index', '9');
        $.ajax({
            url: 'ajax/upload-file.php',
            type: 'POST',
            data: form_data,
            cache: false,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (json_response) {
                if (json_response.status === 'success') {
                    if ($("#add-new-item-popup-window").is(":visible")) {
                        $("#add-new-item-attachments-holder").html(json_response.html_response);
                    } else {
                        $("#item-details-attachments-holder").html(json_response.html_response);
                    }
                    popup_window.css('z-index', '99999');
                } else if (json_response.status === 'disallowed_file_type') {
                    error_div.html('This file type is not allowed');
                    popup_window.css('z-index', '99999');
                } else if (json_response.status === 'no_file_was_chosen') {
                    error_div.html('No file was chosen. Please choose a file to upload.');
                    popup_window.css('z-index', '99999');
                } else if (json_response.status === 'max_file_size_exceeded') {
                    error_div.html('Maximum file upload size is 10 MB');
                    popup_window.css('z-index', '99999');
                } else if (json_response.status === "no_session") {
                    showLoginPopupWindow();
                } else {
                    error_div.html('Something went wrong. Please contact webmaster.');
                    popup_window.css('z-index', '99999');
                }
                hideProgressCircle();
            }
        });
    }
}

function showVendorDetails(vendorId) {
    $(".add-new-item-vendor-details-holder-tr").hide();
    if (vendorId === 'new') {
        $(".add-new-item-new-vendor-details").show();
    } else {
        $(".add-new-item-vendor-details-" + vendorId).show();
    }
}

function popupLoginWindowInputFunctions() {
    var wasTrailingTextAdded = false;
    $("#popup-login-email").click(function () {
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

    $("#popup-login-email").blur(function () {
        var error_div = $('#login-error-div');
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

    $("#password").keyup(function (event) {
        if (event.keyCode === 13) {
            loginUser();
        }
    });
}

function popupLoginUser() {
    var email = $("#popup-login-email").val();
    var password = $("#popup-login-password").val();
    var error_div = $('#popup-login-error-div');
    error_div.html('');

    if (email.length < 1 || password.length < 1) {
        error_div.html("Please fill all the fields properly");
    } else if (!isValidEmailAddress(email)) {
        error_div.html('Please enter a valid e-mail address.');
    } else {
        $('#login-popup-window').css('z-index', '99999');
        $(".gray-out-div").css('z-index', '999999');
        showProgressCircle();
        $.ajax({
            url: "ajax/login.php",
            type: "POST",
            data: "email=" + email +
                    "&password=" + password,
            cache: false,
            dataType: "html",
            success: function (html_response) {
                if (html_response.trim() === "success") {
                    hideLoginPopupWindow();
                } else if (html_response.trim() === "invalid_info"
                        || html_response.trim() === "wrong_combination") {
                    error_div.html("Information you entered does not match with our records");
                } else if (html_response.trim() === "invalid_domain_name") {
                    error_div.html("Please use your '" + DOMAIN_BODY + "' email");
                } else if (html_response.trim() === "invalid_email_address") {
                    error_div.html("Please enter a valid email address");
                } else if (html_response.trim() === "no_activation") {
                    window.location = "/activation";
                } else {
                    error_div.html(html_response);
                }
                $('#login-popup-window').css('z-index', '99999');
                $(".gray-out-div").css('z-index', '999');
                hideProgressCircle();
            }
        });
    }
}

function refreshOrdersTable() {
    $.ajax({
        url: "ajax/refresh-orders-table.php",
        type: "GET",
        cache: false,
        dataType: "json",
        success: function (json_data) {
            if (json_data.status === 'success') {
                $('#orders-table tbody').html(json_data.html_tbody);
                $("#pagination-holder-div").html(json_data.html_pagination);
            } else if (json_data.status === 'no_session') {
                window.location = "/";
            }
        }
    });
}

function showLoginPopupWindow() {
    $('#login-popup-window').fadeIn();
    $('#login-popup-window').css('z-index', '9999999');
    $(".gray-out-div").css('z-index', '999999');
}

function hideLoginPopupWindow() {
    $('#login-popup-window').fadeOut();
    unblockUI();
}

function toggleItemDetailsEditFields(showHide) {
    if (showHide === "show") {
        $(".item-details-input-holder-td input").show();
        $(".item-details-input-holder-td select").show();
        $(".item-details-input-holder-td span").hide();

        $("#item-details-popup-window-edit-icon").fadeOut();
        $("#item-details-popup-window-save-icon").fadeIn();
        $("#item-details-popup-window-cancel-icon").fadeIn();
    } else if (showHide === "hide") {
        hideEditFields();
        updateItemDetails();
    } else {
        setTimeout(hideEditFields(), 1000);
    }
}

function hideEditFields() {
    $(".item-details-input-holder-td span").show();
    $(".item-details-input-holder-td input").hide();
    $(".item-details-input-holder-td select").hide();

    $("#item-details-popup-window-edit-icon").fadeIn();
    $("#item-details-popup-window-save-icon").fadeOut();
    $("#item-details-popup-window-cancel-icon").fadeOut();
}

function prepareItemEditInputs(
        description,
        quantity,
        uom,
        vendor,
        catalogNo,
        price,
        weblink,
        costCenter,
        project,
        comments,
        sds) {

    $("#item-details-popup-window-description").val(decodeEntities(description));
    $("#item-details-popup-window-quantity").val(decodeEntities(quantity));
    $("#item-details-popup-window-uom").val(decodeEntities(uom));
    $("#item-details-popup-window-catalog-no").val(decodeEntities(catalogNo));
    $("#item-details-popup-window-price").val(decodeEntities(price));
    $("#item-details-popup-window-weblink").val(decodeEntities(weblink));
    $("#item-details-popup-window-comments").val(decodeEntities(comments));
    $("#item-details-popup-window-sds").val(decodeEntities(sds));

    if (vendor !== '') {
        $("#item-details-popup-window-vendor > option").each(function () {
            if ($(this).html() === vendor) {
                $(this).prop('selected', true);
            }
        });
    }

    if (costCenter !== '') {
        $("#item-details-popup-window-cost-center option:contains('" + costCenter + "')").prop('selected', true);
    } else {
        $("#item-details-popup-window-cost-center")[0].selectedIndex = 0;
    }

    if (project !== '') {
        $("#item-details-popup-window-project option:contains('" + project + "')").prop('selected', true);
    } else {
        $("#item-details-popup-window-project option:contains('')")[0].selectedIndex = 0;
    }
}

function updateItemDetails() {
    var item_details_popup_window = $("#item-details-popup-window");
    var description = $("#item-details-popup-window-description").val();
    var quantity = $("#item-details-popup-window-quantity").val();
    var uom = $("#item-details-popup-window-uom").val();
    var vendor = $("#item-details-popup-window-vendor").val();
    var catalog_no = $("#item-details-popup-window-catalog-no").val();
    var price = $("#item-details-popup-window-price").val();
    var weblink = $("#item-details-popup-window-weblink").val();
    var cost_center = $("#item-details-popup-window-cost-center").val();
    var project = $("#item-details-popup-window-project").val();
    var comments = $("#item-details-popup-window-comments").val();
    var sds = $("#item-details-popup-window-sds").val();
    var order_id = $("#popup-item-order-number").html();
    var error_div = $('#item-details-popup-window-error-div');
    error_div.html("");
    error_div.html('&nbsp;');
    error_div.css('color', '#cc0000');

    item_details_popup_window.css('z-index', '9');
    showProgressCircle();
    blockUI();
    $.ajax({
        url: "../ajax/update-item-details.php",
        type: "POST",
        data: {
            description: description,
            uom: uom,
            quantity: quantity,
            vendor: vendor,
            catalog_no: catalog_no,
            price: price,
            weblink: weblink,
            cost_center: cost_center,
            project: project,
            comments: comments,
            order_id: order_id,
            sds: sds
        },
        cache: false,
        dataType: "json",
        success: function (json_data) {
            if (json_data.status === 'success') {
                $('#orders-table tbody').html(json_data.html_tbody);
                $("#popup-item-description").html(json_data.description);
                $("#popup-item-quantity").html(json_data.quantity);
                $("#popup-item-uom").html(json_data.uom);
                $("#popup-item-vendor").html(json_data.vendor_name);
                $("#popup-item-catalog-no").html(json_data.catalog_no);
                weblink = json_data.weblink;
                if (weblink !== '') {
                    if (!/^https?:\/\//i.test(weblink)) {
                        weblink = 'http://' + weblink;
                    }
                    weblink = "<a target='_blank' href='" + weblink + "'>Link</a>";
                    $("#popup-item-weblink").html(weblink);
                } else {
                    $("#popup-item-weblink").html('');
                }
                $("#popup-item-price").html("$" + json_data.price);
                var totalPrice = json_data.price * json_data.quantity;
                $("#popup-item-total-price").html("$" + totalPrice.toFixed(2));
                $("#popup-item-cost-center").html(json_data.cost_center_name);
                $("#popup-item-project").html(json_data.project);
                $("#popup-item-comments").html(json_data.comments);
                $("#popup-item-sds").html(json_data.sds);
            } else if (json_data.status === "no_session") {
                showLoginPopupWindow();
            } else if (json_data.status === "status_changed") {
                var err_message = "We couldn't update the order details. The status of this order has already been changed to '" + json_data.latest_status + "'.";
                err_message += "</br>Please contact an admin to make changes on this order.";
                error_div.html(err_message);
            } else {
                error_div.html(json_data.status);
            }
            item_details_popup_window.css('z-index', '9999');
            hideProgressCircle();
        }
    });
}

function msieversion() {
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");

    if (msie > 0) {      // If Internet Explorer, return version number
        return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)));
    } else {
        return false;
    }
}