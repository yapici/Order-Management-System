<?php

/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 10/26/2015                                                                 */
/* Last modified on 12/12/2015                                                           */
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


$gPaginationPageNumber = 1;
$gPaginationStartPoint = 0;
$gNumberOfItemsPerPage = 25;

$sortSqlString = " ORDER BY requested_datetime DESC ";
if (isset($_SESSION['sort_column_name']) && $_SESSION['sort_column_name'] != "") {
    $sortSqlString = " ORDER BY " . $_SESSION['sort_column_name'];
    if ($_SESSION['sort_up_or_down'] == 'up') {
        $sortSqlString .= " ASC ";
    } else {
        $sortSqlString .= " DESC ";
    }
}

if (isset($_SESSION['pagination_page_number'])) {
    $gPaginationPageNumber = $_SESSION['pagination_page_number'];
    $gPaginationStartPoint = ($gPaginationPageNumber - 1) * $gNumberOfItemsPerPage;
}

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
    'vendor',
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
            $searchSqlString .= $columns[$k] . " LIKE :keyword" . $i . $k . " OR ";
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

$sql = "SELECT * FROM orders WHERE deleted = 0";
$sql .= $searchSqlString;
$sql .= $sortSqlString;
$sql .= "LIMIT :start, :item_number";

$stmt = $Database->prepare($sql);
for ($i = 0; $i < count($searchKeywordsArray); $i++) {
    $keyword = $searchKeywordsArray[$i];
    for ($k = 0; $k < count($columns); $k++) {
        $paramName = ":keyword" . $i . $k;
        $colName = substr($columns[$k], -8);
        if ($colName == "datetime") {
            $dateKeyword = $Functions->convertStrDateToMysqlDate($keyword);
            $stmt->bindValue($paramName, $dateKeyword, PDO::PARAM_INT);
        } else {
            $stmt->bindValue($paramName, "%$keyword%", PDO::PARAM_INT);
        }
    }
}
$stmt->bindValue(':start', $gPaginationStartPoint, PDO::PARAM_INT);
$stmt->bindValue(':item_number', $gNumberOfItemsPerPage, PDO::PARAM_INT);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $mItemId = trim($row['id']);
    $mDescription = trim($row['description']);
    $mQuantity = trim($row['quantity']);
    $mUom = trim($row['uom']);
    $mVendor = trim($row['vendor']);
    $mCatalogNo = trim($row['catalog_no']);
    $mPrice = trim($row['price']);
    $mCostCenter = trim($row['cost_center']);
    $mAccountNo = trim($row['account_no']);
    $mComments = htmlspecialchars(trim($row['comments']));
    $mRequestedDate = $Functions->convertMysqlDateToPhpDate($row['requested_datetime']);
    $mLastUpdatedDate = $Functions->convertMysqlDateToPhpDate($row['last_updated_datetime']);
    $mStatus = trim($row['status']);

    $mRequestedByUserId = $row['requested_by_id'];
    $mRequestedByUsername = getUsername($Database, $mRequestedByUserId);
    $mLastUpdatedByUserId = $row['last_updated_by_id'];
    $mLastUpdatedByUsername = getUsername($Database, $mLastUpdatedByUserId);

    echo "<tr onclick=\"showItemDetailsPopupWindow("
    . "'$mItemId', "
    . "'$mDescription',"
    . "'$mQuantity',"
    . "'$mUom',"
    . "'$mVendor',"
    . "'$mCatalogNo',"
    . "'$mPrice',"
    . "'$mCostCenter',"
    . "'$mAccountNo',"
    . "'$mComments',"
    . "'$mRequestedByUsername',"
    . "'$mRequestedDate',"
    . "'$mLastUpdatedByUsername',"
    . "'$mLastUpdatedDate',"
    . "'$mStatus'"
    . ")\">";
    echo "<td title='$mItemId'>" . $mItemId . "</td>";
    echo "<td title='$mDescription'>" . $mDescription . "</td>";
    echo "<td title='$mVendor'>" . $mVendor . "</td>";
    echo "<td title='$mCatalogNo'>" . $mCatalogNo . "</td>";
    echo "<td title='$$mPrice'>$" . $mPrice . "</td>";
    echo "<td title='$mStatus'>" . $mStatus . "</td>";
    echo "<td>None</td>";
    echo "</tr>";
}


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
                $stmt->bindValue($paramName, $dateKeyword, PDO::PARAM_INT);
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

function getUsername($database, $userId) {
    $username = '';

    $sql = "SELECT username FROM users ";
    $sql .= "WHERE id = ?";
    $stmt = $database->prepare($sql);
    $stmt->bindValue(1, $userId, PDO::PARAM_STR);

    $result = $stmt->execute();

    if ($result) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $username = $row['username'];
    }
    return $username;
}

?>