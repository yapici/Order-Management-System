<?php
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


