<?php

/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/31/2015                                                                 */
/* Last modified on 03/06/2016                                                           */
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
if (filter_input_fix(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
    // Getting the parameters passed through AJAX
    $email = strtolower(trim(filter_input_fix(INPUT_POST, 'email')));
    $enteredPassword = trim(filter_input_fix(INPUT_POST, 'password'));
    $currentDate = date("Y-m-d H:i:s");
    $hashedPassword = password_hash($enteredPassword, PASSWORD_DEFAULT);
    $array = explode("@", $email, 2);
    $username = $array[0];

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $domain = $Functions->getDomainFromEmail($email);

        if ($domain == Constants::DOMAIN_EMAIL_EXT) {
            // Checking if the email already is in use
            $sql = "SELECT * FROM users ";
            $sql .= "WHERE email = ? ";
            $stmt = $Database->prepare($sql);
            $stmt->bindValue(1, $email, PDO::PARAM_STR);

            $result = $stmt->execute();

            if ($result) {
                if ($stmt->rowCount() == 0) {
                    $activationCode = $Functions->generateRandomString(60);

                    $sql = "INSERT INTO users (";
                    $sql .= "email, password, last_login_date, username, activation";
                    $sql .= ") VALUES (?,?,?,?,?)";

                    $stmt = $Database->prepare($sql);

                    $stmt->bindValue(1, $email, PDO::PARAM_STR);
                    $stmt->bindValue(2, $hashedPassword, PDO::PARAM_STR);
                    $stmt->bindValue(3, $currentDate, PDO::PARAM_STR);
                    $stmt->bindValue(4, $username, PDO::PARAM_STR);
                    $stmt->bindValue(5, $activationCode, PDO::PARAM_STR);
                    $result = $stmt->execute();

                    if ($result) {
                        $emailAdmin = 'enginyapici@gmail.com';
                        $subjectAdmin = "New OMS User Registration";
                        $messageAdmin = "<p>There is a new user registered in Order Management System.</p>";

                        $Email->sendEmail($emailAdmin, 'Admin', $subjectAdmin, $messageAdmin);

                        $subject = "Welcome to Order Management System";
                        $messageBody = "<p>Thank you for your registration</p>";
                        $messageBody .= "<p><div>Please activate your account by clicking the following link:</div>";
                        $messageBody .= "<a href='" . Constants::DOMAIN_NAME_HTTP . "/activation/$activationCode/$email'>Activation Link</a></p>";

                        if ($Email->sendEmail($email, $username, $subject, $messageBody)) {
                            echo "success";
                        } else {
                            echo "mail_fail";
                        }
                    } else {
                        echo 'error';
                    }
                } else {
                    echo "already_exists";
                }
            } else {
                echo 'error';
            }
        } else {
            echo 'invalid_domain_name';
        }
    } else {
        echo 'invalid_email_address';
    }
} else {
    $Functions->phpRedirect('');
}
?>

