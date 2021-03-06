<?php
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
        $sds = $orderDetailsArray['sds'];
        $requestedDate = $Functions->convertMysqlDateToPhpDate($orderDetailsArray['requested_datetime']);
        $statusUpdatedDate = $Functions->convertMysqlDateToPhpDate($orderDetailsArray['status_updated_date']);
        $itemNeededByDate = $Functions->convertMysqlDateToPhpDate($orderDetailsArray['item_needed_by_date']);
        $requestedByUsername = $orderDetailsArray['requested_by_username'];
        $statusUpdatedByUsername = $orderDetailsArray['status_updated_by_username'];
        $ordered = $orderDetailsArray['ordered'];
        $orderedDate = $orderDetailsArray['ordered_date'];
        $orderedByUsername = $orderDetailsArray['ordered_by_username'];
        $delivered = $orderDetailsArray['delivered'];
        $deliveredDate = $orderDetailsArray['delivered_date'];
        $deliveredByUsername = $orderDetailsArray['delivered_by_username'];
        
        $status = $orderDetailsArray['status'];
        $requestedById = $orderDetailsArray['requested_by_id'];
        $loggedInUserId = $_SESSION['id'];
        $isEditable = 'false';
        
        if ($status == "Pending" && $requestedById == $loggedInUserId) {
            $isEditable = 'true';
        }

        if ($orderedDate != '0000-00-00 00:00:00' && $orderedDate != '') {
            $orderedDate = $Functions->convertMysqlDateToPhpDate($orderedDate);
        }

        if ($deliveredDate != '0000-00-00 00:00:00' && $deliveredDate != '') {
            $deliveredDate = $Functions->convertMysqlDateToPhpDate($deliveredDate);
        }

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
            $projectDetails = $Projects->getProjectsArray()[$projectId];
            $project = $projectDetails['name'];
            if ($projectDetails['number'] != '') {
                $project .= ' / ' . $projectDetails['number'];
            }
        }

        $popupWindowParamArray = array($itemId, $description, $quantity, $uom, $vendorName, $catalogNo,
            $price, $weblink, $costCenterName, $project, $comments, $requestedByUsername, $requestedDate,
            $statusUpdatedByUsername, $statusUpdatedDate, $status, $itemNeededByDate, $ordered, $orderedDate,
            $orderedByUsername, $delivered, $deliveredDate, $deliveredByUsername, $isEditable, $sds, $vendorId
        );
        echo "<tr onclick='showItemDetailsPopupWindow(";
        echoJsFunctionParams($popupWindowParamArray);
        echo ");";
        if ($Admin->isAdmin()) {
            $popupWindowAdminParamArray = array($itemId, $vendorAccountNo, $invoiceNo, $vendorOrderNo);
            echo " showItemDetailsPopupWindowAdmin(";
            echoJsFunctionParams($popupWindowAdminParamArray);
            echo ");";

            $inputParamsArray = array($description, $quantity, $uom, $vendorName, $catalogNo,
                $price, $weblink, $costCenterName, $project, $comments, $invoiceNo, $vendorOrderNo, $status, $sds
            );
            echo " prepareItemDetailsPopupWindowInputs(";
            echoJsFunctionParams($inputParamsArray);
            echo ");";
        } elseif ($isEditable == "true") {
            $inputParamsArray = array($description, $quantity, $uom, $vendorName, $catalogNo,
                $price, $weblink, $costCenterName, $project, $comments, $sds
            );
            echo " prepareItemEditInputs(";
            echoJsFunctionParams($inputParamsArray);
            echo ");";
        }
        echo "'>";
        if ($Admin->isAdmin()) {
            echo "<td title='$itemId'>" . $itemId . "</td>";
            echo "<td title=\"$description\"><div>" . $description . "</div></td>";
            echo "<td title='$vendorName'><div>" . $vendorName . "</div></td>";
            echo "<td title='$catalogNo'><div>" . $catalogNo . "</div></td>";
            echo "<td title='$quantity'><div>" . $quantity . "</div></td>";
            echo "<td title='$requestedByUsername'>" . $requestedByUsername . "</td>";
            echo "<td title='$itemNeededByDate'>" . $itemNeededByDate . "</td>";
            echo "<td title='$status'>" . $status . "</td>";
        } else {
            echo "<td title='$itemId'>" . $itemId . "</td>";
            echo "<td title='$description'><div>" . $description . "</div></td>";
            echo "<td title='$vendorName'><div>" . $vendorName . "</div></td>";
            echo "<td title='$catalogNo'><div>" . $catalogNo . "</div></td>";
            echo "<td title='$requestedByUsername'>" . $requestedByUsername . "</td>";
            if ($status != 'In Concur') {
                echo "<td title='$status'>" . $status . "</td>";
            } else {
                echo "<td title='Delivered'>Delivered</td>";
            }
        }
        echo "</tr>";
    }
}

function echoJsFunctionParams($paramArray) {
    global $Functions;
    $totalNumberOfParams = count($paramArray);
    $lastParam = $totalNumberOfParams - 1;
    for ($i = 0; $i < $totalNumberOfParams; $i++) {
        $param = $paramArray[$i];
        if ($i == $lastParam) {
            echo "\"" . $Functions->escapeQuotes($param) . "\"";
        } else {
            echo "\"" . $Functions->escapeQuotes($param) . "\", ";
        }
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