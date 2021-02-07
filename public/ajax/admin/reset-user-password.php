<?php
require('../../../private/include/include.php');
// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if (filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
    if (!$Session->isSessionValid()) {
        $jsonResponse['status'] = "no_session";
    } else {
        // Getting the parameters passed through AJAX
        $sanitizedPostArray = $Functions->sanitizePostedVariables();
        $userId = $sanitizedPostArray['user_id'];

        $hashedPassword = password_hash("password", PASSWORD_DEFAULT);

        // Updating the information in the database
        $sql = "UPDATE users SET ";
        $sql .= "password = ?, password_reset = 1 WHERE id = ?";

        $stmt = $Database->prepare($sql);

        $stmt->bindValue(1, $hashedPassword, PDO::PARAM_STR);
        $stmt->bindValue(2, $userId, PDO::PARAM_STR);
        $result = $stmt->execute();

        if ($result) {
            $jsonResponse['status'] = "success";
        } else {
            $jsonResponse['status'] = "fail";
        }
    }
    echo json_encode($jsonResponse);
} else {
    $Functions->phpRedirect('');
}
?>



