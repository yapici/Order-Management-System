<?php

/* ================================================================ */
/* Created by Engin Yapici on 10/23/2015                            */
/* Last modified by Engin Yapici on 10/23/2015                      */
/* Copyright Engin Yapici, 2015.                                    */
/* enginyapici@gmail.com                                            */
/* ================================================================ */

// Below if statements prevents direct access to the file. It can only be accessed through "AJAX".
if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
    require('../../private/include/include.php');
    date_default_timezone_set('America/Chicago');

    // Getting the parameters passed through AJAX
    $gRequestedByUserId = trim($_GET['requestedByUserId']);
    $gLastUpdatedByUserId = trim($_GET['lastUpdatedByUserId']);

    $sql = "SELECT * FROM users ";
    $sql .= "WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(1, $gRequestedByUserId, PDO::PARAM_STR);

    $result = $stmt->execute();

    if ($result) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $requestedByUsername = $row['username'];

        $sql = "SELECT * FROM users ";
        $sql .= "WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->bindValue(1, $gLastUpdatedByUserId, PDO::PARAM_STR);
        $result = $stmt->execute();
        if ($result) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $lastUpdatedByUsername = $row['username'];
            echo $requestedByUsername . "," . $lastUpdatedByUsername;
        } else {
            echo "fail";
        }
    } else {
        echo "fail";
    }
} else {
    echo "Direct access is not permitted";
}
?>
