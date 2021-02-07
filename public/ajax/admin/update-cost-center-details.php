<?php
require('../../../private/include/include.php');
// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if (filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
    $adminCheckResponse = $Admin->ajaxAdminChecks();
    if ($adminCheckResponse !== true) {
        $jsonResponse['status'] = $adminCheckResponse;
    } else {
        // Getting the parameters passed through AJAX
        $sanitizedPostArray = $Functions->sanitizePostedVariables();
        
        $costCenterId = $sanitizedPostArray['cost_center_id'];
        $fieldName = $sanitizedPostArray['field_name'];
        $value = $sanitizedPostArray['value'];

        if ($CostCenters->updateCostCenter($costCenterId, $fieldName, $value)) {
            $CostCenters->refreshArray();
            $jsonResponse['status'] = "success";
        } else {
            $jsonResponse['status'] = "fail";
        }
    }
    echo json_encode($jsonResponse);
} else {
    $Functions->phpRedirect('');
}

