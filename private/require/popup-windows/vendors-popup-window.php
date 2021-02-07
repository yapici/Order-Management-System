<div class="popup-window admin-popup-window" id="vendors-popup-window">
    <h1>Vendors</h1>
    <a class="popup-window-cancel-button" onclick="hidePopupWindows();">&#10006;</a>
    <table class="admin-popup-window-table" id="vendors-popup-window-vendors-table">
        <thead>
            <tr>
                <td onclick='sortVendor($(this), "id")'>Id <a>&#9650;</a></td>
                <td onclick='sortVendor($(this), "name")'>Name <a>&#9650;</a></td>
                <td onclick='sortVendor($(this), "phone")'>Phone <a>&#9650;</a></td>
                <td onclick='sortVendor($(this), "website")'>Website <a>&#9650;</a></td>
                <td onclick='sortVendor($(this), "address")'>Address <a>&#9650;</a></td>
                <td onclick='sortVendor($(this), "contact_person")'>Contact Person <a>&#9650;</a></td>
                <td onclick='sortVendor($(this), "account_number")'>Account No <a>&#9650;</a></td>
                <td onclick='sortVendor($(this), "added_by")'>Added By <a>&#9650;</a></td>
                <td onclick='sortVendor($(this), "approved")'>Admin Approved <a>&#9650;</a></td>
            </tr>
        </thead>
        <tbody>
            <?php
            $Vendors->populateVendorsTable();
            ?>
        </tbody>
        <tfoot>
            <tr class="empty-row">
                <td colspan="9">&nbsp;</td>
            </tr>
            <tr class="add-new-item-title-tr">
                <td colspan="9">Add New Vendor</td>
            </tr>
            <tr class="add-new-item-input-wrapper-tr">
                <td><b>+</b></td>
                <td><input id="add-new-vendor-name" type="text" placeholder="Name"/></td>
                <td><input id="add-new-vendor-phone" type="text" placeholder="Phone"/></td>
                <td><input id="add-new-vendor-website" type="text" placeholder="Website"/></td>
                <td><input id="add-new-vendor-address" type="text" placeholder="Address"/></td>
                <td><input id="add-new-vendor-contact_person" type="text" placeholder="Contact Person"/></td>
                <td><input id="add-new-vendor-account_number" type="text" placeholder="Account No"/></td>
                <td colspan="3" class="add-new-item-button-holder-td"><a class="button" onclick="addNewVendor();">Add Vendor</a></td>
            </tr>
        </tfoot>
    </table>
    <div class="error-div" id="vendors-popup-window-error-div"></div>
    <div class="admin-popup-window-close-button-holder">
        <a class="button admin-popup-window-close-button" onclick="hidePopupWindows()">Close</a>
    </div>
</div>