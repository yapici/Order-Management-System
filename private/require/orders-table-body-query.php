<?php

/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 10/26/2015                                                                 */
/* Last modified on 12/15/2015                                                           */
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
    'account_no',
    'comments',
    'status',
    'vendor_name',
    'requested_datetime',
    'last_updated_datetime',
    'last_updated_by_username',
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
            if (substr($columns[$k], -8) == "datetime") {
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
$sql .= "vendor, ";
$sql .= "catalog_no, ";
$sql .= "price, ";
$sql .= "cost_center, ";
$sql .= "project_name, ";
$sql .= "project_no, ";
$sql .= "account_no, ";
$sql .= "comments, ";
$sql .= "requested_datetime, ";
$sql .= "last_updated_datetime, ";
$sql .= "status, ";
$sql .= "requested_by_username, ";
$sql .= "item_needed_by_date, ";
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
        $colName = substr($columns[$k], -8);
        if ($colName == "datetime") {
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

// Getting the vendor names and putting them in a local array
$sql1 = "SELECT id, name FROM vendors WHERE 1";
$stmt1 = $Database->prepare($sql1);
$stmt1->execute();
while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
    $vendorsArray[$row1['id']] = $row1['name'];
}
/* ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ ^ */
/* | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | */
/* ######################################################### Database Query ######################################################## */


/* ########################################################## tbody Content ######################################################## */
/* | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | | */
/* V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V V */
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $sanitizedArray = $Functions->sanitizeArrayItems($row);
    $mItemId = $sanitizedArray['id'];
    $mDescription = $sanitizedArray['description'];
    $mQuantity = $sanitizedArray['quantity'];
    $mUom = $sanitizedArray['uom'];
    $mVendor = $vendorsArray[$sanitizedArray['vendor']];
    $mCatalogNo = $sanitizedArray['catalog_no'];
    $mPrice = $sanitizedArray['price'];
    $mCostCenter = $sanitizedArray['cost_center'];
    $mProjectName = $sanitizedArray['project_name'];
    $mProjectNo = $sanitizedArray['project_no'];
    $mAccountNo = $sanitizedArray['account_no'];
    $mComments = $sanitizedArray['comments'];
    $mRequestedDate = $Functions->convertMysqlDateToPhpDate($sanitizedArray['requested_datetime']);
    $mLastUpdatedDate = $Functions->convertMysqlDateToPhpDate($sanitizedArray['last_updated_datetime']);
    $mItemNeededByDate = $Functions->convertMysqlDateToPhpDate($sanitizedArray['item_needed_by_date']);
    $mStatus = trim($row['status']);
    $mRequestedByUsername = $sanitizedArray['requested_by_username'];
    $mLastUpdatedByUsername = $sanitizedArray['last_updated_by_username'];

    echo "<tr onclick=\"showItemDetailsPopupWindow("
    . "'$mItemId', "
    . "'$mDescription', "
    . "'$mQuantity', "
    . "'$mUom', "
    . "'$mVendor', "
    . "'$mCatalogNo', "
    . "'$mPrice', "
    . "'$mCostCenter', "
    . "'$mProjectName', "
    . "'$mProjectNo', "
    . "'$mAccountNo', "
    . "'$mComments', "
    . "'$mRequestedByUsername', "
    . "'$mRequestedDate', "
    . "'$mLastUpdatedByUsername', "
    . "'$mLastUpdatedDate', "
    . "'$mStatus', "
    . "'$mItemNeededByDate'"
    . ")\">";
    echo "<td title='$mItemId'>" . $mItemId . "</td>";
    echo "<td title='$mDescription'>" . $mDescription . "</td>";
    echo "<td title='$mVendor'>" . $mVendor . "</td>";
    echo "<td title='$mCatalogNo'>" . $mCatalogNo . "</td>";
    echo "<td title='$$mPrice'>$" . $mPrice . "</td>";
    echo "<td title='$mRequestedByUsername'>" . $mRequestedByUsername . "</td>";
    echo "<td title='$mStatus'>" . $mStatus . "</td>";
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
            $colName = substr($columns[$k], -8);
            if ($colName == "datetime") {
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