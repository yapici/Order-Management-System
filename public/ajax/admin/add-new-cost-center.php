<?php
require('../../../private/include/include.php');
// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if (filter_input_fix(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
    if (!$Session->isSessionValid()) {
        $jsonResponse['status'] = "no_session";
    } else {
        // Getting the parameters passed through AJAX
        $sanitizedPostArray = $Functions->sanitizePostedVariables();
        
        if ($CostCenters->addNewCostCenter($sanitizedPostArray)) {
            $CostCenters->refreshArray();
            ob_start();
            $CostCenters->populateCostCentersTable();
            $jsonResponse['html_tbody'] = ob_get_clean();
            $jsonResponse['status'] = "success";
        } else {
            $jsonResponse['status'] = "fail";
        }
    }
    echo json_encode($jsonResponse);
} else {
    $Functions->phpRedirect('');
}

