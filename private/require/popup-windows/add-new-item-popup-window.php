<a class="popup-window-cancel-button" onclick="hidePopupWindows()">&#10006;</a>
<h1>Add New Item</h1>
<a onclick="clearText();" id="add-new-item-popup-window-clear-button">Clear</a>
<table class="top-panel">
    <tr>
        <td>Description<span class="red-font"> *</span></td>
        <td class="add-new-item-input-holder-td">
            <input id="add-new-item-description" type="text"/>
        </td>
    </tr>      
    <tr>
        <td>Quantity<span class="red-font"> *</span></td>
        <td class="add-new-item-input-holder-td">
            <input id="add-new-item-quantity" type="number"/>
        </td>
    </tr>
    <tr>
        <td>Unit of Measurement<span class="red-font"> *</span></td>
        <td class="add-new-item-input-holder-td">
            <input id="add-new-item-uom" type="text"/>
        </td>
    </tr>
    <tr id="add-new-item-popup-window-vendors-list">
        <?php $Vendors->populateVendorsList(); ?>
    </tr>
    <tr>
        <td>Catalog No<span class="red-font"> *</span></td>
        <td class="add-new-item-input-holder-td">
            <input id="add-new-item-catalog-no" type="text"/>
        </td>
    </tr>  
    <tr>
        <td>Date Needed<span class="red-font"> *</span></td>
        <td class="add-new-item-input-holder-td">
            <input class="datepicker" id="add-new-item-date-needed" type="text" readonly />
        </td>
    </tr>   
    <tr>
        <td>Project<span class="red-font"> *</span></td>
        <td class="add-new-item-input-holder-td">
            <select id="add-new-item-project">
                <option>Please Choose a Project</option>
                <?php $Projects->populateProjectsList(); ?>
            </select>
        </td>
    </tr>
    <tr>
        <td title="Your order will not be processed if you do not complete the Safety Data Sheet (SDS) documentation.">SDS Complete<sup>?</sup><span class="red-font"> *</span></td>
        <td class="add-new-item-input-holder-td">
            <select id="add-new-item-sds">
                <option></option>
                <option>Yes</option>
                <option>No</option>
                <option>N/A</option>
            </select>
        </td>
    </tr> 
    <tr>
        <td>Unit Price (USD)</td>
        <td class="add-new-item-input-holder-td">
            <input id="add-new-item-price" type="number" step="any"/>
        </td>
    </tr> 
    <tr>
        <td>Item Web Link</td>
        <td class="add-new-item-input-holder-td">
            <input id="add-new-item-weblink" type="text"/>
        </td>
    </tr>      
    <tr>
        <td>Cost Center</td>
        <td class="add-new-item-input-holder-td">
            <select id="add-new-item-cost-center">
                <option></option>
                <?php $CostCenters->populateCostCentersList(); ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>Comments</td>
        <td class="add-new-item-input-holder-td">
            <input id="add-new-item-comments" type="text"/>
        </td>
    </tr>
</table>
<hr class="horizontal-divider"></hr>
<div class="bottom-panel">
    <div>
        <h2>Attachments</h2>
        <div id="add-new-item-popup-window-file-upload-elements-wrapper">
            Select a file to upload:
            <input type="file" name="file-to-upload" id="new-item-file-to-upload"/>
            <a class='button file-upload-button' onclick="uploadFile('new-item')">Upload File</a>
            <div><i style="font-size: 0.9em; padding: 10px 0px 20px 0px; display: inline-block;"><b>Maximum file upload size is 10 MB</b></i></div>
        </div>
        <div id="add-new-item-attachments-holder">
            <?php
            if (isset($_SESSION['temp-file-upload-directory'])) {
                $orderId = $_SESSION['temp-file-upload-directory'];
                echo $Functions->includeAttachments($orderId, true);
            }
            ?>
        </div>
    </div>
</div>
<hr class="horizontal-divider"></hr>
<div class="error-div popup-error-div" id="add-new-item-error-div"></div>
<a class="button" onclick="addNewItem()">Submit</a>
<a class="button" onclick="hidePopupWindows()">Close</a>

