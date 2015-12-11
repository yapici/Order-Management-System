<?php

/* ================================================================ */
/* Created by Engin Yapici on 10/26/2015                            */
/* Last modified by Engin Yapici on 10/26/2015                      */
/* Copyright Engin Yapici, 2015.                                    */
/* enginyapici@gmail.com                                            */
/* ================================================================ */

// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
    require('../../private/include/include.php');
    
    if (!is_session_valid()) {
        $json_response['status'] = "no_session";
    } else {
        date_default_timezone_set('America/Chicago');
        // Getting the parameters passed through AJAX
        $description = trim($_POST['description']);
        $quantity = trim($_POST['quantity']);
        $uom = trim($_POST['uom']);
        $vendor = trim($_POST['vendor']);
        $catalog_no = trim($_POST['catalog_no']);
        $price = trim($_POST['price']);
        $cost_center = trim($_POST['cost_center']);
        $account_no = trim($_POST['account_no']);
        $comments = trim($_POST['comments']);
        $user_id = $_SESSION['id'];
        $current_date = date("Y-m-d H:i:s");

        // Inserting the information to the database
        $sql = "INSERT INTO orders (";
        $sql .= "description, quantity, uom, vendor, catalog_no, price, cost_center, account_no, comments";
        $sql .= ", requested_by, requested_datetime, last_updated_by, last_updated_datetime, status";
        $sql .= ") VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

        $stmt = $db->prepare($sql);

        $stmt->bindValue(1, $description, PDO::PARAM_STR);
        $stmt->bindValue(2, $quantity, PDO::PARAM_STR);
        $stmt->bindValue(3, $uom, PDO::PARAM_STR);
        $stmt->bindValue(4, $vendor, PDO::PARAM_STR);
        $stmt->bindValue(5, $catalog_no, PDO::PARAM_STR);
        $stmt->bindValue(6, $price, PDO::PARAM_STR);
        $stmt->bindValue(7, $cost_center, PDO::PARAM_STR);
        $stmt->bindValue(8, $account_no, PDO::PARAM_STR);
        $stmt->bindValue(9, $comments, PDO::PARAM_STR);
        $stmt->bindValue(10, $user_id, PDO::PARAM_STR);
        $stmt->bindValue(11, $current_date, PDO::PARAM_STR);
        $stmt->bindValue(12, $user_id, PDO::PARAM_STR);
        $stmt->bindValue(13, $current_date, PDO::PARAM_STR);
        $stmt->bindValue(14, "Pending", PDO::PARAM_STR);
        $result = $stmt->execute();

        if ($result) {
            ob_start();
            require_once('../../private/require/orders-table-body-query.php');
            $json_response['html_tbody'] = ob_get_clean();
            $json_response['status'] = "success";
        } else {
            $json_response['status'] = "fail";
        }
    }
    echo json_encode($json_response);
} else {
    echo "Direct access is not permitted";
}
?>
