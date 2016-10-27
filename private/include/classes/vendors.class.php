<?php

/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/16/2015                                                                 */
/* Last modified on 04/17/2016                                                           */
/* ===================================================================================== */

/* ===================================================================================== */
/* The MIT License                                                                       */
/*                                                                                       */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>.                                 */
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

class Vendors {

    private $Database;
    private $Functions;
    private $Admin;

    /** @var array $vendorsArray */
    public $vendorsArray;

    /** @var array $vendorIdsArray */
    public $vendorIdsArray;

    /**
     * @param Database $database
     * @param Functions $functions
     */
    function __construct($database, $functions, $admin) {
        $this->Database = $database;
        $this->Functions = $functions;
        $this->Admin = $admin;
        $this->populateArrays(false);
    }

    private function populateArrays($sort) {
        if ($sort == true) {
            $sortColumn = $_SESSION['vendor_sort_column_name'];

            $sql = "SELECT id, name, phone, website, address, contact_person, account_number, added_by_username, approved FROM vendors WHERE deleted = 0 ORDER BY $sortColumn";

            if ($_SESSION['vendor_sort_up_or_down'] == 'up') {
                $sql .= " ASC ";
            } else {
                $sql .= " DESC ";
            }
        } else {
            $sql = "SELECT id, name, phone, website, address, contact_person, account_number, added_by_username, approved FROM vendors WHERE deleted = 0 ORDER BY name";
        }

        $stmt = $this->Database->prepare($sql);
        $stmt->execute();
        $this->vendorsArray = array();
        $this->vendorIdsArray = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->vendorsArray[$row['id']] = $row;
            $this->vendorIdsArray[$row['name']] = $row['id'];
        }
    }

    public function refreshArrays() {
        $this->populateArrays(false);
    }

    public function refreshArraysWithSort() {
        $this->populateArrays(true);
    }

    /**
     * @param string $id
     */
    public function removeVendorFromArray($id) {
        unset($this->vendorsArray[$id]);
    }

    /**
     * @return array $vendorsArray
     */
    public function getVendorsArray() {
        return $this->vendorsArray;
    }

    /**
     * @return array $vendorIdsArray
     */
    public function getVendorIdsArray() {
        return $this->vendorIdsArray;
    }

    public function populateVendorsTable() {
        $tableBody = '';
        foreach ($this->vendorsArray as $id => $vendor) {
            $vendorName = $vendor['name'];
            $vendorPhone = $vendor['phone'];
            $vendorWebsite = $vendor['website'];
            $vendorAddress = $vendor['address'];
            $vendorContactPerson = $vendor['contact_person'];
            $vendorAccountNo = $vendor['account_number'];
            $vendorAddedBy = $vendor['added_by_username'];
            $vendorApproved = $vendor['approved'];

            $tableBody .= "<tr id='$id'>";
            $tableBody .= "<td>$id</td>";
            $tableBody .= "<td title='$vendorName'><span>$vendorName</span><input id='vendors-popup-window-vendor-name' value='$vendorName' type='text'/></td>";
            $tableBody .= "<td title='$vendorPhone'><span>$vendorPhone</span><input id='vendors-popup-window-vendor-phone' value='$vendorPhone' type='text'/></td>";
            $tableBody .= "<td title='$vendorWebsite'><span>$vendorWebsite</span><input id='vendors-popup-window-vendor-website' value='$vendorWebsite' type='text'/></td>";
            $tableBody .= "<td title='$vendorAddress'><span>$vendorAddress</span><input id='vendors-popup-window-vendor-address' value='$vendorAddress' type='text'/></td>";
            $tableBody .= "<td title='$vendorContactPerson'><span>$vendorContactPerson</span><input id='vendors-popup-window-vendor-contact_person' value='$vendorContactPerson' type='text'/></td>";
            $tableBody .= "<td title='$vendorAccountNo'><span>$vendorAccountNo</span><input id='vendors-popup-window-vendor-account_number' value='$vendorAccountNo' type='text'/></td>";
            $tableBody .= "<td title='$vendorAddedBy'>$vendorAddedBy</td>";

            $tableBody .= "<td title='Vendor Approval Status'>";
            if ($vendorApproved == '2') {
                $tableBody .= "<span>New Vendor</span>";
                $tableBody .= "<select id='vendors-popup-window-vendor-approved'>";
                $tableBody .= "<option value='2' selected>New Vendor</option>";
                $tableBody .= "<option value='0'>No</option>";
                $tableBody .= "<option value='1'>Yes</option>";
                $tableBody .= "</select>";
            } else if ($vendorApproved == '0') {
                $tableBody .= "<span>No</span>";
                $tableBody .= "<select id='vendors-popup-window-vendor-approved'>";
                $tableBody .= "<option value='0' selected>No</option>";
                $tableBody .= "<option value='1'>Yes</option>";
                $tableBody .= "</select>";
            } else if ($vendorApproved == '1') {
                $tableBody .= "<span>Yes</span>";
                $tableBody .= "<select id='vendors-popup-window-vendor-approved'>";
                $tableBody .= "<option value='0'>No</option>";
                $tableBody .= "<option value='1' selected>Yes</option>";
                $tableBody .= "</select>";
            }
            $tableBody .= "</td>";
            $tableBody .= "<td title='Delete Vendor'><a class='delete-button' onclick='showDeleteVendorConfirmPopup(this);'>&#10006;</a></td>";
            $tableBody .= "</tr>";
        }
        echo $tableBody;
    }

    /**
     * @param array $vendorDetailsArray
     * @return boolean PDO execute result
     */
    public function addNewVendor($vendorDetailsArray) {
        $vendorName = $vendorDetailsArray['name'];
        $vendorPhone = $vendorDetailsArray['phone'];
        $vendorWebsite = $vendorDetailsArray['website'];
        $vendorAddress = $vendorDetailsArray['address'];
        $vendorContactPerson = $vendorDetailsArray['contact_person'];
        $vendorAccountNo = $vendorDetailsArray['account_number'];

        $userId = $_SESSION['id'];
        $username = $_SESSION['username'];
        $currentDate = date("Y-m-d H:i:s");

        $sql = "INSERT INTO vendors (";
        $sql .= "name, phone, website, address, contact_person, account_number, date_added, added_by_user_id, added_by_username,";
        $sql .= " last_updated_date, last_updated_by_user_id, last_updated_by_username, approved";
        $sql .= ") VALUES (:name, :phone, :website, :address, :contactPerson, :accountNumber, :currentDate, :userId, :username, :currentDate, :userId, :username, '1')";

        $stmt = $this->Database->prepare($sql);
        $stmt->bindValue(':name', $vendorName, PDO::PARAM_STR);
        $stmt->bindValue(':phone', $vendorPhone, PDO::PARAM_STR);
        $stmt->bindValue(':website', $vendorWebsite, PDO::PARAM_STR);
        $stmt->bindValue(':address', $vendorAddress, PDO::PARAM_STR);
        $stmt->bindValue(':contactPerson', $vendorContactPerson, PDO::PARAM_STR);
        $stmt->bindValue(':accountNumber', $vendorAccountNo, PDO::PARAM_STR);
        $stmt->bindValue(':currentDate', $currentDate, PDO::PARAM_STR);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * @param string $vendorId
     * @return boolean PDO execute result
     */
    public function deleteVendor($vendorId) {
        $userId = $_SESSION['id'];
        $username = $_SESSION['username'];
        $currentDate = date("Y-m-d H:i:s");

        $sql = "UPDATE vendors SET ";
        $sql .= "deleted = '1', ";
        $sql .= "deleted_date = :deleted_date, ";
        $sql .= "deleted_by_user_id = :deleted_by_user_id, ";
        $sql .= "deleted_by_username = :deleted_by_username ";
        $sql .= "WHERE id = :vendor_id";

        $stmt = $this->Database->prepare($sql);

        $stmt->bindValue(':deleted_date', $currentDate, PDO::PARAM_STR);
        $stmt->bindValue(':deleted_by_user_id', $userId, PDO::PARAM_STR);
        $stmt->bindValue(':deleted_by_username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':vendor_id', $vendorId, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * @param array $vendorDetailsArray
     * @return boolean PDO execute result
     */
    public function updateVendor($vendorDetailsArray) {
        $vendorId = $vendorDetailsArray['vendor_id'];
        $fieldName = $vendorDetailsArray['field_name'];
        $value = $vendorDetailsArray['value'];

        $userId = $_SESSION['id'];
        $username = $_SESSION['username'];
        $currentDate = date("Y-m-d H:i:s");

        // Inserting the information to the database
        $sql = "UPDATE vendors SET ";
        $sql .= "$fieldName = :value, ";
        $sql .= "last_updated_by_user_id = :last_updated_by_user_id, ";
        $sql .= "last_updated_by_username = :last_updated_by_username, ";
        $sql .= "last_updated_date = :last_updated_date ";
        $sql .= "WHERE id = :vendor_id";

        $stmt = $this->Database->prepare($sql);

        $stmt->bindValue(':value', $value, PDO::PARAM_STR);
        $stmt->bindValue(':last_updated_by_user_id', $userId, PDO::PARAM_STR);
        $stmt->bindValue(':last_updated_by_username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':last_updated_date', $currentDate, PDO::PARAM_STR);
        $stmt->bindValue(':vendor_id', $vendorId, PDO::PARAM_STR);

        return $stmt->execute();
    }

    public function populateVendorsList() {
        if ($this->Admin->isAdmin()) {
            $sql = "SELECT id, name, phone, website FROM vendors WHERE deleted = 0 ORDER BY name";
        } else {
            $sql = "SELECT id, name, phone, website FROM vendors WHERE approved != 0 AND deleted = 0 ORDER BY name";
        }
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
        echo "<td>Vendor<span class='red-font'> *</span></td>
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
            </td>";
    }

}

?>