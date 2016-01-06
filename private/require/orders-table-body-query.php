<?php

/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 10/26/2015                                                                 */
/* Last modified on 01/06/2016                                                           */
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


/* ########################################################## tbody Content ######################################################## */
/* | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | */
/* V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V */
$ordersArray = $Orders->getOrdersArray();
if (!empty($ordersArray)) {
    foreach ($ordersArray as $id => $order) {
        $itemId = $id;
        $orderDetailsArray = $ordersArray[$id];
        $description = $orderDetailsArray['description'];
        $quantity = $orderDetailsArray['quantity'];
        $uom = $orderDetailsArray['uom'];
        $vendorId = $orderDetailsArray['vendor'];
        $catalogNo = $orderDetailsArray['catalog_no'];
        $price = $orderDetailsArray['price'];
        $weblink = $orderDetailsArray['weblink'];
        $costCenterId = $orderDetailsArray['cost_center'];
        $projectId = $orderDetailsArray['project'];
        $comments = $orderDetailsArray['comments'];
        $requestedDate = $Functions->convertMysqlDateToPhpDate($orderDetailsArray['requested_datetime']);
        $statusUpdatedDate = $Functions->convertMysqlDateToPhpDate($orderDetailsArray['status_updated_date']);
        $itemNeededByDate = $Functions->convertMysqlDateToPhpDate($orderDetailsArray['item_needed_by_date']);
        $status = $orderDetailsArray['status'];
        $requestedByUsername = $orderDetailsArray['requested_by_username'];
        $statusUpdatedByUsername = $orderDetailsArray['status_updated_by_username'];
        $ordered = $orderDetailsArray['ordered'];
        $orderedDate = $orderDetailsArray['ordered_date'];

        if ($orderedDate != '0000-00-00 00:00:00' || $orderedDate != '') {
            $orderedDate = $Functions->convertMysqlDateToPhpDate($orderedDate);
        }
        $orderedByUsername = $orderDetailsArray['ordered_by_username'];

        if ($Admin->isAdmin()) {
            $vendorOrderNo = $orderDetailsArray['vendor_order_no'];
            $invoiceNo = $orderDetailsArray['invoice_no'];
        }

        $costCenterName = '';
        if ($costCenterId != '0') {
            $costCenterName = $CostCenters->getCostCentersArray()[$costCenterId]['name'];
        }

        $vendorName = $Vendors->getVendorsArray()[$vendorId]['name'];
        $vendorAccountNo = $Vendors->getVendorsArray()[$vendorId]['account_number'];

        $project = '';
        if ($projectId != '0') {
            $project = $Projects->getProjectsArray()[$projectId];
            $project = $project['name'] . ' / ' . $project['number'];
        }

        $popupWindowParamArray = array($itemId, $description, $quantity, $uom, $vendorName, $catalogNo,
            $price, $weblink, $costCenterName, $project, $comments, $requestedByUsername, $requestedDate,
            $statusUpdatedByUsername, $statusUpdatedDate, $status, $itemNeededByDate, $ordered, $orderedDate
        );
        echo "<tr onclick='showItemDetailsPopupWindow(";
        echoJsFunctionParams($popupWindowParamArray);
        echo "\"" . $Functions->escapeQuotes($orderedByUsername) . "\");";
        if ($Admin->isAdmin()) {
            $popupWindowAdminParamArray = array($itemId, $vendorAccountNo, $invoiceNo);
            echo " showItemDetailsPopupWindowAdmin(";
            echoJsFunctionParams($popupWindowAdminParamArray);
            echo "\"" . $Functions->escapeQuotes($vendorOrderNo) . "\");";

            $inputParamsArray = array($description, $quantity, $uom, $vendorName, $catalogNo,
                $price, $weblink, $costCenterName, $project, $comments, $invoiceNo, $vendorOrderNo
            );
            echo " prepareItemDetailsPopupWindowInputs(";
            echoJsFunctionParams($inputParamsArray);
            echo "\"" . $Functions->escapeQuotes($status) . "\");";
        }
        echo "'>";
        if ($Admin->isAdmin()) {
            echo "<td title='$itemId'>" . $itemId . "</td>";
            echo "<td title=\"$description\">" . $description . "</td>";
            echo "<td title='$vendorName'>" . $vendorName . "</td>";
            echo "<td title='$catalogNo'>" . $catalogNo . "</td>";
            echo "<td title='$vendorAccountNo'>" . $vendorAccountNo . "</td>";
            echo "<td title='$requestedByUsername'>" . $requestedByUsername . "</td>";
            echo "<td title='$itemNeededByDate'>" . $itemNeededByDate . "</td>";
            echo "<td title='$status'>" . $status . "</td>";
        } else {
            echo "<td title='$itemId'>" . $itemId . "</td>";
            echo "<td title='$description'>" . $description . "</td>";
            echo "<td title='$vendorName'>" . $vendorName . "</td>";
            echo "<td title='$catalogNo'>" . $catalogNo . "</td>";
            echo "<td title='$requestedByUsername'>" . $requestedByUsername . "</td>";
            echo "<td title='$status'>" . $status . "</td>";
        }
        echo "</tr>";
    }
}

function echoJsFunctionParams($paramArray) {
    global $Functions;

    foreach ($paramArray as $param) {
        echo "\"" . $Functions->escapeQuotes($param) . "\", ";
    }
}

/* ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ */
/* | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | */
/* ########################################################## tbody Content ######################################################## */



/* ########################################################## Pagination ########################################################### */
/* | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | */
/* V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V */
$totalNumberOfItems = $Orders->totalNumberOfItems;

require_once('orders-table-pagination.php');

/* ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ */
/* | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | */
/* ########################################################## Pagination ########################################################### */
?>