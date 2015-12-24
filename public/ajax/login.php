<?php

/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 10/19/2015                                                                 */
/* Last modified on 12/13/2015                                                           */
/* ===================================================================================== */

/* ===================================================================================== */
/* The MIT License                                                                       */
/*                                                                                       */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>.                                 */
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
    date_default_timezone_set('America/Chicago');

    // Getting the parameters passed through AJAX
    $mEmail = trim(filter_input(INPUT_POST, 'email'));
    $mEnteredPassword = trim(filter_input(INPUT_POST, 'password'));
    $mCurrentDate = date("Y-m-d H:i:s");

    if (filter_var($mEmail, FILTER_VALIDATE_EMAIL)) {
        $mDomain = $Functions->getDomainFromEmail($mEmail);

        if ($mDomain == 'example.com') {
            // Checking if the email already is in use
            $sql = "SELECT id, username, password, account_status, user_type FROM users ";
            $sql .= "WHERE email = ?";
            $stmt = $Database->prepare($sql);
            $stmt->bindValue(1, $mEmail, PDO::PARAM_STR);

            $result = $stmt->execute();

            if ($result) {
                if ($stmt->rowCount() == 0) {
                    echo "invalid_info";
                } else {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $hash = $row['password'];
                    if (password_verify($mEnteredPassword, $hash)) {
                        if ($row['account_status'] == '1') {
                            $Session->afterSuccessfulLogin();
                            $_SESSION['id'] = $row['id'];
                            $_SESSION['username'] = $row['username'];
                            $_SESSION['user_type'] = $row['user_type'];
                            $_SESSION['email'] = $mEmail;

                            $sql = "UPDATE users SET ";
                            $sql .= "last_login_date = ? WHERE id = ?";
                            $stmt = $Database->prepare($sql);
                            $stmt->bindValue(1, $mCurrentDate, PDO::PARAM_STR);
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
            echo 'invalid_domain_name';
        }
    } else {
        echo 'invalid_email_address';
    }
} else {
    $Functions->phpRedirect('');
}
?>
