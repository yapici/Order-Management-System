<?php
require('../../../private/include/include.php');
// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if (filter_input_fix(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
    if (!$Session->isSessionValid()) {
        $jsonResponse['status'] = "no_session";
    } else {
        // Getting the parameter passed through AJAX
        $selectedColumnName = trim(filter_input_fix(INPUT_GET, 'column'));
        
        if ($selectedColumnName == "added_by") {
            $selectedColumnName = "added_by_username";
        }

        if (isset($_SESSION['vendor_sort_column_name']) &&
                $_SESSION['vendor_sort_column_name'] == $selectedColumnName &&
                $_SESSION['vendor_sort_up_or_down'] == 'up') {
            $_SESSION['vendor_sort_up_or_down'] = 'down';
        } else {
            $_SESSION['vendor_sort_up_or_down'] = 'up';
            $_SESSION['vendor_sort_column_name'] = $selectedColumnName;
        }

        $Vendors->refreshArraysWithSort();
        ob_start();
        $Vendors->populateVendorsTable();
        $jsonResponse['html_tbody'] = ob_get_clean();
        $jsonResponse['status'] = 'success';
        $jsonResponse['up_or_down'] = $_SESSION['vendor_sort_up_or_down'];
    }
    echo json_encode($jsonResponse);
} else {
    $Functions->phpRedirect('');
}

?>
