<?php

/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/17/2015                                                                 */
/* Last modified on 01/03/2016                                                           */
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

class ItemDetails {

    private $Database;
    private $Functions;
    private $Email;
    private $Vendors;

    /**
     * @param Database $database
     * @param Functions $functions
     * @param Vendors $vendors
     */
    function __construct($database, $functions, $vendors, $email) {
        $this->Database = $database;
        $this->Functions = $functions;
        $this->Vendors = $vendors;
        $this->Email = $email;
    }

    public function getVendors() {
        $vendorsArray = $this->Vendors->getVendorsArray();
        echo '<select id="item-details-popup-window-vendor">';
        echo '<option></option>';
        foreach ($vendorsArray as $id => $vendor) {
            $vendorName = $vendor['name'];
            echo "<option value='$id'>$vendorName</option>";
        }
        echo '</select>';
    }

    public function populateVendorsList() {
        $sql = "SELECT id, name, phone, website FROM vendors WHERE approved = 1 AND deleted = 0";
        $stmt = $this->Database->prepare($sql);
        $stmt->execute();

        $optionsHtml = "";
        $vendorDetailsHtml = "";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sanitizedArray = $this->Functions->sanitizeArray($row);
            $vendorId = $sanitizedArray['id'];
            $vendorName = $sanitizedArray['name'];
            $vendorPhone = $sanitizedArray['phone'];
            $vendorWebsite = $sanitizedArray['website'];

            $optionsHtml .= "<option value='$vendorId'>$vendorName</option>";
            $vendorDetailsHtml .= "<tr class='add-new-item-vendor-details-holder-tr add-new-item-vendor-details-$vendorId'>";
            $vendorDetailsHtml .= "<td>Vendor Phone:</td>";
            $vendorDetailsHtml .= "<td><span class='vendor-details-span'>$vendorPhone</span></td>";
            $vendorDetailsHtml .= "</tr>";
            $vendorDetailsHtml .= "<tr class='add-new-item-vendor-details-holder-tr add-new-item-vendor-details-$vendorId'>";
            $vendorDetailsHtml .= "<td>Vendor Website:</td>";
            $vendorDetailsHtml .= "<td><span class='vendor-details-span'>$vendorWebsite</span></td>";
            $vendorDetailsHtml .= "</tr>";
        }

        $this->echoVendorsListHtml($optionsHtml, $vendorDetailsHtml);
    }

    /**
     * @param string $optionsHtml
     * @param string $vendorDetailsHtml
     */
    private function echoVendorsListHtml($optionsHtml, $vendorDetailsHtml) {
        echo "<tr>
            <td>Vendor<span class='red-font'> *</span></td>
            <td class='add-new-item-input-holder-td'>
                <select id='add-new-item-vendor' onchange='showVendorDetails(this.value);'>
                    <option>Please Choose a Vendor</option>
                    $optionsHtml
                    <option value='new'>Add New Vendor</option>
                </select>
            </td>
        </tr>
        $vendorDetailsHtml
        <tr class='add-new-item-vendor-details-holder-tr add-new-item-new-vendor-details'>
            <td class='new-vendor-title-td'>Vendor Name:<span class='red-font'> *</span></td>
            <td class='add-new-item-input-holder-td'>
                <input id='add-new-item-new-vendor-name' type='text'/>
            </td>
        </tr>
        <tr class='add-new-item-vendor-details-holder-tr add-new-item-new-vendor-details'>
            <td class='new-vendor-title-td'>Vendor Phone:<span class='red-font'> *</span></td>
            <td class='add-new-item-input-holder-td'>
                <input id='add-new-item-new-vendor-phone' type='text'/>
            </td>
        </tr>
        <tr class='add-new-item-vendor-details-holder-tr add-new-item-new-vendor-details'>
            <td class='new-vendor-title-td'>Vendor Website:</td>
            <td class='add-new-item-input-holder-td'>
                <input id='add-new-item-new-vendor-website' type='text'/>
            </td>
        </tr>
        <tr class='add-new-item-vendor-details-holder-tr add-new-item-new-vendor-details'>
            <td class='new-vendor-title-td'>Vendor Address:</td>
            <td class='add-new-item-input-holder-td'>
                <input id='add-new-item-new-vendor-address' type='text'/>
            </td>
        </tr>";
    }

    /**
     * @param array $itemDetailsArray
     * @return boolean PDO execute result
     */
    public function updateItemDetails($itemDetailsArray) {
        $vendorsArray = $this->Vendors->getVendorsArray();
        $description = $itemDetailsArray['description'];
        $quantity = $itemDetailsArray['quantity'];
        $uom = $itemDetailsArray['uom'];
        $vendorId = $itemDetailsArray['vendor'];
        $vendorName = $vendorsArray[$vendorId]['name'];
        $catalogNo = $itemDetailsArray['catalog_no'];
        $price = $itemDetailsArray['price'];
        $weblink = $this->Functions->addHttp($itemDetailsArray['weblink']);
        $costCenter = $itemDetailsArray['cost_center'];
        $projectId = $itemDetailsArray['project'];
        $comments = $itemDetailsArray['comments'];
        $status = $itemDetailsArray['status'];
        $invoiceNo = $itemDetailsArray['invoice_no'];
        $vendorOrderNo = $itemDetailsArray['vendor_order_no'];
        $orderId = trim(substr($itemDetailsArray['order_id'], 5));
        $userId = $_SESSION['id'];
        $username = $_SESSION['username'];
        $currentDate = date("Y-m-d H:i:s");

        $statusChanged = true;
        if ($status == 'no_change') {
            $statusChanged = false;
        }

        // Inserting the information to the database
        $sql = "UPDATE orders SET ";
        $sql .= "description = :description, ";
        $sql .= "quantity = :quantity, ";
        $sql .= "uom = :uom, ";
        $sql .= "vendor = :vendor, ";
        $sql .= "vendor_name = :vendor_name, ";
        $sql .= "catalog_no = :catalog_no, ";
        $sql .= "price = :price, ";
        $sql .= "weblink = :weblink, ";
        $sql .= "cost_center = :cost_center, ";
        $sql .= "project = :project, ";
        $sql .= "comments = :comments, ";
        if ($statusChanged) {
            $sql .= "status = :status, ";
        }
        $sql .= "ordered = :ordered, ";
        if ($statusChanged && $status == 'Ordered') {
            $sql .= "ordered_date = :ordered_date, ";
            $sql .= "ordered_by_user_id = :ordered_by_user_id, ";
            $sql .= "ordered_by_username = :ordered_by_username, ";
        }
        $sql .= "invoice_no = :invoice_no, ";
        $sql .= "vendor_order_no = :vendor_order_no, ";
        $sql .= "last_updated_by_id = :last_updated_by_id, ";
        $sql .= "last_updated_by_username = :last_updated_by_username, ";
        $sql .= "last_updated_datetime = :last_updated_datetime ";
        $sql .= "WHERE id = :order_id";

        $stmt = $this->Database->prepare($sql);

        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':quantity', $quantity, PDO::PARAM_STR);
        $stmt->bindValue(':uom', $uom, PDO::PARAM_STR);
        $stmt->bindValue(':vendor', $vendorId, PDO::PARAM_STR);
        $stmt->bindValue(':vendor_name', $vendorName, PDO::PARAM_STR);
        $stmt->bindValue(':catalog_no', $catalogNo, PDO::PARAM_STR);
        $stmt->bindValue(':price', $price, PDO::PARAM_STR);
        $stmt->bindValue(':weblink', $weblink, PDO::PARAM_STR);
        $stmt->bindValue(':cost_center', $costCenter, PDO::PARAM_STR);
        $stmt->bindValue(':project', $projectId, PDO::PARAM_STR);
        $stmt->bindValue(':comments', $comments, PDO::PARAM_STR);
        if ($statusChanged) {
            $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        }
        $stmt->bindValue(':invoice_no', $invoiceNo, PDO::PARAM_STR);
        $stmt->bindValue(':vendor_order_no', $vendorOrderNo, PDO::PARAM_STR);
        $stmt->bindValue(':last_updated_by_id', $userId, PDO::PARAM_STR);
        $stmt->bindValue(':last_updated_by_username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':last_updated_datetime', $currentDate, PDO::PARAM_STR);
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_STR);
        if ($statusChanged && $status == 'Ordered') {
            $stmt->bindValue(':ordered', "1", PDO::PARAM_STR);
            $stmt->bindValue(':ordered_date', $currentDate, PDO::PARAM_STR);
            $stmt->bindValue(':ordered_by_user_id', $userId, PDO::PARAM_STR);
            $stmt->bindValue(':ordered_by_username', $username, PDO::PARAM_STR);
        } else {
            $stmt->bindValue(':ordered', "0", PDO::PARAM_STR);
        }

        return $stmt->execute();
    }

    public function sendStatusChangeEmail($orderId, $status) {
        $sql = "SELECT o.requested_by_username, o.description, u.email FROM orders o JOIN users u ON o.requested_by_id = u.id WHERE o.id = :orderId";
        $stmt = $this->Database->prepare($sql);

        $stmt->bindValue(':orderId', $orderId, PDO::PARAM_STR);
        $stmt->execute();

        $sanitizedArray = $this->Functions->sanitizeArray($stmt->fetch(PDO::FETCH_ASSOC));

        $userFirstName = $this->Functions->getUserFirstName($sanitizedArray['requested_by_username']);
        $userEmail = $sanitizedArray['email'];

        $itemDescription = $sanitizedArray['description'];
        $subject = "OMS Notification: Order Status Change";
        $messageBody = "<p>The status for '$itemDescription' was updated to '$status'.</p>";

        $this->Email->sendEmail($userEmail, $userFirstName, $subject, $messageBody);
    }

}
