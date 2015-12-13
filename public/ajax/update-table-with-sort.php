<?php

/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/12/2015                                                                 */
/* Last modified on 12/12/2015                                                           */
/* ===================================================================================== */

/* ===================================================================================== */
/* The MIT License                                                                       */
/*                                                                                       */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>.                                 */
/*                                                                                       */
/* Permission is hereby granted, free of charge, to any person obtaining a copy          */
/* of this software and associated documentation files (the "Software"), to deal         */
/* in the Software without restriction, including without limitation the rights          */
/* to use, copy, modify, merge, publish, distribute, sublicense, and/or sell             */
/* copies of the Software, and to permit persons to whom the Software is                 */
/* furnished to do so, subject to the following conditions:                              */
/*                                                                                       */
/* The above copyright notice and this permission notice shall be included in            */
/* all copies or substantial portions of the Software.                                   */
/*                                                                                       */
/* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR            */
/* IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,              */
/* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE           */
/* AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER                */
/* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,         */
/* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN             */
/* THE SOFTWARE.                                                                         */
/* ===================================================================================== */

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
                storeSortInSession('id');
                break;
            case "Des":
                storeSortInSession('description');
                break;
            case "Ven":
                storeSortInSession('vendor');
                break;
            case "Cat":
                storeSortInSession('catalog_no');
                break;
            case "Pri":
                storeSortInSession('price');
                break;
            case "Sta":
                storeSortInSession('status');
                break;
            case "":
                $_SESSION['sort_column_name'] = "";
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

function storeSortInSession($columnName) {
    if ($_SESSION['sort_column_name'] == $columnName && $_SESSION['sort_up_or_down'] == 'up') {
        $_SESSION['sort_up_or_down'] = 'down';
    } else {
        $_SESSION['sort_up_or_down'] = 'up';
        $_SESSION['sort_column_name'] = $columnName;
    }
}

?>
