<?php
require_once('../private/include/include.php');

$email = filter_input_fix(INPUT_GET, 'email');
$code = filter_input_fix(INPUT_GET, 'code');

if ($email == '' || $email == null || $code == '' || $code == null) {
    $Functions->phpRedirect('');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    <head>
        <base href="/"/> 
        <title>Order Management System - Reset Password</title>
        <?php require_once ('include_references.php'); ?>
    </head>

    <body>
        <div class="gray-out-div"></div>
        <img class="progress-circle" src="images/ajax-loader.gif"/>
        <?php require_once (PRIVATE_PATH . 'require/header.php'); ?>   
        <div id="reset-password-main-body-wrapper">
            <h1>Reset Password</h1>
            <p>Please enter your new password in below fields</p>
            <div class="div"><i>New Password:</i></div>
            <div class="div"><input id="password" type="password" placeholder="Password"/></div>
            <div class="div"><i>New Password (Repeat):</i></div>
            <div class="div"><input id="password-repeat" type="password" placeholder="Password"/></div>
            <div><input type="hidden" id="email" value="<?php echo $email; ?>"/></div>
            <div><input type="hidden" id="code" value="<?php echo $code; ?>"/></div>
            <div><a class="button" onclick="resetPassword()">Send</a></div>
        </div>
        <div class="error-div" id="reset-password-error-div"></div>
    </body>
</html>

