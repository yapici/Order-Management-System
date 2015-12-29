<?php

/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/20/2015                                                                 */
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

require('../../../private/include/include.php');
// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if (filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
    $adminCheckResponse = $Admin->ajaxAdminChecks();
    if ($adminCheckResponse !== true) {
        $jsonResponse['status'] = $adminCheckResponse;
    } else {
        // Getting the parameters passed through AJAX
        $sanitizedPostArray = $Functions->sanitizePostedVariables();
        $vendorId = $sanitizedPostArray['vendor_id'];
        $userId = $_SESSION['id'];
        $username = $_SESSION['username'];
        $currentDate = date("Y-m-d H:i:s");

        // Inserting the information to the database
        $sql = "UPDATE vendors SET ";
        $sql .= "deleted = '1', ";
        $sql .= "deleted_date = :deleted_date, ";
        $sql .= "deleted_by_user_id = :deleted_by_user_id, ";
        $sql .= "deleted_by_username = :deleted_by_username ";
        $sql .= "WHERE id = :vendor_id";

        $stmt = $Database->prepare($sql);

        $stmt->bindValue(':deleted_date', $currentDate, PDO::PARAM_STR);
        $stmt->bindValue(':deleted_by_user_id', $userId, PDO::PARAM_STR);
        $stmt->bindValue(':deleted_by_username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':vendor_id', $vendorId, PDO::PARAM_STR);
        $result = $stmt->execute();

        if ($result) {
            $Vendors->removeVendorFromArray($vendorId);
            ob_start();
            $Vendors->populateVendorsTable();
            $jsonResponse['html_tbody'] = ob_get_clean();
            $jsonResponse['status'] = "success";
        } else {
            $jsonResponse['status'] = "fail";
        }
    }
    echo json_encode($jsonResponse);
} else {
    $Functions->phpRedirect('');
}

