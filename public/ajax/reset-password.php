<?php

/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 01/03/2016                                                                 */
/* Last modified on 02/15/2016                                                           */
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
    $sanitizedPostArray = $Functions->sanitizePostedVariables();
    $email = $sanitizedPostArray['email'];
    $code = $sanitizedPostArray['code'];
    $enteredPassword = $sanitizedPostArray['password'];
    $hashedPassword = password_hash($enteredPassword, PASSWORD_DEFAULT);

    if ($email == "1" && $code == "1") {
        if (isset($_SESSION['id']) && $_SESSION['id'] != "" && $_SESSION['id'] != null) {
            $userId = $_SESSION['id'];
            
            $sql = "SELECT id FROM users ";
            $sql .= "WHERE id = :id AND password_reset = 1";
            $stmt = $Database->prepare($sql);
            $stmt->bindValue(':id', $userId, PDO::PARAM_STR);

            if ($stmt->execute()) {
                if ($stmt->rowCount() == 1) {
                        $sql = "UPDATE users SET ";
                        $sql .= "password_reset = 0, password = :password WHERE id = :id AND password_reset = 1";

                        $stmt = $Database->prepare($sql);

                        $stmt->bindValue(":password", $hashedPassword, PDO::PARAM_STR);
                        $stmt->bindValue(":id", $userId, PDO::PARAM_STR);

                        if ($stmt->execute()) {
                            $jsonResponse['status'] = 'success';
                        } else {
                            $jsonResponse['status'] = 'fail';
                        }
                } else {
                    $jsonResponse['status'] = 'no_password_reset_request_found_for_user';
                }
            } else {
                $jsonResponse['status'] = 'fail';
            }
        } else {
            $jsonResponse['status'] = 'no_password_reset_request_found_for_user';
        }
    } else {
        $sql = "SELECT id FROM users ";
        $sql .= "WHERE email = :email AND password_reset = 1";
        $stmt = $Database->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);

        if ($stmt->execute()) {
            if ($stmt->rowCount() == 1) {
                $sql = "SELECT * FROM users ";
                $sql .= "WHERE email = :email AND forgot_password = :code";
                $stmt = $Database->prepare($sql);
                $stmt->bindValue(":email", $email, PDO::PARAM_STR);
                $stmt->bindValue(":code", $code, PDO::PARAM_STR);

                if ($stmt->execute()) {
                    if ($stmt->rowCount() == 1) {
                        $sql = "UPDATE users SET ";
                        $sql .= "password_reset = 0, password = :password WHERE email = :email AND forgot_password = :forgot_password";

                        $stmt = $Database->prepare($sql);

                        $stmt->bindValue(":password", $hashedPassword, PDO::PARAM_STR);
                        $stmt->bindValue(":email", $email, PDO::PARAM_STR);
                        $stmt->bindValue(":forgot_password", $code, PDO::PARAM_STR);

                        if ($stmt->execute()) {
                            $jsonResponse['status'] = 'success';
                        } else {
                            $jsonResponse['status'] = 'fail';
                        }
                    } else {
                        $jsonResponse['status'] = 'wrong_password_reset_code';
                    }
                } else {
                    $jsonResponse['status'] = 'fail';
                }
            } else {
                $jsonResponse['status'] = 'no_password_reset_request_found_for_this_email';
            }
        } else {
            $jsonResponse['status'] = 'fail';
        }
    }
    echo json_encode($jsonResponse);
} else {
    $Functions->phpRedirect('');
}

