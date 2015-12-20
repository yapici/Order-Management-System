<?php
/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/19/2015                                                                 */
/* Last modified on 12/19/2015                                                           */
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

echo "<script type='text/javascript'>";
require(PRIVATE_PATH . 'require/js/vendors-popup-window-functions.js');
echo "</script>";
echo "<style>";
require(PRIVATE_PATH . 'require/css/vendors-popup-window.css');
echo "</style>";
?>

<div class="popup-window" id="vendors-popup-window">
    <h1>Vendors</h1>
    <a class="popup-window-cancel-button" onclick="hidePopupWindows();">&#10006;</a>
    <table id="vendors-popup-window-vendors-table">
        <thead>
            <tr>
                <td>Id</td>
                <td>Name</td>
                <td>Phone</td>
                <td>Website</td>
                <td>Address</td>
                <td>Contact Person</td>
                <td>Added By</td>
                <td>Admin Approved</td>
            </tr>
        </thead>
        <tbody>
        <?php
        $vendorsArray = $Vendors->getVendorsArray();
        $tableBody = '';
        foreach ($vendorsArray as $id => $vendor) {
            $vendorName = $vendor['name'];
            $vendorPhone = $vendor['phone'];
            $vendorWebsite = $vendor['website'];
            $vendorAddress = $vendor['address'];
            $vendorContactPerson = $vendor['contact_person'];
            $vendorAddedBy = $vendor['added_by_username'];
            $vendorApproved = $vendor['approved'];

            $tableBody .= "<tr id='$id'>";
            $tableBody .= "<td>$id</td>";
            $tableBody .= "<td title='$vendorName'><span>$vendorName</span><input id='vendors-popup-window-vendor-name' value='$vendorName' type='text'/></td>";
            $tableBody .= "<td title='$vendorPhone'><span>$vendorPhone</span><input id='vendors-popup-window-vendor-phone' value='$vendorPhone' type='text'/></td>";
            $tableBody .= "<td title='$vendorWebsite'><span>$vendorWebsite</span><input id='vendors-popup-window-vendor-website' value='$vendorWebsite' type='text'/></td>";
            $tableBody .= "<td title='$vendorAddress'><span>$vendorAddress</span><input id='vendors-popup-window-vendor-address' value='$vendorAddress' type='text'/></td>";
            $tableBody .= "<td title='$vendorContactPerson'><span>$vendorContactPerson</span><input id='vendors-popup-window-vendor-contact_person' value='$vendorContactPerson' type='text'/></td>";
            $tableBody .= "<td title='$vendorAddedBy'>$vendorAddedBy</td>";
            $tableBody .= "<td><span>$vendorApproved</span><input id='vendors-popup-window-vendor-approved' value='$vendorApproved' type='text'/></td>";
            $tableBody .= "</tr>";
        }
            echo $tableBody;
        ?>
        </tbody>
    </table>
    <div class="error-div" id="vendors-popup-window-error-div"></div>
</div>