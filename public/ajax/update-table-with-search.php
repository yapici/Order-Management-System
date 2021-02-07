<?php
require('../../private/include/include.php');
// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if (filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
    if (!$Session->isSessionValid()) {
        $jsonResponse['status'] = "no_session";
    } else {
        // Getting the parameter passed through AJAX
        $_SESSION['search_keywords'] = html_entity_decode(trim(filter_input(INPUT_GET, 'search_keywords')));
        $_SESSION['pagination_page_number'] = 1;
        $_SESSION['sort_column_name'] = "";

        ob_start();
        require_once(PRIVATE_PATH . 'require/orders-table-body-query.php');
        $jsonResponse['html_tbody'] = ob_get_clean();
        $jsonResponse['html_pagination'] = $pagination;
        if ($Orders->totalNumberOfItems == 1) {
            $jsonResponse['number_of_items'] = $Orders->totalNumberOfItems . " result";
        } else {
            $jsonResponse['number_of_items'] = $Orders->totalNumberOfItems . " results";
        }
        $jsonResponse['status'] = "success";
    }
    echo json_encode($jsonResponse);
} else {
    $Functions->phpRedirect('');
}
?>
