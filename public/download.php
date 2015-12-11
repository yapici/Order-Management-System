<?php
/* ================================================================ */
/* Created by Engin Yapici on 10/23/2015                            */
/* Last modified by Engin Yapici on 10/23/2015                      */
/* Copyright Engin Yapici, 2015.                                    */
/* enginyapici@gmail.com                                            */
/* ================================================================ */

include ('../private/include/functions.php');

$filecode = str_replace(' ', '', $_GET['file']);
$filename = $Functions->decode($filecode);
$filepath = '../private/attachments/' . $filename;

if (file_exists($filepath) && filesize($filepath) > 4096) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($filepath));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filepath));
    ob_clean();
    flush();
    readfile($filepath);
    exit;
} else {
    header("Location: /");
    exit;
}
?>