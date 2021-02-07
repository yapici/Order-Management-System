<?php
require('../../../private/include/include.php');
// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if (filter_input_fix(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
    $adminCheckResponse = $Admin->ajaxAdminChecks();
    if ($adminCheckResponse !== true) {
        $jsonResponse['status'] = $adminCheckResponse;
    } else {
        // Getting the parameters passed through AJAX
        $sanitizedPostArray = $Functions->sanitizePostedVariables();
        $postedCostCenterId = $sanitizedPostArray['cost_center'];
        $postedProjectId = $sanitizedPostArray['project'];
        $postedOrderId = trim(substr($sanitizedPostArray['order_id'], 5));
        $postedStatus = $sanitizedPostArray['status'];

        if ($ItemDetails->updateItemDetails($sanitizedPostArray)) {
            
            if ($postedStatus == 'Ordered') {
                $ItemDetails->sendStatusChangeEmail($postedOrderId, 'Ordered');
            } else if ($postedStatus == 'Backordered') {
                $ItemDetails->sendStatusChangeEmail($postedOrderId, 'Backordered');
            } else if ($postedStatus == 'Delivered') {
                $ItemDetails->sendStatusChangeEmail($postedOrderId, 'Delivered');
            }
            
            ob_start();
            require_once(PRIVATE_PATH . 'require/orders-table-body-query.php');
            $jsonResponse['html_tbody'] = ob_get_clean();
            $jsonResponse['html_pagination'] = $pagination;
            $jsonResponse['cost_center_name'] = $CostCenters->getCostCentersArray()[$postedCostCenterId]['name'];
            $jsonResponse['description'] = $sanitizedPostArray['description'];
            $jsonResponse['quantity'] = $sanitizedPostArray['quantity'];
            $jsonResponse['catalog_no'] = $sanitizedPostArray['catalog_no'];
            $jsonResponse['uom'] = $sanitizedPostArray['uom'];
            $jsonResponse['weblink'] = $sanitizedPostArray['weblink'];
            $jsonResponse['comments'] = $sanitizedPostArray['comments'];
            $jsonResponse['sds'] = $sanitizedPostArray['sds'];
            $jsonResponse['invoice_no'] = $sanitizedPostArray['invoice_no'];
            $jsonResponse['vendor_order_no'] = $sanitizedPostArray['vendor_order_no'];
            $jsonResponse['vendor_name'] = $Vendors->getVendorsArray()[$sanitizedPostArray['vendor']]['name'];
            $jsonResponse['price'] = $sanitizedPostArray['price'];
            $jsonResponse['user'] = $_SESSION['username'];
            $jsonResponse['date'] = date('d-M-Y');
            
            $project = $Projects->getProjectsArray()[$postedProjectId];
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

