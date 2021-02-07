<?php
require('../../private/include/include.php');
// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if (filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
    // Getting the parameters passed through AJAX
    $email = strtolower(trim(filter_input(INPUT_POST, 'email')));
    $enteredPassword = trim(filter_input(INPUT_POST, 'password'));
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

