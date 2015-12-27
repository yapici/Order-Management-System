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


/* ########################################################## tbody Content ######################################################## */
/* | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | */
/* V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V */
$ordersArray = $Orders->getOrdersArray();
foreach ($ordersArray as $id => $order) {
    $mItemId = $id;
    $orderDetailsArray = $ordersArray[$id];
    $mDescription = $orderDetailsArray['description'];
    $mQuantity = $orderDetailsArray['quantity'];
    $mUom = $orderDetailsArray['uom'];
    $mVendorId = $orderDetailsArray['vendor'];
    $mCatalogNo = $orderDetailsArray['catalog_no'];
    $mPrice = $orderDetailsArray['price'];
    $mWeblink = $orderDetailsArray['weblink'];
    $mCostCenter = $orderDetailsArray['cost_center'];
    $mProjectId = $orderDetailsArray['project'];
    $mComments = $orderDetailsArray['comments'];
    $mRequestedDate = $Functions->convertMysqlDateToPhpDate($orderDetailsArray['requested_datetime']);
    $mStatusUpdatedDate = $Functions->convertMysqlDateToPhpDate($orderDetailsArray['status_updated_date']);
    $mItemNeededByDate = $Functions->convertMysqlDateToPhpDate($orderDetailsArray['item_needed_by_date']);
    $mStatus = $orderDetailsArray['status'];
    $mRequestedByUsername = $orderDetailsArray['requested_by_username'];
    $mStatusUpdatedByUsername = $orderDetailsArray['status_updated_by_username'];
    $mOrdered = $orderDetailsArray['ordered'];
    $mOrderedDate = $orderDetailsArray['ordered_date'];
    
    if ($mOrderedDate != '0000-00-00 00:00:00' || $mOrderedDate != '') {
        $mOrderedDate = $Functions->convertMysqlDateToPhpDate($mOrderedDate);
    }
    $mOrderedByUsername = $orderDetailsArray['ordered_by_username'];

    if ($Admin->isAdmin()) {
        $mVendorOrderNo = $orderDetailsArray['vendor_order_no'];
        $mInvoiceNo = $orderDetailsArray['invoice_no'];
    }

    $mCostCenterName = $CostCenters->getCostCentersArray()[$mCostCenter];

    $mVendorName = $Vendors->getVendorsArray()[$mVendorId]['name'];
    $mVendorAccountNo = $Vendors->getVendorsArray()[$mVendorId]['account_number'];

    $mProject = '';
    if ($mProjectId != '') {
        $project = $Projects->getProjectsArray()[$mProjectId];
        $mProject = $project['name'] . ' / ' . $project['number'];
    }

    echo "<tr onclick=\"showItemDetailsPopupWindow("
    . "'$mItemId', "
    . "'$mDescription', "
    . "'$mQuantity', "
    . "'$mUom', "
    . "'$mVendorName', "
    . "'$mCatalogNo', "
    . "'$mPrice', "
    . "'$mWeblink', "
    . "'$mCostCenterName', "
    . "'$mProject', "
    . "'$mComments', "
    . "'$mRequestedByUsername', "
    . "'$mRequestedDate', "
    . "'$mStatusUpdatedByUsername', "
    . "'$mStatusUpdatedDate', "
    . "'$mStatus', "
    . "'$mItemNeededByDate', "
    . "'$mOrdered', "
    . "'$mOrderedDate', "
    . "'$mOrderedByUsername'"
    . ");";
    if ($Admin->isAdmin()) {
        echo " showItemDetailsPopupWindowAdmin("
        . "'$mVendorAccountNo', "
        . "'$mVendorOrderNo', "
        . "'$mInvoiceNo'"
        . "); ";
        echo " prepareItemDetailsPopupWindowInputs("
        . "'$mDescription', "
        . "'$mQuantity', "
        . "'$mUom', "
        . "'$mVendorName', "
        . "'$mCatalogNo', "
        . "'$mPrice', "
        . "'$mWeblink', "
        . "'$mCostCenterName', "
        . "'$mProject', "
        . "'$mComments', "
        . "'$mStatus'"
        . ");";
    }
    echo "\">";
    if ($Admin->isAdmin()) {
        echo "<td title='$mItemId'>" . $mItemId . "</td>";
        echo "<td title='$mDescription'>" . $mDescription . "</td>";
        echo "<td title='$mVendorName'>" . $mVendorName . "</td>";
        echo "<td title='$mCatalogNo'>" . $mCatalogNo . "</td>";
        echo "<td title='$mVendorAccountNo'>" . $mVendorAccountNo . "</td>";
        echo "<td title='$mRequestedByUsername'>" . $mRequestedByUsername . "</td>";
        echo "<td title='$mItemNeededByDate'>" . $mItemNeededByDate . "</td>";
        echo "<td title='$mStatus'>" . $mStatus . "</td>";
    } else {
        echo "<td title='$mItemId'>" . $mItemId . "</td>";
        echo "<td title='$mDescription'>" . $mDescription . "</td>";
        echo "<td title='$mVendorName'>" . $mVendorName . "</td>";
        echo "<td title='$mCatalogNo'>" . $mCatalogNo . "</td>";
        echo "<td title='$$mPrice'>$" . $mPrice . "</td>";
        echo "<td title='$mRequestedByUsername'>" . $mRequestedByUsername . "</td>";
        echo "<td title='$mStatus'>" . $mStatus . "</td>";
    }
    echo "</tr>";
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