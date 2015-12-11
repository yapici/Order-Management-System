<?php
/* ================================================================ */
/* Created by Engin Yapici on 10/26/2015                            */
/* Last modified by Engin Yapici on 10/26/2015                      */
/* Copyright Engin Yapici, 2015.                                    */
/* enginyapici@gmail.com                                            */
/* ================================================================ */
?>
<div class="popup-window" id="item-details-popup-window">
    <h1 id="popup-item-order-number">Order 100003</h1>
    <table class="top-panel">
        <tr>
            <td class="left-panel">
                <table>
                    <tr>
                        <td>Description</td>
                        <td class="add-new-item-input-holder-td">
                            <span id="popup-item-description">GSTag Columns</span>
                            <a class="edit-button"><img src="images/edit-icon.png"/></a>
                        </td>
                    </tr>      
                    <tr>
                        <td>Quantity</td>
                        <td class="add-new-item-input-holder-td">
                            <span id="popup-item-quantity">1</span>
                            <a class="edit-button"><img src="images/edit-icon.png"/></a>
                        </td>
                    </tr>
                    <tr>
                        <td>Unit of Measurement</td>
                        <td class="add-new-item-input-holder-td">
                            <span id="popup-item-uom">5/Box</span>
                            <a class="edit-button"><img src="images/edit-icon.png"/></a>
                        </td>
                    </tr>
                    <tr>
                        <td>Vendor</td>
                        <td class="add-new-item-input-holder-td">
                            <span id="popup-item-vendor">Biorad</span>
                            <a class="edit-button"><img src="images/edit-icon.png"/></a>
                        </td>
                    </tr>
                    <tr>
                        <td>Catalog No</td>
                        <td class="add-new-item-input-holder-td">
                            <span id="popup-item-catalog-no">12345</span>
                            <a class="edit-button"><img src="images/edit-icon.png"/></a>
                        </td>
                    </tr>                 
                </table>
            </td>
            <td class="right-panel">
                <table>
                    <tr>
                        <td>Price</td>
                        <td class="add-new-item-input-holder-td">
                            <span id="popup-item-price">$350.00</span>
                            <a class="edit-button"><img src="images/edit-icon.png"/></a>
                        </td>
                    </tr>  
                    <tr>
                        <td>Cost Center, Project Name, Project No</td>
                        <td class="add-new-item-input-holder-td">
                            <span id="popup-item-cost-center">BioA</span>
                            <a class="edit-button"><img src="images/edit-icon.png"/></a>
                        </td>
                    </tr>  
                    <tr>
                        <td>Account Number</td>
                        <td class="add-new-item-input-holder-td">
                            <span id="popup-item-account-no">0987654</span>
                            <a class="edit-button"><img src="images/edit-icon.png"/></a>
                        </td>
                    </tr>  
                    <tr>
                        <td>Comments</td>
                        <td class="add-new-item-input-holder-td">
                            <span id="popup-item-comments">None</span>
                            <a class="edit-button"><img src="images/edit-icon.png"/></a>
                        </td>
                    </tr>  
                    <tr>
                        <td>Item Requested By</td>
                        <td>
                            <span id="popup-item-requested-by">Engin Yapici</span>
                            <span id="popup-item-requested-date">on 22-Oct-2015 14:43 (GMT -05:00)</span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    <hr class="horizontal-divider"></hr>
    <div class="bottom-panel">
        <table>
            <tr>
                <td>Status</td><td id="popup-item-status">Ordered</td>
            </tr>
            <tr>
                <td>Last Updated By</td>
                <td>
                    <span id="popup-item-last-updated-by">Steve Ennis</span>
                    <span id="popup-item-last-updated-date">on 22-Oct-2015 14:43 (GMT -05:00)</span>
                </td>
            </tr>
        </table>
        <hr class="horizontal-divider"></hr>
        <div id="attachments-holder">
            <h2>Attachments</h2>
            <?php
            $attachments_directory_path = '../private/attachments';
            if (is_dir($attachments_directory_path)) {
                $attachments_file_names = scandir($attachments_directory_path);
                for ($i = 0; $i < count($attachments_file_names); $i++) {
                    if ($attachments_file_names[$i] !== '..' &&
                            $attachments_file_names[$i] !== '.' &&
                            $attachments_file_names[$i] !== 'index.php' &&
                            $attachments_file_names[$i] !== 'archived') {
                        $encrypted_file_path = $Functions->encode($JobId . '/' . $attachments_file_names[$i]);
                        echo "<div class='file'><a href='download.php/?file=$encrypted_file_path'>$attachments_file_names[$i]</a>"
                        . "&nbsp;&nbsp;&nbsp;"
                        . "<a class='button delete-button' onclick=\"deleteFile('$encrypted_file_path')\">Delete</a></div>";
                    }
                }
            }
            ?>
        </div>
    </div>
    <a class="button" onclick="hidePopupWindow()">Close</a>
</div>

