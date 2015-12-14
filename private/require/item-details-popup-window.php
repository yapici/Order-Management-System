<?php
/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 10/26/2015                                                                 */
/* Last modified on 12/14/2015                                                           */
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
if ($_SESSION['user_type'] == '1' || $_SESSION['user_type'] == '2') {
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

    <table class="top-panel">
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
                            <?php if ($isAdmin) echo '<input id="item-details-popup-window-vendor" type="text"/>'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Catalog No:</td>
                        <td class="item-details-input-holder-td">
                            <span id="popup-item-catalog-no"></span>
                            <?php if ($isAdmin) echo '<input id="item-details-popup-window-catalog-no" type="text"/>'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Price:</td>
                        <td class="item-details-input-holder-td">
                            <span id="popup-item-price"></span>
                            <?php if ($isAdmin) echo '<input id="item-details-popup-window-price" type="number" step="any"/>'; ?>
                        </td>
                    </tr>                  
                </table>
            </td>
            <td class="right-panel">
                <table> 
                    <tr>
                        <td>Cost Center:</td>
                        <td class="item-details-input-holder-td">
                            <span id="popup-item-cost-center"></span>
                            <?php
                            if ($isAdmin) {
                                echo '<select id="item-details-popup-window-cost-center">';
                                echo '<option></option>';
                                echo '<option>1234ZYZ</option>';
                                echo '<option>9876ABCD</option>';
                                echo '</select>';
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Project Name:</td>
                        <td class="item-details-input-holder-td">
                            <span id="popup-item-project-name"></span>
                            <?php
                            if ($isAdmin) {
                                echo '<select id="item-details-popup-window-project-name">';
                                echo '<option></option>';
                                echo '<option>Project 1</option>';
                                echo '<option>Project 2</option>';
                                echo '</select>';
                            }
                            ?>
                        </td>
                    </tr> 
                    <tr>
                        <td>Project No:</td>
                        <td class="item-details-input-holder-td">
                            <span id="popup-item-project-no"></span>
                            <?php
                            if ($isAdmin) {
                                echo '<select id="item-details-popup-window-project-no">';
                                echo '<option></option>';
                                echo '<option>1234ZYZ</option>';
                                echo '<option>9876ABCD</option>';
                                echo '</select>';
                            }
                            ?>
                        </td>
                    </tr>   
                    <tr>
                        <td>Account Number:</td>
                        <td class="item-details-input-holder-td">
                            <span id="popup-item-account-no"></span>
                            <?php
                            if ($isAdmin) {
                                echo '<select id="item-details-popup-window-account-no">';
                                echo '<option></option>';
                                echo '<option>ABCD12345XYZ</option>';
                                echo '<option>XYZ12345ABCD</option>';
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
                    <tr>
                        <td>Item Requested By:</td>
                        <td>
                            <span id="popup-item-requested-by"></span>
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
    <hr class="horizontal-divider"></hr>
    <div class="bottom-panel">
        <table>
            <tr>
                <td>Status:</td><td id="popup-item-status"></td>
            </tr>
            <tr>
                <td>Last Updated By:</td>
                <td>
                    <span id="popup-item-last-updated-by"></span>
                    <span id="popup-item-last-updated-date"></span>
                </td>
            </tr>
        </table>
        <hr class="horizontal-divider"></hr>
        <div id="attachments-holder"></div>
    </div>
    <a class="button" onclick="hidePopupWindow();<?php if ($isAdmin) echo ' toggleItemDetailsPopupInputFields();'; ?>">Close</a>
    <div class="error-div" id="item-details-popup-window-error-div"></div>
</div>

