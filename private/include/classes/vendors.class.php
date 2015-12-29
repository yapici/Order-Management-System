<?php

/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/16/2015                                                                 */
/* Last modified on 12/28/2015                                                           */
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

class Vendors {

    private $Database;
    private $Functions;

    /** @var array $vendorsArray */
    public $vendorsArray;

    /** @var array $vendorIdsArray */
    public $vendorIdsArray;

    /**
     * @param Database $database
     * @param Functions $functions
     */
    function __construct($database, $functions) {
        $this->Database = $database;
        $this->Functions = $functions;
        $this->populateArrays();
    }

    private function populateArrays() {
        $sql = "SELECT id, name, phone, website, address, contact_person, account_number, added_by_username, approved FROM vendors WHERE deleted = 0";
        $stmt = $this->Database->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sanitizedArray = $this->Functions->sanitizeArray($row);
            $this->vendorsArray[$sanitizedArray['id']] = $sanitizedArray;
            $this->vendorIdsArray[$sanitizedArray['name']] = $sanitizedArray['id'];
        }
    }

    public function refreshArrays() {
        $this->populateArrays();
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
            $tableBody .= "<td><span>$vendorApproved</span><input id='vendors-popup-window-vendor-approved' value='$vendorApproved' type='text'/></td>";
            $tableBody .= "<td title='Delete Vendor'><a class='delete-button' onclick='deleteVendor(this);'>&#10006;</a></td>";
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

}

/** @var Vendors $Vendors */
$Vendors = new Vendors($Database, $Functions);
?>