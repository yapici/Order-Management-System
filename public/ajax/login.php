<?php
require('../../private/include/include.php');
// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if (filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
    // Getting the parameters passed through AJAX
    $email = trim(filter_input(INPUT_POST, 'email'));
    $enteredPassword = trim(filter_input(INPUT_POST, 'password'));
    $currentDate = date("Y-m-d H:i:s");

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $domain = $Functions->getDomainFromEmail($email);

        if ($domain == Constants::DOMAIN_EMAIL_EXT) {
            // Checking if the email already is in use
            $sql = "SELECT id, username, password, account_status, user_type, password_reset FROM users ";
            $sql .= "WHERE email = ?";
            $stmt = $Database->prepare($sql);
            $stmt->bindValue(1, $email, PDO::PARAM_STR);

            $result = $stmt->execute();

            if ($result) {
                if ($stmt->rowCount() == 0) {
                    echo "invalid_info";
                } else {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $hash = $row['password'];
                    if (password_verify($enteredPassword, $hash)) {
                        if ($row['account_status'] == '1') {
                            if ($row['password_reset'] == '0') {
                                $Session->afterSuccessfulLogin();
                                $_SESSION['id'] = $row['id'];
                                $_SESSION['username'] = $row['username'];
                                $_SESSION['user_type'] = $row['user_type'];
                                $_SESSION['email'] = $email;

                                $sql = "UPDATE users SET ";
                                $sql .= "last_login_date = ? WHERE id = ?";
                                $stmt = $Database->prepare($sql);
                                $stmt->bindValue(1, $currentDate, PDO::PARAM_STR);
                                $stmt->bindValue(2, $row['id'], PDO::PARAM_STR);
                                $result = $stmt->execute();

                                echo "success";
                            } else {
                                $_SESSION['id'] = $row['id'];
                                echo "reset_password";
                            }
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
