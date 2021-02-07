<?php
/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 01/03/2016                                                                 */
/* Last modified on 01/03/2016                                                           */
/* ===================================================================================== */

/* ===================================================================================== */
/* The MIT License                                                                       */
/*                                                                                       */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>.                                 */
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

