$(function () {
    $("#orders-search-input").keyup(function (event) {
        if (event.keyCode === 13) {
            searchAction('search');
        }
    });

    datepickerFunctions();
});

function hidePopupWindow() {
    $(".popup-window").fadeOut();
    unblockUI();
}

function showItemDetailsPopupWindow(
        orderNo,
        description,
        quantity,
        uom,
        vendor,
        catalogNo,
        price,
        costCenter,
        projectName,
        projectNo,
        accountNo,
        comments,
        requestedByUsername,
        requestedDate,
        lastUpdatedByUsername,
        lastUpdatedDate,
        status,
        itemNeededByDate) {
    blockUI();

    $("#popup-item-order-number").html("Order " + orderNo);
    $("#popup-item-description").html(description);
    $("#popup-item-quantity").html(quantity);
    $("#popup-item-uom").html(uom);
    $("#popup-item-vendor").html(vendor);
    $("#popup-item-catalog-no").html(catalogNo);
    $("#popup-item-price").html("$" + price);
    $("#popup-item-cost-center").html(costCenter);
    $("#popup-item-project-name").html(projectName);
    $("#popup-item-project-no").html(projectNo);
    $("#popup-item-account-no").html(accountNo);
    $("#popup-item-comments").html(comments);
    $("#popup-item-last-updated-date").html("on " + lastUpdatedDate);
    $("#popup-item-requested-date").html("on " + requestedDate);
    $('#popup-item-requested-by').html(requestedByUsername);
    $("#popup-item-last-updated-by").html(lastUpdatedByUsername);
    $("#popup-item-item-needed-by").html(itemNeededByDate);

    if (typeof showItemDetailsPopupWindowItems === 'function') {
        showItemDetailsPopupWindowItems(description,
                quantity,
                uom,
                vendor,
                catalogNo,
                price,
                costCenter,
                projectName,
                projectNo,
                accountNo,
                comments,
                status);
    }

    showProgressCircle();
    $.ajax({
        url: "ajax/populate-attachments.php",
        type: "GET",
        data: "order_id=" + orderNo,
        cache: false,
        dataType: "json",
        success: function (json_response) {
            if (json_response.html_response !== 'no_session') {
                $("#attachments-holder").html(json_response.html_response);
                $("#item-details-popup-window").fadeIn();
            } else {
                // show popup login
            }
            hideProgressCircle();
        }
    });
}

function showAddNewItemPopupWindow() {
    blockUI();
    $("#add-new-item-popup-window").fadeIn();
}

function addNewItem() {
    var add_new_item_popup_window = $("#add-new-item-popup-window");
    var description = $("#add-new-item-description").val();
    var quantity = $("#add-new-item-quantity").val();
    var uom = $("#add-new-item-uom").val();
    var vendor = $("#add-new-item-vendor").val();
    var catalog_no = $("#add-new-item-catalog-no").val();
    var price = $("#add-new-item-price").val();
    var cost_center = $("#add-new-item-cost-center").val();
    var project_name = $("#add-new-item-project-name").val();
    var project_no = $("#add-new-item-project-no").val();
    var account_no = $("#add-new-item-account-no").val();
    var comments = $("#add-new-item-comments").val();
    var error_div = $('#add-new-item-error-div');
    error_div.html("");
    error_div.html('&nbsp;');
    error_div.css('color', '#cc0000');
    if (description === ''
            || quantity === ''
            || uom === ''
            || vendor === ''
            || catalog_no === ''
            || price === '') {
        error_div.html("Please fill all the mandatory fields");
    } else {
        add_new_item_popup_window.css('z-index', '9');
        showProgressCircle();
        blockUI();
        $.ajax({
            url: "../ajax/add-new-item-action.php",
            type: "POST",
            data: "description=" + description +
                    "&quantity=" + quantity +
                    "&uom=" + uom +
                    "&vendor=" + vendor +
                    "&catalog_no=" + catalog_no +
                    "&price=" + price +
                    "&cost_center=" + cost_center +
                    "&project_name=" + project_name +
                    "&project_no=" + project_no +
                    "&account_no=" + account_no +
                    "&comments=" + comments,
            cache: false,
            dataType: "json",
            success: function (json_data) {
                if (json_data.status === 'success') {
                    $('#orders-table tbody').html(json_data.html_tbody);
                    unblockUI();
                    add_new_item_popup_window.fadeOut();
                } else {
                    error_div.html(json_data.status);
                }
                add_new_item_popup_window.css('z-index', '9999');
                hideProgressCircle();
            }
        });
    }
}

function deleteAttachment(filepath) {
    var error_div = $("#item-details-popup-window-error-div");
    showProgressCircle();
    $.ajax({
        url: "ajax/delete-attachment.php",
        type: "GET",
        data: "file=" + filepath,
        cache: false,
        dataType: "html",
        success: function (html_response) {
            if (html_response !== 'error') {
                if ($("#add-new-item-popup-window").is(":visible")) {
                    $("#add-new-item-attachments-holder").html(html_response);
                } else {
                    $("#attachments-holder").html(html_response);
                }
            } else {
                error_div.html("Something went wrong, please try again later.");
            }
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
                //showLoginPopupWindow();
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

                if (action === 'search' && keywords !== "") {
                    $('#orders-search-cancel-button').show();
                } else {
                    $('#orders-search-cancel-button').hide();
                    $('#orders-search-input').val('');
                }
                unblockUI();
            } else if (json_data.status === "no_session") {
                //showLoginPopupWindow();
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
                //showLoginPopupWindow();
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
                dateFormat: 'd-M-y',
                onSelect: function (dateText) {
                    var input = $(this);
                    input.css('color', '#1C4D6F');
                    input.change();
                }
            });

        });
    });
}

function uploadFile() {
    var file_data = $('#file-to-upload').prop('files')[0];
    var form_data = new FormData();
    form_data.append('file-to-upload', file_data);
    $.ajax({
        url: 'ajax/upload-file.php',
        type: 'POST',
        data: form_data,
        cache: false,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function (json_data) {
            if (json_data.status === 'success') {
                $("#add-new-item-attachments-holder").html(json_data.html_response);
            }
        }
    });
}