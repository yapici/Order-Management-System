<?php
/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 10/26/2015                                                                 */
/* Last modified on 12/15/2015                                                           */
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
?>
<div class="popup-window" id="add-new-item-popup-window">
    <a class="popup-window-cancel-button" onclick="hidePopupWindows()">&#10006;</a>
    <h1>Add New Item</h1>
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
        <?php require(PRIVATE_PATH . 'require/populate-vendors-list.php'); ?>
        <tr>
            <td>Catalog No<span class="red-font"> *</span></td>
            <td class="add-new-item-input-holder-td">
                <input id="add-new-item-catalog-no" type="text"/>
            </td>
        </tr>    
        <tr>
            <td>Price (USD)<span class="red-font"> *</span></td>
            <td class="add-new-item-input-holder-td">
                <input id="add-new-item-price" type="number" step="any"/>
            </td>
        </tr> 
        <tr>
            <td>Date Needed<span class="red-font"> *</span></td>
            <td class="add-new-item-input-holder-td">
                <input class="datepicker" id="add-new-item-date-needed" type="text" readonly />
            </td>
        </tr>    
        <tr>
            <td>Cost Center</td>
            <td class="add-new-item-input-holder-td">
                <select id="add-new-item-cost-center">
                    <option></option>
                    <option>1234ZYZ</option>
                    <option>9876ABCD</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Project Name</td>
            <td class="add-new-item-input-holder-td">
                <select id="add-new-item-project-name">
                    <option></option>
                    <option>Project 1</option>
                    <option>Project 2</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Project No</td>
            <td class="add-new-item-input-holder-td">
                <select id="add-new-item-project-no">
                    <option></option>
                    <option>1234ZYZ</option>
                    <option>9876ABCD</option>
                </select>
            </td>
        </tr>  
        <tr>
            <td>Account Number</td>
            <td class="add-new-item-input-holder-td">
                <select id="add-new-item-account-no">
                    <option></option>
                    <option>ABCD12345XYZ</option>
                    <option>XYZ12345ABCD</option>
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
                <input type="file" name="file-to-upload" id="file-to-upload"/>
                <a class='button file-upload-button' onclick="uploadFile()">Upload File</a>
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
    <div class="error-div" id="add-new-item-error-div"></div>
    <a class="button" onclick="addNewItem()">Submit</a>
    <a class="button" onclick="hidePopupWindow()">Close</a>
</div>

