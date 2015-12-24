<?php

/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 10/26/2015                                                                 */
/* Last modified on 12/23/2015                                                           */
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


/* ############################################################# Sort ############################################################## */
/* | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | */
/* V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V */
$sortSqlString = " ORDER BY requested_datetime DESC ";
if (isset($_SESSION['sort_column_name']) && $_SESSION['sort_column_name'] != "") {
    $sortSqlString = " ORDER BY " . $_SESSION['sort_column_name'];
    if ($_SESSION['sort_up_or_down'] == 'up') {
        $sortSqlString .= " ASC ";
    } else {
        $sortSqlString .= " DESC ";
    }
}
/* ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ */
/* | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | */
/* ############################################################# Sort ############################################################## */



/* ########################################################## Pagination ########################################################### */
/* | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | */
/* V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V */
$gPaginationPageNumber = 1;
$gPaginationStartPoint = 0;
$gNumberOfItemsPerPage = 25;

if (isset($_SESSION['pagination_page_number'])) {
    $gPaginationPageNumber = $_SESSION['pagination_page_number'];
    $gPaginationStartPoint = ($gPaginationPageNumber - 1) * $gNumberOfItemsPerPage;
}
/* ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ */
/* | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | */
/* ########################################################## Pagination ########################################################### */



/* ############################################################ Search ############################################################# */
/* | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | */
/* V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V */
$columns = ['id',
    'description',
    'uom',
    'catalog_no',
    'price',
    'account_number',
    'project_name_and_number',
    'comments',
    'status',
    'vendor_name',
    'requested_datetime',
    'last_updated_datetime',
    'last_updated_by_username',
    'item_needed_by_date',
    'ordered_date',
    'requested_by_username'
];
$searchSqlString = " ";
$searchKeywordsArray = array();
if (isset($_SESSION['search_keywords']) && $_SESSION['search_keywords'] != "" && $_SESSION['search_keywords'] != "Search") {
    $searchKeywordsString = $_SESSION['search_keywords'];
    $searchKeywordsArray = preg_split('/[\s]+/', $searchKeywordsString);
    for ($i = 0; $i < count($searchKeywordsArray); $i++) {
        $searchSqlString .= "AND (";
        for ($k = 0; $k < count($columns); $k++) {
            if (substr($columns[$k], -8) == "datetime" || substr($columns[$k], -4) == "date") {
                $searchSqlString .= '(' . $columns[$k] . " BETWEEN :keyword" . $i . $k . "a AND :keyword" . $i . $k . "b) OR ";
            } else {
                $searchSqlString .= $columns[$k] . " LIKE :keyword" . $i . $k . " OR ";
            }
        }
        $searchSqlString = substr_replace($searchSqlString, "", -3); // to remove the 'OR' at the end.
        $searchSqlString .= ") ";
    }
} else {
    $search_keywords = "%";
}
/* ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ */
/* | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | */
/* ############################################################ Search ############################################################# */



/* ######################################################### Database Query ######################################################## */
/* | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | */
/* V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V */
$sql = "SELECT ";
$sql .= "id, ";
$sql .= "description, ";
$sql .= "quantity, ";
$sql .= "uom, ";
$sql .= "vendor_name, ";
$sql .= "catalog_no, ";
$sql .= "price, ";
$sql .= "weblink, ";
$sql .= "cost_center, ";
$sql .= "project, ";
$sql .= "account_id, ";
$sql .= "comments, ";
$sql .= "requested_datetime, ";
$sql .= "last_updated_datetime, ";
$sql .= "status, ";
$sql .= "requested_by_username, ";
$sql .= "item_needed_by_date, ";
$sql .= "ordered, ";
$sql .= "ordered_date, ";
$sql .= "ordered_by_username, ";
if ($Admin->isAdmin()) {
    $sql .= "vendor_order_no, ";
    $sql .= "invoice_no, ";
}
$sql .= "last_updated_by_username ";
$sql .= "FROM orders WHERE deleted = 0";
$sql .= $searchSqlString;
$sql .= $sortSqlString;
$sql .= "LIMIT :start, :item_number";

$stmt = $Database->prepare($sql);

/* Search Keywords */
for ($i = 0; $i < count($searchKeywordsArray); $i++) {
    $keyword = $searchKeywordsArray[$i];
    for ($k = 0; $k < count($columns); $k++) {
        $paramName = ":keyword" . $i . $k;
        if (substr($columns[$k], -8) == "datetime" || substr($columns[$k], -4) == "date") {
            $dateKeyword = $Functions->convertStrDateToMysqlDate($keyword);
            $stmt->bindValue($paramName . 'a', $dateKeyword . ' 00:00:00', PDO::PARAM_STR);
            $stmt->bindValue($paramName . 'b', $dateKeyword . ' 23:59:59', PDO::PARAM_STR);
        } else {
            $stmt->bindValue($paramName, "%$keyword%", PDO::PARAM_INT);
        }
    }
}

/* Pagination page number */
$stmt->bindValue(':start', $gPaginationStartPoint, PDO::PARAM_INT);

/* Number of items for a page */
$stmt->bindValue(':item_number', $gNumberOfItemsPerPage, PDO::PARAM_INT);
$stmt->execute();
/* ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ */
/* | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | */
/* ######################################################### Database Query ######################################################## */


/* ########################################################## tbody Content ######################################################## */
/* | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | */
/* V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V */
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $sanitizedArray = $Functions->sanitizeArray($row);
    $mItemId = $sanitizedArray['id'];
    $mDescription = $sanitizedArray['description'];
    $mQuantity = $sanitizedArray['quantity'];
    $mUom = $sanitizedArray['uom'];
    $mVendor = $sanitizedArray['vendor_name'];
    $mCatalogNo = $sanitizedArray['catalog_no'];
    $mPrice = $sanitizedArray['price'];
    $mWeblink = $sanitizedArray['weblink'];
    $mCostCenter = $sanitizedArray['cost_center'];
    $mProjectId = $sanitizedArray['project'];
    $mAccountId = $sanitizedArray['account_id'];
    $mComments = $sanitizedArray['comments'];
    $mRequestedDate = $Functions->convertMysqlDateToPhpDate($sanitizedArray['requested_datetime']);
    $mLastUpdatedDate = $Functions->convertMysqlDateToPhpDate($sanitizedArray['last_updated_datetime']);
    $mItemNeededByDate = $Functions->convertMysqlDateToPhpDate($sanitizedArray['item_needed_by_date']);
    $mStatus = $sanitizedArray['status'];
    $mRequestedByUsername = $sanitizedArray['requested_by_username'];
    $mLastUpdatedByUsername = $sanitizedArray['last_updated_by_username'];
    $mOrdered = $sanitizedArray['ordered'];
    $mOrderedDate = $sanitizedArray['ordered_date'];
    if ($mOrderedDate != '0000-00-00 00:00:00' || $mOrderedDate != '') {
        $mOrderedDate = $Functions->convertMysqlDateToPhpDate($mOrderedDate);
    }
    $mOrderedByUsername = $sanitizedArray['ordered_by_username'];

    if ($Admin->isAdmin()) {
        $mVendorOrderNo = $sanitizedArray['vendor_order_no'];
        $mInvoiceNo = $sanitizedArray['invoice_no'];
    }

    $mCostCenterName = $CostCenters->getCostCentersArray()[$mCostCenter];
    
    $mVendorAccountNo = '';
    if ($mAccountId != '') {
        $mVendorAccountNo = $AccountNumbers->getAccountNumbersArray()[$mAccountId];
    }
    
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
    . "'$mVendor', "
    . "'$mCatalogNo', "
    . "'$mPrice', "
    . "'$mWeblink', "
    . "'$mCostCenterName', "
    . "'$mProject', "
    . "'$mComments', "
    . "'$mRequestedByUsername', "
    . "'$mRequestedDate', "
    . "'$mLastUpdatedByUsername', "
    . "'$mLastUpdatedDate', "
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
        . "'$mVendor', "
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
        echo "<td title='$mVendor'>" . $mVendor . "</td>";
        echo "<td title='$mCatalogNo'>" . $mCatalogNo . "</td>";
        echo "<td title='$mVendorAccountNo'>" . $mVendorAccountNo . "</td>";
        echo "<td title='$mRequestedByUsername'>" . $mRequestedByUsername . "</td>";
        echo "<td title='$mItemNeededByDate'>" . $mItemNeededByDate . "</td>";
        echo "<td title='$mStatus'>" . $mStatus . "</td>";
    } else {
        echo "<td title='$mItemId'>" . $mItemId . "</td>";
        echo "<td title='$mDescription'>" . $mDescription . "</td>";
        echo "<td title='$mVendor'>" . $mVendor . "</td>";
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
$totalNumberOfItems = getTotalNumberOfItems($Database, $Functions, $searchSqlString, $searchKeywordsArray, $sortSqlString, $columns);

require_once('orders-table-pagination.php');

function getTotalNumberOfItems($database, $functions, $searchSqlString, $searchKeywordsArray, $sortSqlString, $columns) {
    $sql = "SELECT * FROM orders WHERE deleted = 0" . $searchSqlString . $sortSqlString;

    $stmt = $database->prepare($sql);
    for ($i = 0; $i < count($searchKeywordsArray); $i++) {
        $keyword = $searchKeywordsArray[$i];
        for ($k = 0; $k < count($columns); $k++) {
            $paramName = ":keyword" . $i . $k;
            if (substr($columns[$k], -8) == "datetime" || substr($columns[$k], -4) == "date") {
                $dateKeyword = $functions->convertStrDateToMysqlDate($keyword);
                $stmt->bindValue($paramName . 'a', $dateKeyword . ' 00:00:00', PDO::PARAM_STR);
                $stmt->bindValue($paramName . 'b', $dateKeyword . ' 23:59:59', PDO::PARAM_STR);
            } else {
                $stmt->bindValue($paramName, "%$keyword%", PDO::PARAM_INT);
            }
        }
    }
    $stmt->execute();
    return $stmt->rowCount();
}

/* ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ */
/* | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | */
/* ########################################################## Pagination ########################################################### */
?>