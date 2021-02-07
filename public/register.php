<?php
require_once('../private/include/include.php');

if ($Session->isSessionValid()) {
    $Functions->phpRedirect('orders');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    <head>
        <title>Order Management System</title>
        <?php
        require_once ('include_references.php');
        ?>
    </head>

    <body>
        <div class="gray-out-div"></div>
        <img class="progress-circle" src="images/ajax-loader.gif"/>
        <?php require_once (PRIVATE_PATH . 'require/header.php'); ?> 
        <div id="register-main-body-wrapper">
            <h1>Register</h1>
            <div><input id="email" type="text" placeholder="E-mail Address" maxlength="111"/></div>
            <div><input id="password" type="password" placeholder="Password"/></div>
            <div><input id="password-repeat" type="password" placeholder="Password"/></div>
            <div><a class="button" onclick="registerUser()">Submit</a></div>
        </div>
        <div><a class='text-only-button' href="/">Already have an account? Log in here</a></div>
        <div><a class='text-only-button' href="/forgot-password">Forgot password?</a></div>
        <div class="error-div" id="register-error-div"></div>
    </body>
</html>

