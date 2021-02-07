<?php
require('../../private/include/include.php');
// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if (filter_input_fix(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
    if (!$Session->isSessionValid()) {
        $jsonResponse['status'] = "no_session";
    } else {
        $fileUploadDirectory = '';
        if (filter_input_fix(INPUT_POST, 'file_upload_order_id') != null &&
                ($_SESSION['user_type'] == Constants::USER_TYPE_PURCHASING_PERSON ||
                $_SESSION['user_type'] == Constants::USER_TYPE_ADMINISTRATOR)) {
            $fileUploadDirectory = filter_input_fix(INPUT_POST, 'file_upload_order_id');
        } else if (isset($_SESSION['temp-file-upload-directory'])){
            $fileUploadDirectory = $_SESSION['temp-file-upload-directory'];
        } else {
            $fileUploadDirectory = $_SESSION['username'] . '-' . time();
            $_SESSION['temp-file-upload-directory'] = $fileUploadDirectory;
        }
        $orderId = $fileUploadDirectory;

        $allowedFileType = true;
        $directoryPath = PRIVATE_PATH . 'attachments/' . $fileUploadDirectory . '/';
        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0755, true);
            copy(PRIVATE_PATH . 'attachments/index.php', $directoryPath . '/index.php');
        }

        if (!empty($_FILES["file-to-upload"])) {
            $file = $_FILES["file-to-upload"];
            if ($file['size'] > 10485760) {
                $jsonResponse['status'] = "max_file_size_exceeded";
            } else {
                $blacklist = array(".php", ".phtml", ".php3", ".php4", ".js", ".shtml", ".pl", ".py");
                $mime = $file['type'];
                foreach ($blacklist as $filetype) {
                    if (preg_match("/$filetype\$/i", $file['name'])) {
                        $allowedFileType = false;
                    }
                }

                if ($allowedFileType) {
                    $fileExtention = pathinfo($file["name"], PATHINFO_EXTENSION);
                    $fileBasename = basename($file["name"], "." . $fileExtention);
                    // ensure a safe filename
                    $filename = preg_replace("([^\w\s\d\-_~,;:\[\]\(\).])", '', substr($fileBasename, 0, 40));
                    $filename = preg_replace("([\.]{2,})", '', $filename) . '.' . $fileExtention;
                    $filename = str_replace("-", "_", $filename);

                    if ($filename == 'archived.') {
                        $filename = 'archived_';
                    }

                    $filePath = $Functions->renameFileIfExists($directoryPath, $filename);

                    // move file from temporary directory to the permanent directory
                    $success = move_uploaded_file($file["tmp_name"], $filePath);
                    if (!$success) {
                        $jsonResponse['status'] = "error";
                    } else {
                        $jsonResponse['html_response'] = $Functions->includeAttachments($orderId, true);
                        $jsonResponse['status'] = 'success';
                    }
                } else {
                    $jsonResponse['status'] = "disallowed_file_type";
                }

                if ($file["error"] !== UPLOAD_ERR_OK) {
                    $jsonResponse['status'] = $file["error"];
                }
            }
        } else {
            $jsonResponse['status'] = "no_file_was_chosen";
        }
    }
    echo json_encode($jsonResponse);
} else {
    $Functions->phpRedirect('');
}
?>