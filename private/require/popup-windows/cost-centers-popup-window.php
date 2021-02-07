<div class="popup-window admin-popup-window" id="cost-centers-popup-window">
    <h1>Cost Centers</h1>
    <a class="popup-window-cancel-button" onclick="hidePopupWindows();">&#10006;</a>
    <table class="admin-popup-window-table" id="cost-centers-popup-window-cost-centers-table">
        <thead>
            <tr>
                <td>Id</td>
                <td>Cost Center Name</td>
                <td>Active</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $CostCenters->populateCostCentersTable();
            ?>
        </tbody>
        <tfoot>
            <tr class="empty-row">
                <td colspan="9">&nbsp;</td>
            </tr>
            <tr class="add-new-item-title-tr">
                <td colspan="9">Add New Cost Center</td>
            </tr>
            <tr class="add-new-item-input-wrapper-tr">
                <td><b>+</b></td>
                <td><input id="add-new-cost-center-name" type="text" placeholder="Name"/></td>
                <td colspan="3" class="add-new-item-button-holder-td"><a class="button" onclick="addNewCostCenter();">Add Cost Center</a></td>
            </tr>
        </tfoot>
    </table>
    <div class="error-div" id="cost-centers-popup-window-error-div"></div>
    <div class="admin-popup-window-close-button-holder">
        <a class="button admin-popup-window-close-button" onclick="hidePopupWindows()">Close</a>
    </div>
</div>
