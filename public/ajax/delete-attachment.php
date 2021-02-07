<?php
include ('../../private/include/include.php');
// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if (filter_input_fix(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
    if (!$Session->isSessionValid()) {
        $jsonResponse['status'] = "no_session";
    } else {
        $filecode = str_replace(' ', '', filter_input_fix(INPUT_GET, 'file'));
        $filepath = PRIVATE_PATH . 'attachments/' . $Functions->decode($filecode);
        $orderId = substr(dirname($filepath), strrpos(dirname($filepath), '/') + 1);

        /* This if statement is used to prevent hacking deleteAttachment function to delete
         * an attachment other than the ones uploaded in 'add-new-item-popup-window' (e.g. an 
         * attachment in item-details-popup-window).
         */
        if (isset($_SESSION['temp-file-upload-directory']) &&
                $orderId != $_SESSION['temp-file-upload-directory'] &&
                $_SESSION['user_type'] != Constants::USER_TYPE_PURCHASING_PERSON &&
                $_SESSION['user_type'] != Constants::USER_TYPE_ADMINISTRATOR) {
            $jsonResponse['status'] = "get_out_of_here";
        } else {
            $archivePath = dirname($filepath) . '/archived';
            $filename = basename($filepath);

            if (!is_dir($archivePath)) {
                mkdir($archivePath, 0755, true);
                copy(PRIVATE_PATH . 'attachments/index.php', $archivePath . '/index.php');
            }

            $filenameWithoutExtension = pathinfo($filename, PATHINFO_FILENAME);
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            $fullFilename = $filenameWithoutExtension . '.' . $extension;

            $i = 1;
            while (file_exists($archivePath . '/' . $fullFilename)) {
                $fullFilename = $filenameWithoutExtension . '_' . $i . '.' . $extension;
                $i++;
            }

            if (rename($filepath, $archivePath . '/' . $fullFilename)) {
                // Response for ajax call
                if (substr($Functions->decode($filecode), 0, 5) == 'admin') {
                    $jsonResponse['html_response'] = $Functions->includeAttachments($orderId, true, true);
                } else {
                    $jsonResponse['html_response'] = $Functions->includeAttachments($orderId, true);
                }
                $jsonResponse['status'] = "success";
            } else {
                $jsonResponse['status'] = "error";
            }
        }
    }
    echo json_encode($jsonResponse);
} else {
    $Functions->phpRedirect('');
}
?>
