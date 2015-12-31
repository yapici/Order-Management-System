<?php
/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/31/2015                                                                 */
/* Last modified on 12/31/2015                                                           */
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

require_once('../private/include/include.php');

if ($Session->isSessionValid()) {
    $Functions->phpRedirect('orders');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    <head>
        <base href="/"> 
            <title>Order Management System</title>
            <?php
            require_once ('include_references.php');
            ?>
    </head>

    <body>
        <?php require_once (PRIVATE_PATH . 'require/header.php'); ?> 
        <div id="activation-main-body-wrapper">
            <?php
            $errorMessage = "<h1>Something Went Wrong</h1>";
            $errorMessage .= "<div>Your account could not be activated. Please contact the webmaster.</div>";

            if (filter_input(INPUT_GET, 'activation_code') !== null &&
                    filter_input(INPUT_GET, 'email') !== null) {
                $code = trim(filter_input(INPUT_GET, 'activation_code'));
                $email = trim(filter_input(INPUT_GET, 'email'));

                $sql = "SELECT * FROM users ";
                $sql .= "WHERE email = ? and activation = ?";
                $stmt = $Database->prepare($sql);
                $stmt->bindValue(1, $email, PDO::PARAM_STR);
                $stmt->bindValue(2, $code, PDO::PARAM_STR);

                $result = $stmt->execute();

                if ($result) {
                    if ($stmt->rowCount() == 0) {
                        echo "<h1>Invalid Activation Code</h1>"
                        . "<div>The activation code is invalid. Please do not modify the link provided in the e-mail. If the problem persists, please contact an administrator to activate your account.</div>";
                    } else {
                        $sql = "UPDATE users SET ";
                        $sql .= "account_status = 1 WHERE email = ?";
                        $stmt = $Database->prepare($sql);
                        $stmt->bindValue(1, $email, PDO::PARAM_STR);
                        $result = $stmt->execute();
                        
                        if ($result) {
                            $sql = "SELECT id, username, password, account_status, user_type FROM users ";
                            $sql .= "WHERE email = ?";
                            $stmt = $Database->prepare($sql);
                            $stmt->bindValue(1, $email, PDO::PARAM_STR);

                            $result = $stmt->execute();

                            if ($result) {
                                if ($stmt->rowCount() == 0) {
                                    echo $errorMessage;
                                } else {
                                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                                    $Session->afterSuccessfulLogin();
                                    $_SESSION['id'] = $row['id'];
                                    $_SESSION['username'] = $row['username'];
                                    $_SESSION['user_type'] = $row['user_type'];
                                    $_SESSION['email'] = $email;

                                    echo "<h1>Account Activated</h1>"
                                    . "<div>Thank you for activating your account. You will be redirected to the orders page in 10 seconds.</div>"
                                    . "<div>Please click the following link if you are not redirected:</div>"
                                    . "<div><a href='" . Constants::DOMAIN_NAME_HTTP . "/orders'><u>Orders Page</u></a></div>";
                                    echo "<meta http-equiv='refresh' content='8;url=/orders'>";
                                }
                            } else {
                                echo $errorMessage;
                            }
                        } else {
                            echo $errorMessage;
                        }
                    }
                } else {
                    echo $errorMessage;
                }
            } else {
                echo "<h1>No Activation Code</h1>";
                echo "<div>No activation code was found. Please check your e-mail for an activation link.</div>";
            }
            ?>
        </div>
    </body>
</html>



