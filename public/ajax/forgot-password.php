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

require('../../private/include/include.php');
// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if (filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {

    // Getting the parameters passed through AJAX
    $email = trim(filter_input(INPUT_POST, 'email'));

    $forgotPassword = $Functions->generateRandomString(60);

    // Inserting the information to the database
    $sql = "UPDATE users SET ";
    $sql .= "forgot_password = ?, password_reset = 1 WHERE email = ?";

    $stmt = $Database->prepare($sql);

    $stmt->bindValue(1, $forgotPassword, PDO::PARAM_STR);
    $stmt->bindValue(2, $email, PDO::PARAM_STR);
    $result = $stmt->execute();

    if ($result) {
        $subject = "OMS Notification: Password Reset Request";
        $messageBody = "<p>Please follow the below link to reset your password:</p>";
        $messageBody .= "<a href='" . Constants::DOMAIN_NAME_HTTP . "/reset-password/$forgotPassword/$email'>Reset my password</a>";
        
        if ($Email->sendEmail($email, $username, $subject, $messageBody)) {
            echo "success";
        } else {
            echo "mail_fail";
        }
    } else {
        echo "fail";
    }
} else {
    $Functions->phpRedirect('');
}
?>


