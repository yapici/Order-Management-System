<?php
require('../../private/include/include.php');
// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if (filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
    if (!$Session->isSessionValid()) {
        $jsonResponse['status'] = "no_session";
    } else {
        // Getting the parameter passed through AJAX
        $selectedColumnName = trim(filter_input(INPUT_GET, 'column'));
        $_SESSION['pagination_page_number'] = 1;

        switch ($selectedColumnName) {
            case "Ord":
                $Functions->storeSortInSession('id');
                break;
            case "Des":
                $Functions->storeSortInSession('description');
                break;
            case "Ven":
                $Functions->storeSortInSession('vendor');
                break;
            case "Cat":
                $Functions->storeSortInSession('catalog_no');
                break;
            case "Qua":
                $Functions->storeSortInSession('quantity');
                break;
            case "Acc":
                $Functions->storeSortInSession('account_number');
                break;
            case "Pri":
                $Functions->storeSortInSession('price');
                break;
            case "Sta":
                $Functions->storeSortInSession('status');
                break;
            case "Req":
                $Functions->storeSortInSession('requested_by_username');
                break;
            case "Ite":
                $Functions->storeSortInSession('item_needed_by_date');
                break;
            case "":
                $Functions->storeSortInSession('');
                break;
        }

        ob_start();
        require_once (PRIVATE_PATH . 'require/orders-table-body-query.php');
        $jsonResponse['html_tbody'] = ob_get_clean();
        $jsonResponse['html_pagination'] = $pagination;
        $jsonResponse['status'] = 'success';
        $jsonResponse['up_or_down'] = $_SESSION['sort_up_or_down'];
    }
    echo json_encode($jsonResponse);
} else {
    $Functions->phpRedirect('');
}

?>
