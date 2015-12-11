<?php

/* ================================================================ */
/* Created by Engin Yapici on 10/26/2015                            */
/* Last modified by Engin Yapici on 10/26/2015                      */
/* Copyright Engin Yapici, 2015.                                    */
/* enginyapici@gmail.com                                            */
/* ================================================================ */

$sql = "SELECT * FROM orders WHERE deleted = 0";

$stmt = $db->prepare($sql);
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
    $mComments = trim($row['comments']);
    $mRequestedByUserId = $row['requested_by'];
    $mRequestedDate = convert_mysql_date_to_php_date($row['requested_datetime']);
    $mLastUpdatedByUserId = $row['last_updated_by'];
    $mLastUpdatedDate = convert_mysql_date_to_php_date($row['last_updated_datetime']);
    $mStatus = trim($row['status']);

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
    . "'$mRequestedByUserId',"
    . "'$mRequestedDate',"
    . "'$mLastUpdatedByUserId',"
    . "'$mLastUpdatedDate',"
    . "'$mStatus'"
    . ")\">";
    echo "<td>" . $mItemId . "</td>";
    echo "<td>" . $mDescription . "</td>";
    echo "<td>" . $mVendor . "</td>";
    echo "<td>" . $mCatalogNo . "</td>";
    echo "<td>$" . $mPrice . "</td>";
    echo "<td>" . $mStatus . "</td>";
    echo "<td>None</td>";
    echo "</tr>";
}
?>