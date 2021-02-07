<?php
require('../../private/include/include.php');
// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if (filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {

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

