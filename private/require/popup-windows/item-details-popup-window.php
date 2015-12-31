<?php
/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 10/26/2015                                                                 */
/* Last modified on 12/31/2015                                                           */
/* ===================================================================================== */

/* ===================================================================================== */
/* The MIT License                                                                       */
/*                                                                                       */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>.                                 */
/*                                                                                       */
/* Permission is hereby granted, free of charge, to any person obtaining a copy          */
/* of this software and associated documentation files (the "Software"), to deal         */
/* in the Software without restriction, including without limitation the rights          */
/* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell             */
/* copies of the Software, and to permit persons to whom the Software is                 */
/* furnished to do so, subject to the following conditions:                              */
/*                                                                                       */
/* The above copyright notice and this permission notice shall be included in            */
/* all copies or substantial portions of the Software.                                   */
/*                                                                                       */
/* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR            */
/* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,              */
/* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE           */
/* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER                */
/* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,         */
/* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN             */
/* THE SOFTWARE.                                                                         */
/* ===================================================================================== */

$isAdmin = false;
if ($Admin->isAdmin()) {
    echo "<script type='text/javascript'>";
    require(PRIVATE_PATH . 'require/js/item-details-popup-window-functions.js');
    echo "</script>";
    $isAdmin = true;
}
?>


<div class="popup-window" id="item-details-popup-window">
    <a class="popup-window-cancel-button" onclick="hidePopupWindows();<?php if ($isAdmin) echo ' toggleItemDetailsPopupInputFields();'; ?>">&#10006;</a>
    <h1 id="popup-item-order-number">Order </h1>
    <?php
    if ($isAdmin) {
        echo "<div id='item-details-popup-window-edit-icon-wrapper'>";
        echo "<a class='item-details-popup-window-icons' id='item-details-popup-window-edit-icon' onclick='toggleItemDetailsPopupInputFields(\"show\");' title='Edit Order Details'>";
        echo "<img src='images/edit-icon.png'/>";
        echo "</a>";
        echo "<a class='item-details-popup-window-icons' id='item-details-popup-window-save-icon' onclick='toggleItemDetailsPopupInputFields(\"hide\");' title='Save Changes'>";
        echo "<img src='images/tick-icon.png'/>";
        echo "</a>";
        echo "<a class='item-details-popup-window-icons' id='item-details-popup-window-cancel-icon' onclick='hideEditFields();' title='Discard Changes'>";
        echo "<img src='images/cancel-icon.png'/>";
        echo "</a>";
        echo "</div>";
    }
    ?>

    <table class="top-panel panel-table">
        <tr>
            <td class="left-panel">
                <table>
                    <tr>
                        <td>Description:</td>
                        <td class="item-details-input-holder-td">
                            <span id="popup-item-description"></span>
                            <?php if ($isAdmin) echo '<input id="item-details-popup-window-description" type="text"/>'; ?>
                        </td>
                    </tr>      
                    <tr>
                        <td>Quantity:</td>
                        <td class="item-details-input-holder-td">
                            <span id="popup-item-quantity"></span>
                            <?php if ($isAdmin) echo '<input id="item-details-popup-window-quantity" type="number"/>'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td title="Unit of Measurement">UoM:</td>
                        <td class="item-details-input-holder-td">
                            <span id="popup-item-uom"></span>
                            <?php if ($isAdmin) echo '<input id="item-details-popup-window-uom" type="text"/>'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Vendor:</td>
                        <td class="item-details-input-holder-td">
                            <span id="popup-item-vendor"></span>
                            <?php
                            if ($isAdmin) {
                                $ItemDetails->getVendors();
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Catalog No:</td>
                        <td class="item-details-input-holder-td">
                            <span id="popup-item-catalog-no"></span>
                            <?php if ($isAdmin) echo '<input id="item-details-popup-window-catalog-no" type="text"/>'; ?>
                        </td>
                    </tr>              
                </table>
            </td>
            <td class="right-panel">
                <table> 
                    <tr>
                        <td>Price:</td>
                        <td class="item-details-input-holder-td">
                            <span id="popup-item-price"></span>
                            <?php if ($isAdmin) echo '<input id="item-details-popup-window-price" type="number" step="any"/>'; ?>
                        </td>
                    </tr>   
                    <tr>
                        <td>Item Web Link:</td>
                        <td class="item-details-input-holder-td">
                            <span id="popup-item-weblink"></span>
                            <?php if ($isAdmin) echo '<input id="item-details-popup-window-weblink" type="text"/>'; ?>
                        </td>
                    </tr>  
                    <tr>
                        <td>Cost Center:</td>
                        <td class="item-details-input-holder-td">
                            <span id="popup-item-cost-center"></span>
                            <?php
                            if ($isAdmin) {
                                echo '<select id="item-details-popup-window-cost-center">';
                                echo '<option></option>';
                                $CostCenters->populateCostCentersList();
                                echo '</select>';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Project Name:</td>
                        <td class="item-details-input-holder-td">
                            <span id="popup-item-project"></span>
                            <?php
                            if ($isAdmin) {
                                echo '<select id="item-details-popup-window-project">';
                                echo '<option></option>';
                                $Projects->populateProjectsList();
                                echo '</select>';
                            }
                            ?>
                        </td>
                    </tr>   
                    <tr>
                        <td>Comments:</td>
                        <td class="item-details-input-holder-td">
                            <span id="popup-item-comments"></span>
                            <?php if ($isAdmin) echo '<input id="item-details-popup-window-comments" type="text"/>'; ?>
                        </td>
                    </tr>  
                </table>
            </td>
        </tr>
    </table>
    <hr class="horizontal-divider"></hr>
    <table class="panel-table">
        <tr>
            <td class='left-panel'>
                <table>
                    <tr>
                        <td>Status:</td>
                        <td class="item-details-input-holder-td">
                            <span id="popup-item-status"></span>
                            <?php
                            if ($isAdmin) {
                                echo '<select id="item-details-popup-window-status">';
                                echo '<option>Pending</option>';
                                echo '<option>Processing</option>';
                                echo '<option>Ordered</option>';
                                echo '<option>Delivered</option>';
                                echo '<option>Backordered</option>';
                                echo '</select>';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Last Updated By:</td>
                        <td>
                            <span id="popup-item-status-updated-by"></span>&nbsp;on&nbsp;
                            <span id="popup-item-status-updated-date"></span>
                        </td>
                    </tr>
                    <tr id='popup-item-status-ordered-tr'>
                        <td>Ordered By:</td>
                        <td>
                            <span id="popup-item-status-ordered-by"></span>&nbsp;on&nbsp;
                            <span id="popup-item-status-ordered-date"></span>
                        </td>
                    </tr>
                </table>
            </td>
            <td class="right-panel">
                <table>
                    <tr>
                        <td>Item Requested By:</td>
                        <td>
                            <span id="popup-item-requested-by"></span>&nbsp;on&nbsp;
                            <span id="popup-item-requested-date"></span>
                        </td>
                    </tr>
                    <tr>
                        <td>Item Needed By:</td>
                        <td>
                            <span id="popup-item-item-needed-by"></span>
                        </td>
                    </tr> 
                </table>
            </td>
        </tr>
    </table>
    <?php if ($isAdmin) { ?>
        <hr class="horizontal-divider"></hr>
        <h2 id="admin-area-h2">Admin Area</h2>
        <div><i style="font-size: 0.8em;">(This section is visible only to administrators)</i></div>
        <table class="panel-table">
            <tr>
                <td class='left-panel'>
                    <table>
                        <tr>
                            <td>Vendor Account No:</td>
                            <td>
                                <span id="popup-item-vendor-account-no"></span>
                            </td>
                        </tr>  
                        <tr>
                            <td>Invoice No:</td>
                            <td class="item-details-input-holder-td">
                                <span id="popup-item-invoice-no"></span>
                                <input id="item-details-popup-window-invoice-no" type="text"/>
                            </td>
                        </tr>  
                        <tr>
                            <td>Vendor Order No:</td>
                            <td class="item-details-input-holder-td">
                                <span id="popup-item-vendor-order-no"></span>
                                <input id="item-details-popup-window-vendor-order-no" type="text"/>
                            </td>
                        </tr>  
                    </table>
                </td>
                <td class="right-panel">
                    <table id='admin-file-upload-table'>
                        <tr>
                            <td>Attachments:</td>
                            <td id='admin-file-upload-td'>
                                <input type="file" name="admin-file-to-upload" id="item-details-admin-file-to-upload"/>
                                <input type="hidden" id="admin-file-upload-order-id"/>
                                <a class='button' id='admin-file-upload-button' onclick="uploadAdminFile()">Upload File</a>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td id='admin-files-holder-td'></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    <?php } ?>
    <hr class="horizontal-divider"></hr>
    <div id="item-details-popup-window-attachments-wrapper">
        <h2>Attachments</h2>
        <?php if ($isAdmin) { ?>
            <div id="item-details-popup-window-file-upload-elements-wrapper">
                Select a file to upload:
                <input type="file" name="file-to-upload" id="item-details-file-to-upload"/>
                <input type="hidden" name="file_upload_order_id" id="file-upload-order-id"/>
                <a class='button file-upload-button' onclick="uploadFile('item-details')">Upload File</a>
                <div><i style="font-size: 0.9em; padding: 10px 0px 20px 0px; display: inline-block;"><b>Maximum file upload size is 10 MB</b></i></div>
            </div>
        <?php } ?>
        <div id="item-details-attachments-holder"></div>
    </div>
    <div class="error-div popup-error-div" id="item-details-popup-window-error-div"></div>
    <a class="button" onclick="reorder();">Reorder</a>
    <a class="button" onclick="hidePopupWindows();<?php if ($isAdmin) echo ' toggleItemDetailsPopupInputFields();'; ?>">Close</a>
</div>

