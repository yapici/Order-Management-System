(document).ready(function() {

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
        accountNo,
        comments,
        requestedByUserId,
        requestedDate,
        lastUpdatedByUserId,
        lastUpdatedDate,
        status) {
    blockUI();

    populateUsernamesInItemDetailsPopupWindow(requestedByUserId, lastUpdatedByUserId);

    $("#popup-item-order-number").html("Order " + orderNo);
    $("#popup-item-description").html(description);
    $("#popup-item-quantity").html(quantity);
    $("#popup-item-uom").html(uom);
    $("#popup-item-vendor").html(vendor);
    $("#popup-item-catalog-no").html(catalogNo);
    $("#popup-item-price").html("$" + price);
    $("#popup-item-cost-center").html(costCenter);
    $("#popup-item-account-no").html(accountNo);
    $("#popup-item-comments").html(comments);
    $("#popup-item-last-updated-date").html("on " + lastUpdatedDate);
    $("#popup-item-requested-date").html("on " + requestedDate);

    $("#item-details-popup-window").fadeIn();
}

function populateUsernamesInItemDetailsPopupWindow(requestedByUserId, lastUpdatedByUserId) {
    showProgressCircle();
    $.ajax({
        url: "ajax/get-usernames.php",
        type: "GET",
        data: "requestedByUserId=" + requestedByUserId
                + "&lastUpdatedByUserId=" + lastUpdatedByUserId,
        cache: false,
        dataType: "html",
        success: function(html_response) {
            if (html_response !== 'fail') {
                var usernames = html_response.split(',');
                $('#popup-item-requested-by').html(usernames[0]);
                $("#popup-item-last-updated-by").html(usernames[1]);
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
    var description = encodeURIComponent($("#add-new-item-description").val());
    var quantity = encodeURIComponent($("#add-new-item-quantity").val());
    var uom = encodeURIComponent($("#add-new-item-uom").val());
    var vendor = encodeURIComponent($("#add-new-item-vendor").val());
    var catalog_no = encodeURIComponent($("#add-new-item-catalog-no").val());
    var price = encodeURIComponent($("#add-new-item-price").val());
    var cost_center = encodeURIComponent($("#add-new-item-cost-center").val());
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
                    "&account_no=" + account_no +
                    "&comments=" + comments,
            cache: false,
            dataType: "json",
            success: function(json_data) {
                if (json_data.status === 'success') {
                    $('#orders-table tbody').html(json_data.html_tbody);
                    unblockUI();
                    add_new_item_popup_window.fadeOut();
                } else {
                    error_div.html(json_data.status);
                    add_new_item_popup_window.css('z-index', '9999');
                }
                hideProgressCircle();
            }
        });
    }
}