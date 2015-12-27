<?php

/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/13/2015                                                                 */
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

require('../../../private/include/include.php');
// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if (filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
    $adminCheckResponse = $Admin->ajaxAdminChecks();
    if ($adminCheckResponse !== true) {
        $jsonResponse['status'] = $adminCheckResponse;
    } else {
        $vendorsArray = $Vendors->getVendorsArray();
        date_default_timezone_set('America/Chicago');
        // Getting the parameters passed through AJAX
        $sanitizedPostArray = $Functions->sanitizePostedVariables();
        $description = $sanitizedPostArray['description'];
        $quantity = $sanitizedPostArray['quantity'];
        $uom = $sanitizedPostArray['uom'];
        $vendorId = $sanitizedPostArray['vendor'];
        $vendorName = $vendorsArray[$vendorId]['name'];
        $catalogNo = $sanitizedPostArray['catalog_no'];
        $price = $sanitizedPostArray['price'];
        $weblink = $Functions->addHttp($sanitizedPostArray['weblink']);
        $costCenter = $sanitizedPostArray['cost_center'];
        $projectId = $sanitizedPostArray['project'];
        $comments = $sanitizedPostArray['comments'];
        $status = $sanitizedPostArray['status'];
        $orderId = trim(substr($sanitizedPostArray['order_id'], 5));
        $userId = $_SESSION['id'];
        $username = $_SESSION['username'];
        $currentDate = date("Y-m-d H:i:s");

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
        $sql .= "status = :status, ";
        $sql .= "last_updated_by_id = :last_updated_by_id, ";
        $sql .= "last_updated_by_username = :last_updated_by_username, ";
        $sql .= "last_updated_datetime = :last_updated_datetime ";
        $sql .= "WHERE id = :order_id";

        $stmt = $Database->prepare($sql);

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
        $stmt->bindValue(':status', $status, PDO::PARAM_STR);
        $stmt->bindValue(':last_updated_by_id', $userId, PDO::PARAM_STR);
        $stmt->bindValue(':last_updated_by_username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':last_updated_datetime', $currentDate, PDO::PARAM_STR);
        $stmt->bindValue(':order_id', $orderId, PDO::PARAM_STR);
        $result = $stmt->execute();

        if ($result) {
            ob_start();
            require_once(PRIVATE_PATH . 'require/orders-table-body-query.php');
            $jsonResponse['html_tbody'] = ob_get_clean();
            $jsonResponse['html_pagination'] = $pagination;
            $jsonResponse['cost_center_name'] = $CostCenters->getCostCentersArray()[$costCenter];
            
            $project = $Projects->getProjectsArray()[$projectId];
            $jsonResponse['project'] = $project['name'] . ' / ' . $project['number'];
            
            $jsonResponse['status'] = "success";
        } else {
            $jsonResponse['status'] = "fail";
        }
    }
    echo json_encode($jsonResponse);
} else {
    $Functions->phpRedirect('');
}

