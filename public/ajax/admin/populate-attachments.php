<?php
require('../../../private/include/include.php');
// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if (filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
    if (!$Session->isSessionValid()) {
        $jsonResponse['status'] = "no_session";
    } else {
        $orderId = filter_input(INPUT_GET, 'order_id');
        $jsonResponse['html_response'] = $Functions->includeAttachments($orderId, true, true);
    }
    echo json_encode($jsonResponse);
} else {
    $Functions->phpRedirect('');
}
?>