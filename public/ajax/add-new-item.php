<?php

/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 10/26/2015                                                                 */
/* Last modified on 12/24/2015                                                           */
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

require('../../private/include/include.php');
// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if (filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
    if (!$Session->isSessionValid()) {
        $jsonResponse['status'] = "no_session";
    } else {
        date_default_timezone_set('America/Chicago');
        // Getting the parameters passed through AJAX
        $sanitizedPostArray = $Functions->sanitizePostedVariables();
        $description = $sanitizedPostArray['description'];
        $quantity = $sanitizedPostArray['quantity'];
        $uom = $sanitizedPostArray['uom'];
        $vendorId = $sanitizedPostArray['vendor'];
        $catalogNo = $sanitizedPostArray['catalog_no'];
        $price = $sanitizedPostArray['price'];
        $costCenter = $sanitizedPostArray['cost_center'];
        $project = $sanitizedPostArray['project'];
        $weblink = $sanitizedPostArray['weblink'];
        if ($weblink != '') {
            $weblink = $Functions->addHttp($sanitizedPostArray['weblink']);
        }
        $comments = $sanitizedPostArray['comments'];
        $dateNeeded = $Functions->convertStrDateToMysqlDate($sanitizedPostArray['date_needed']);
        $userId = $_SESSION['id'];
        $username = $_SESSION['username'];
        $currentDate = date("Y-m-d H:i:s");

        if ($vendorId == 'new') {
            $newVendorName = $sanitizedPostArray['new_vendor_name'];
            $newVendorPhone = $sanitizedPostArray['new_vendor_phone'];
            $newVendorWebsite = $sanitizedPostArray['new_vendor_website'];
            $newVendorAddress = $sanitizedPostArray['new_vendor_address'];

            $sql = "INSERT INTO vendors (";
            $sql .= "name, phone, website, address, date_added, added_by_user_id, added_by_username,";
            $sql .= " last_updated_date, last_updated_by_user_id, last_updated_by_username";
            $sql .= ") VALUES (:name, :phone, :website, :address, :currentDate, :userId, :username, :currentDate, :userId, :username)";

            $stmt = $Database->prepare($sql);
            $stmt->bindValue(':name', $newVendorName, PDO::PARAM_STR);
            $stmt->bindValue(':phone', $newVendorPhone, PDO::PARAM_STR);
            $stmt->bindValue(':website', $newVendorWebsite, PDO::PARAM_STR);
            $stmt->bindValue(':address', $newVendorAddress, PDO::PARAM_STR);
            $stmt->bindValue(':currentDate', $currentDate, PDO::PARAM_STR);
            $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);

            $result = $stmt->execute();
            $vendorId = $Database->lastInsertId();
            $Vendors->refreshArrays();
        }
        $vendorsArray = $Vendors->getVendorsArray();
        $vendorName = $vendorsArray[$vendorId]['name'];

        // Inserting the information to the database
        $sql = "INSERT INTO orders ";
        $sql .= "(description, quantity, uom, vendor, catalog_no, price, cost_center, project, comments, requested_by_id, ";
        $sql .= "requested_by_username, requested_datetime, last_updated_by_id, last_updated_by_username, last_updated_datetime, status, status_updated_by_user_id, ";
        $sql .= "status_updated_by_username, status_updated_date, item_needed_by_date, vendor_name, weblink) ";
        $sql .= "VALUES ";
        $sql .= "(:description, :quantity, :uom, :vendor, :catalog_no, :price, :cost_center, :project, :comments, :user_id, :username, :current_date, :user_id, ";
        $sql .= ":username, :current_date, :status, :user_id, :username, :current_date, :item_needed_by_date, :vendor_name, :weblink)";

        $stmt = $Database->prepare($sql);

        $stmt->bindValue(":description", $description, PDO::PARAM_STR);
        $stmt->bindValue(":quantity", $quantity, PDO::PARAM_STR);
        $stmt->bindValue(":uom", $uom, PDO::PARAM_STR);
        $stmt->bindValue(":vendor", $vendorId, PDO::PARAM_STR);
        $stmt->bindValue(":catalog_no", $catalogNo, PDO::PARAM_STR);
        $stmt->bindValue(":price", $price, PDO::PARAM_STR);
        $stmt->bindValue(":cost_center", $costCenter, PDO::PARAM_STR);
        $stmt->bindValue(":project", $project, PDO::PARAM_STR);
        $stmt->bindValue(":comments", $comments, PDO::PARAM_STR);
        $stmt->bindValue(":user_id", $userId, PDO::PARAM_STR);
        $stmt->bindValue(":username", $username, PDO::PARAM_STR);
        $stmt->bindValue(":current_date", $currentDate, PDO::PARAM_STR);
        $stmt->bindValue(":status", Constants::ORDER_STATUS_PENDING, PDO::PARAM_STR);
        $stmt->bindValue(":item_needed_by_date", $dateNeeded, PDO::PARAM_STR);
        $stmt->bindValue(":vendor_name", $vendorName, PDO::PARAM_STR);
        $stmt->bindValue(":weblink", $weblink, PDO::PARAM_STR);
        $result = $stmt->execute();

        if ($result) {
            $Orders->refreshTotalNumberOfItems();
            renameAttachmentsDirectory($Database->lastInsertId(), PRIVATE_PATH);
            $_SESSION['pagination_page_number'] = 1;
            $_SESSION['sort_column_name'] = "";
            $_SESSION['search_keywords'] = "";
            ob_start();
            require_once(PRIVATE_PATH . 'require/orders-table-body-query.php');
            $jsonResponse['html_tbody'] = ob_get_clean();
            ob_start();
            require_once(PRIVATE_PATH . 'require/popup-windows/add-new-item-popup-window.php');
            $jsonResponse['add_new_item_popup'] = ob_get_clean();
            $jsonResponse['html_pagination'] = $pagination;
            $jsonResponse['status'] = "success";
        } else {
            $jsonResponse['status'] = "fail";
        }
    }
    echo json_encode($jsonResponse);
} else {
    $Functions->phpRedirect('');
}

function renameAttachmentsDirectory($itemId, $rootPath) {
    if (isset($_SESSION['temp-file-upload-directory'])) {
        $oldPath = $rootPath . 'attachments/' . $_SESSION['temp-file-upload-directory'];
        $newPath = $rootPath . 'attachments/' . $itemId;

        rename($oldPath, $newPath);

        unset($_SESSION['temp-file-upload-directory']);
    }
}

?>
