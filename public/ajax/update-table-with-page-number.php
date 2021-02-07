<?php
require('../../private/include/include.php');
// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if (filter_input_fix(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
    if (!$Session->isSessionValid()) {
        $jsonResponse['status'] = "no_session";
    } else {
        // Getting the parameter passed through AJAX
        $_SESSION['pagination_page_number'] = html_entity_decode(trim(filter_input_fix(INPUT_GET, 'page_number')));

        ob_start();
        require_once(PRIVATE_PATH . 'require/orders-table-body-query.php');
        $jsonResponse['html_tbody'] = ob_get_clean();
        $jsonResponse['html_pagination'] = $pagination;
        $jsonResponse['status'] = "success";
    }
    echo json_encode($jsonResponse);
} else {
    $Functions->phpRedirect('');
}
?>
