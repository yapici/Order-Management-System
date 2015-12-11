<?php
/* ================================================================ */
/* Created by Engin Yapici on 10/26/2015                            */
/* Last modified by Engin Yapici on 10/26/2015                      */
/* Copyright Engin Yapici, 2015.                                    */
/* enginyapici@gmail.com                                            */
/* ================================================================ */
?>
<div class="popup-window" id="add-new-item-popup-window">
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
                <input id="add-new-item-quantity" type="text"/>
            </td>
        </tr>
        <tr>
            <td>Unit of Measurement<span class="red-font"> *</span></td>
            <td class="add-new-item-input-holder-td">
                <input id="add-new-item-uom" type="text"/>
            </td>
        </tr>
        <tr>
            <td>Vendor<span class="red-font"> *</span></td>
            <td class="add-new-item-input-holder-td">
                <input id="add-new-item-vendor" type="text"/>
            </td>
        </tr>
        <tr>
            <td>Catalog No<span class="red-font"> *</span></td>
            <td class="add-new-item-input-holder-td">
                <input id="add-new-item-catalog-no" type="text"/>
            </td>
        </tr>    
        <tr>
            <td>Price<span class="red-font"> *</span></td>
            <td class="add-new-item-input-holder-td">
                <input id="add-new-item-price" type="text"/>
            </td>
        </tr>  
        <tr>
            <td>Cost Center</td>
            <td class="add-new-item-input-holder-td">
                <select id="add-new-item-cost-center">
                    <option>1234ZYZ</option>
                    <option>9876ABCD</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Project Name</td>
            <td class="add-new-item-input-holder-td">
                <select id="add-new-item-cost-center">
                    <option>Project 1</option>
                    <option>Project 2</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Project No</td>
            <td class="add-new-item-input-holder-td">
                <select id="add-new-item-cost-center">
                    <option>ABCD12345XYZ</option>
                    <option>XYZ12345ABCD</option>
                </select>
            </td>
        </tr>  
        <tr>
            <td>Account Number</td>
            <td class="add-new-item-input-holder-td">
                <input id="add-new-item-account-no" type="text"/>
            </td>
        </tr>  
        <tr>
            <td>Comments</td>
            <td id="add-new-item-comments" class="add-new-item-input-holder-td">
                <input type="text"/>
            </td>
        </tr>
    </table>
    <hr class="horizontal-divider"></hr>
    <div class="bottom-panel">
        <div id="attachments-holder">
            <h2>Attachments</h2>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                Select a file to upload:
                <input type="file" name="fileToUpload" id="fileToUpload">
                <input type="submit" class='button file-upload-button' value="Upload File" name="submit">
            </form>
        </div>
    </div>
    <hr class="horizontal-divider"></hr>
    <div class="error-div" id="add-new-item-error-div"></div>
    <a class="button" onclick="addNewItem()">Submit</a>
    <a class="button" onclick="hidePopupWindow()">Close</a>
</div>

