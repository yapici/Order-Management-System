<?php
/* ================================================================ */
/* Created by Engin Yapici on 10/19/2015                            */
/* Last modified by Engin Yapici on 10/21/2015                      */
/* Copyright Engin Yapici, 2015.                                    */
/* enginyapici@gmail.com                                            */
/* ================================================================ */

// Below if statements prevents direct access to the file. It can only be accessed through "AJAX".
if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
    require('../../private/include/include.php');
    date_default_timezone_set('America/Chicago');

    // Getting the parameters passed through AJAX
    $email = trim($_POST['email']);
    $entered_password = trim($_POST['password']);
    $is_session_expired_login = trim($_POST['session_expired_login']);
    $current_date = date("Y-m-d H:i:s");

    // Checking if the email already is in use
    $sql = "SELECT * FROM users ";
    $sql .= "WHERE email = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $email, PDO::PARAM_STR);

    $result = $stmt->execute();

    if ($result) {
        if ($stmt->rowCount() == 0) {
            echo "invalid_info";
        } else {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $password1 = $row['password1'];
            $password2 = $row['password2'];
            $password_check = crypt($entered_password, $password2);
            if ($password1 == $password_check) {
                if ($row['account_status'] == '1') {
                    after_successful_login();
                    $_SESSION['id'] = $row['id'];
                    $_SESSION['email'] = $email;

                    $sql = "UPDATE users SET ";
                    $sql .= "last_login_date = ? WHERE id = ?";
                    $stmt = $db->prepare($sql);
                    $stmt->bindValue(1, $current_date, PDO::PARAM_STR);
                    $stmt->bindValue(2, $row['id'], PDO::PARAM_STR);
                    $result = $stmt->execute();

                    echo "success";
                } else {
                    echo "no_activation";
                }
            } else {
                echo "wrong_combination";
            }
        }
    } else {
        echo "fail";
    }
} else {
    echo "Direct access is not permitted";
}
?>
