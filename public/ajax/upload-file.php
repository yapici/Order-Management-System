<?php

/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/13/2015                                                                 */
/* Last modified on 12/16/2015                                                           */
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
if (filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
    if (!$Session->isSessionValid()) {
        $jsonResponse['status'] = "no_session";
    } else {
        $fileUploadDirectory = '';
        if (filter_input(INPUT_POST, 'file_upload_order_id') != null &&
                ($_SESSION['user_type'] == Constants::USER_TYPE_PURCHASING_PERSON ||
                $_SESSION['user_type'] == Constants::USER_TYPE_ADMINISTRATOR)) {
            $fileUploadDirectory = filter_input(INPUT_POST, 'file_upload_order_id');
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