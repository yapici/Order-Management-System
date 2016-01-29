var initial_order_status = '';
var vendor_account_no = '';

function prepareItemDetailsPopupWindowInputs(
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
        invoiceNo,
        vendorOrderNo,
        status) {

    $("#item-details-popup-window-description").val(decodeEntities(description));
    $("#item-details-popup-window-quantity").val(decodeEntities(quantity));
    $("#item-details-popup-window-uom").val(decodeEntities(uom));
    $("#item-details-popup-window-catalog-no").val(decodeEntities(catalogNo));
    $("#item-details-popup-window-price").val(decodeEntities(price));
    $("#item-details-popup-window-weblink").val(decodeEntities(weblink));
    $("#item-details-popup-window-comments").val(decodeEntities(comments));
    $("#item-details-popup-window-invoice-no").val(decodeEntities(invoiceNo));
    $("#item-details-popup-window-vendor-order-no").val(decodeEntities(vendorOrderNo));

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

    $("#item-details-popup-window-status option:contains('" + status + "')").prop('selected', true);
}

function toggleItemDetailsPopupInputFields(showHide) {
    if (showHide === "show") {
        $(".item-details-input-holder-td input").show();
        $(".item-details-input-holder-td select").show();
        $(".item-details-input-holder-td span").hide();

        $("#item-details-popup-window-edit-icon").fadeOut();
        $("#item-details-popup-window-save-icon").fadeIn();
        $("#item-details-popup-window-cancel-icon").fadeIn();

        vendor_account_no = $("#popup-item-vendor-account-no").html();
        $("#popup-item-vendor-account-no").html('<i>Please use vendors window to edit</i>');

        initial_order_status = $("#item-details-popup-window-status").val();
    } else if (showHide === "hide") {
        hideEditFields();
        updateOrderDetails();
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

    $("#popup-item-vendor-account-no").html(vendor_account_no);
}

function updateOrderDetails() {
    var item_details_popup_window = $("#item-details-popup-window");
    var description = $("#item-details-popup-window-description").val();
    var quantity = $("#item-details-popup-window-quantity").val();
    var uom = $("#item-details-popup-window-uom").val();
    var vendor = $("#item-details-popup-window-vendor").val();
    var vendor_name = $("#item-details-popup-window-vendor option:selected").html();
    var catalog_no = $("#item-details-popup-window-catalog-no").val();
    var price = $("#item-details-popup-window-price").val();
    var weblink = $("#item-details-popup-window-weblink").val();
    var cost_center = $("#item-details-popup-window-cost-center").val();
    var project = $("#item-details-popup-window-project").val();
    var comments = $("#item-details-popup-window-comments").val();
    var order_id = $("#popup-item-order-number").html();
    var status = $("#item-details-popup-window-status").val();
    var invoice_no = $("#item-details-popup-window-invoice-no").val();
    var vendor_order_no = $("#item-details-popup-window-vendor-order-no").val();
    var error_div = $('#item-details-popup-window-error-div');
    error_div.html("");
    error_div.html('&nbsp;');
    error_div.css('color', '#cc0000');

    if (status === initial_order_status) {
        status = 'no_change';
    }

    item_details_popup_window.css('z-index', '9');
    showProgressCircle();
    blockUI();
    $.ajax({
        url: "../ajax/admin/update-item-details.php",
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
            invoice_no: invoice_no,
            vendor_order_no: vendor_order_no,
            status: status
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
                $("#popup-item-cost-center").html(json_data.cost_center_name);
                $("#popup-item-project").html(json_data.project);
                $("#popup-item-comments").html(json_data.comments);
                if (status !== 'no_change') {
                    $("#popup-item-status").html(status);
                }
                $("#popup-item-invoice-no").html(json_data.invoice_no);
                $("#popup-item-vendor-order-no").html(json_data.vendor_order_no);
            } else if (json_data.status === "no_session") {
                showLoginPopupWindow();
            } else if (json_data.status === "unauthorized_access") {
                location.reload();
            } else {
                error_div.html(json_data.status);
            }
            item_details_popup_window.css('z-index', '9999');
            hideProgressCircle();
        }
    });
}

function showItemDetailsPopupWindowAdmin(
        orderId,
        accountNo,
        invoiceNo,
        vendorOrderNo) {
    $("#popup-item-vendor-account-no").html(accountNo);
    $("#popup-item-invoice-no").html(invoiceNo);
    $("#popup-item-vendor-order-no").html(vendorOrderNo);
    $("#admin-file-upload-order-id").val(orderId);

    showProgressCircle();
    $.ajax({
        url: "ajax/admin/populate-attachments.php",
        type: "GET",
        data: "order_id=" + orderId,
        cache: false,
        dataType: "json",
        success: function (json_response) {
            if (json_response.html_response !== 'no_session') {
                $("#admin-files-holder-td").html(json_response.html_response);
            } else {
                showLoginPopupWindow();
            }
            hideProgressCircle();
        }
    });
}

function uploadAdminFile() {
    var form_data = new FormData();

    var file_input = $('#item-details-admin-file-to-upload');
    var file_data = file_input.prop('files')[0];

    form_data.append('admin-file-to-upload', file_data);
    form_data.append('admin-file-upload-order-id', $("#admin-file-upload-order-id").val());

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
            url: 'ajax/admin/upload-file.php',
            type: 'POST',
            data: form_data,
            cache: false,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (json_response) {
                if (json_response.status === 'success') {
                    $("#admin-files-holder-td").html(json_response.html_response);
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

function deleteAdminAttachment(file) {
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
                $("#admin-files-holder-td").html(json_response.html_response);
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