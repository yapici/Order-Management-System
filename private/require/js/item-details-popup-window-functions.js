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
        status) {

    $("#item-details-popup-window-description").val(description);
    $("#item-details-popup-window-quantity").val(quantity);
    $("#item-details-popup-window-uom").val(uom);
    $("#item-details-popup-window-catalog-no").val(catalogNo);
    $("#item-details-popup-window-price").val(price);
    $("#item-details-popup-window-weblink").val(weblink);
    $("#item-details-popup-window-comments").val(comments);

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
    var error_div = $('#item-details-popup-window-error-div');
    error_div.html("");
    error_div.html('&nbsp;');
    error_div.css('color', '#cc0000');

    item_details_popup_window.css('z-index', '9');
    showProgressCircle();
    blockUI();
    $.ajax({
        url: "../ajax/admin/update-item-details.php",
        type: "POST",
        data: "description=" + description +
                "&quantity=" + quantity +
                "&uom=" + uom +
                "&vendor=" + vendor +
                "&catalog_no=" + catalog_no +
                "&price=" + price +
                "&weblink=" + weblink +
                "&cost_center=" + cost_center +
                "&project=" + project +
                "&comments=" + comments +
                "&order_id=" + order_id +
                "&status=" + status,
        cache: false,
        dataType: "json",
        success: function (json_data) {
            if (json_data.status === 'success') {
                $('#orders-table tbody').html(json_data.html_tbody);
                $("#popup-item-description").html(description);
                $("#popup-item-quantity").html(quantity);
                $("#popup-item-uom").html(uom);
                $("#popup-item-vendor").html(vendor_name);
                $("#popup-item-catalog-no").html(catalog_no);
                if (weblink !== '') {
                    if (!/^https?:\/\//i.test(weblink)) {
                        weblink = 'http://' + weblink;
                    }
                    weblink = "<a href='" + weblink + "'>Link</a>";
                    $("#popup-item-weblink").html(weblink);
                } else {
                    $("#popup-item-weblink").html('');
                }
                $("#popup-item-weblink").html(weblink);
                $("#popup-item-price").html(price);
                $("#popup-item-cost-center").html(json_data.cost_center_name);
                $("#popup-item-project").html(json_data.project);
                $("#popup-item-comments").html(comments);
                $("#popup-item-status").html(status);
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
        accountNo,
        vendorOrderNo,
        invoiceNo
        ) {
        $("#popup-item-vendor-account-no").html(accountNo);

}