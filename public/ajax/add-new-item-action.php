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
        $vendor = $sanitizedPostArray['vendor'];
        $catalogNo = $sanitizedPostArray['catalog_no'];
        $price = $sanitizedPostArray['price'];
        $costCenter = $sanitizedPostArray['cost_center'];
        $projectName = $sanitizedPostArray['project_name'];
        $projectNo = $sanitizedPostArray['project_no'];
        $accountNo = $sanitizedPostArray['account_no'];
        $comments = $sanitizedPostArray['comments'];
        $dateNeeded = $Functions->convertStrDateToMysqlDate($sanitizedPostArray['date_needed']);
        $userId = $_SESSION['id'];
        $username = $_SESSION['username'];
        $currentDate = date("Y-m-d H:i:s");

        // Inserting the information to the database
        $sql = "INSERT INTO orders (";
        $sql .= "description, quantity, uom, vendor, catalog_no, price, cost_center, project_name, project_no, account_no, comments, requested_by_id";
        $sql .= ", requested_by_username, requested_datetime, last_updated_by_id, last_updated_by_username, last_updated_datetime, status, item_needed_by_date";
        $sql .= ") VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $stmt = $Database->prepare($sql);

        $stmt->bindValue(1, $description, PDO::PARAM_STR);
        $stmt->bindValue(2, $quantity, PDO::PARAM_STR);
        $stmt->bindValue(3, $uom, PDO::PARAM_STR);
        $stmt->bindValue(4, $vendor, PDO::PARAM_STR);
        $stmt->bindValue(5, $catalogNo, PDO::PARAM_STR);
        $stmt->bindValue(6, $price, PDO::PARAM_STR);
        $stmt->bindValue(7, $costCenter, PDO::PARAM_STR);
        $stmt->bindValue(8, $projectName, PDO::PARAM_STR);
        $stmt->bindValue(9, $projectNo, PDO::PARAM_STR);
        $stmt->bindValue(10, $accountNo, PDO::PARAM_STR);
        $stmt->bindValue(11, $comments, PDO::PARAM_STR);
        $stmt->bindValue(12, $userId, PDO::PARAM_STR);
        $stmt->bindValue(13, $username, PDO::PARAM_STR);
        $stmt->bindValue(14, $currentDate, PDO::PARAM_STR);
        $stmt->bindValue(15, $userId, PDO::PARAM_STR);
        $stmt->bindValue(16, $username, PDO::PARAM_STR);
        $stmt->bindValue(17, $currentDate, PDO::PARAM_STR);
        $stmt->bindValue(18, "Pending", PDO::PARAM_STR);
        $stmt->bindValue(19, $dateNeeded, PDO::PARAM_STR);
        $result = $stmt->execute();

        if ($result) {
            renameAttachmentsDirectory($Database->lastInsertId(), PRIVATE_PATH);
            $_SESSION['pagination_page_number'] = 1;
            $_SESSION['sort_column_name'] = "";
            $_SESSION['search_keywords'] = "";
            ob_start();
            require_once(PRIVATE_PATH . 'require/orders-table-body-query.php');
            $jsonResponse['html_tbody'] = ob_get_clean();
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
