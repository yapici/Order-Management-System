function showItemDetailsPopupWindowItems(description,
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
        status) {

    $("#item-details-popup-window-description").val(description);
    $("#item-details-popup-window-quantity").val(quantity);
    $("#item-details-popup-window-uom").val(uom);
    $("#item-details-popup-window-catalog-no").val(catalogNo);
    $("#item-details-popup-window-price").val(price);
    if (costCenter !== '') {
        $("#item-details-popup-window-vendor > option").each(function () {
            if ($(this).html() === vendor) {
                $(this).prop('selected', true);
            }
        });
    }
    if (costCenter !== '') {
        $("#item-details-popup-window-cost-center option:contains('" + costCenter + "')").prop('selected', true);
    }
    if (projectName !== '') {
        $("#item-details-popup-window-project-name option:contains('" + projectName + "')").prop('selected', true);
    }
    if (projectNo !== '') {
        $("#item-details-popup-window-project-no option:contains('" + projectNo + "')").prop('selected', true);
    }
    if (accountNo !== '') {
        $("#item-details-popup-window-account-no option:contains('" + accountNo + "')").prop('selected', true);
    }
    $("#item-details-popup-window-comments").val(comments);
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
    var cost_center = $("#item-details-popup-window-cost-center").val();
    var project_name = $("#item-details-popup-window-project-name").val();
    var project_no = $("#item-details-popup-window-project-no").val();
    var account_no = $("#item-details-popup-window-account-no").val();
    var comments = $("#item-details-popup-window-comments").val();
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
                "&comments=" + comments +
                "&order_id=" + order_id,
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
                $("#popup-item-price").html(price);
                $("#popup-item-cost-center").html(cost_center);
                $("#popup-item-project-name").html(project_name);
                $("#popup-item-project-no").html(project_no);
                $("#popup-item-account-no").html(account_no);
                $("#popup-item-comments").html(comments);
                unblockUI();
            } else {
                error_div.html(json_data.status);
            }
            item_details_popup_window.css('z-index', '9999');
            hideProgressCircle();
        }
    });
}