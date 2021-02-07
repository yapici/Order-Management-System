<?php
require_once('../private/include/include.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    <head>
        <title>Order Management System - Forgot Password</title>
        <?php require_once ('include_references.php'); ?>
    </head>

    <body>
        <div class="gray-out-div"></div>
        <img class="progress-circle" src="images/ajax-loader.gif"/>
        <?php require_once (PRIVATE_PATH . 'require/header.php'); ?>   
        <div id="forgot-password-main-body-wrapper">
            <h1>Forgot Password</h1>
            <p>Please enter your e-mail address below. A link will be sent to reset your password.</p>
            <div><input id="email" type="text" placeholder="E-mail Address"/></div>
            <div><a class="button" onclick="forgotPassword()">Send</a></div>
        </div>
        <div class="error-div" id="forgot-password-error-div"></div>
    </body>
</html>

