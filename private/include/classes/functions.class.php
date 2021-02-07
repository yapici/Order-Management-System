<?php
class Functions {
    /* ################################### -- Encryption Functions -- ##################################### */
    /* #################################################################################################### */

    var $skey = "dvds#4fw00#wfkm!8jwd#&mhg%uy34wb";

    public function safe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
        return $data;
    }

    public function safe_b64decode($string) {
        $data = str_replace(array('-', '_'), array('+', '/'), $string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    public function encode($value) {
        if (!$value) {
            return false;
        }
        $text = $value;
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->skey, $text, MCRYPT_MODE_ECB, $iv);
        return trim($this->safe_b64encode($crypttext));
    }

    public function decode($value) {
        if (!$value) {
            return false;
        }
        $crypttext = $this->safe_b64decode($value);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->skey, $crypttext, MCRYPT_MODE_ECB, $iv);
        return trim($decrypttext);
    }

    /* /  ************************************************************************************************* */
    /* /  ******************************** -- Encryption Functions -- ************************************* */



    /* #################################### -- Redirect Functions -- ###################################### */
    /* #################################################################################################### */

    public function phpRedirect($target) {
        header("Location: /$target");
        exit;
    }

    public function jsRedirect($target) {
        $script = '<script type="text/javascript">';
        $script .= 'window.location = "' . $target . '"';
        $script .= '</script>';

        echo $script;
    }

    /* /  ************************************************************************************************* */
    /* /  ********************************* -- Redirect Functions -- ************************************** */



    /* ################################# -- Date Conversion Functions -- ################################## */
    /* #################################################################################################### */

    public function convertMysqlDateToPhpDate($date) {
        if ($date == "0000-00-00" || $date == "0000-00-00 00:00:00") {
            $date = "N/A";
        } else {
            $date = date('d-M-Y', strtotime($date));
        }
        return $date;
    }

    /** @param string $date
     *  @return string $convertedDate
     */
    public function convertStrDateToMysqlDate($date) {
        $slashesReplacedDate = str_replace("/", "-", $date);
        try {
            $convertedDate = date('Y-m-d', strtotime($slashesReplacedDate));
            if ($convertedDate == "1970-01-01" || $convertedDate == "1969-12-31") {
                $convertedDate = date('Y-m-d', strtotime(preg_replace("/(\d+)\D+(\d+)\D+(\d+)/", "$3-$2-$1", $date)));
                if ($convertedDate == "1970-01-01" || $convertedDate == "1969-12-31") {
                    $dashesReplacedDate = str_replace("-", "/", $date);
                    $convertedDate = date('Y-m-d', strtotime($dashesReplacedDate));
                }
            }
        } catch (Exception $e) {
            $convertedDate = "0";
        }
        return $convertedDate;
    }

    /* /  ************************************************************************************************* */
    /* /  ****************************** -- Date Conversion Functions -- ********************************** */

    public function getDomainFromEmail($email) {
        $domain = substr(strrchr($email, "@"), 1);
        return $domain;
    }

    // This function is used in 'public/ajax/update-table-with-sort.php'.
    /** @param string $columnName - Column name in the database
     */
    public function storeSortInSession($columnName) {
        if (isset($_SESSION['sort_column_name']) &&
                $_SESSION['sort_column_name'] == $columnName &&
                $_SESSION['sort_up_or_down'] == 'up') {
            $_SESSION['sort_up_or_down'] = 'down';
        } else {
            $_SESSION['sort_up_or_down'] = 'up';
            $_SESSION['sort_column_name'] = $columnName;
        }
    }

    // This function is used in 'public/ajax/upload-file.php'.
    /** @param string $directory - Base directory of the file
     *  @param string $filename
     *  @return string $filePath
     */
    public function renameFileIfExists($directory, $filename) {
        $fileExtention = pathinfo($filename, PATHINFO_EXTENSION);
        $fileBasename = basename($filename, '.' . $fileExtention);

        $filePath = $directory . $filename;
        $i = 1;
        while (file_exists($filePath)) {
            $filePath = $directory . $fileBasename . ' (' . $i . ').' . $fileExtention;
            $i++;
        }
        return $filePath;
    }

    /** @param string $string 
     *  @return string Returned string with excaped quotes
     */
    public function escapeQuotes($string) {
        return htmlspecialchars($string, ENT_QUOTES);
    }

    /** @param array $array 
     *  @return array $sanitizedArray
     */
    public function sanitizeArray($array) {
        $sanitizedArray = array();
        foreach ($array as $key => $value) {
            $sanitizedArray[$key] = htmlspecialchars(trim($value));
        }
        return $sanitizedArray;
    }

    // This function is used in 'public/ajax/add-new-item-action.php'.
    /** @return array $sanitizedArray
     */
    public function sanitizePostedVariables() {
        $sanitizedArray = array();
        foreach ($_POST as $key => $value) {
            $sanitizedArray[$key] = htmlspecialchars(trim(filter_input_fix(INPUT_POST, $key)));
        }
        return $sanitizedArray;
    }

    /** @param int $orderId
     *  @param boolena $showDeleteButtons
     *  @return string $htmlResponse
     */
    public function includeAttachments($orderId, $showDeleteButtons = false, $isAdminAttachment = false) {
        if ($isAdminAttachment) {
            $attachmentsDirectoryPath = PRIVATE_PATH . 'attachments/admin/' . $orderId;
        } else {
            $attachmentsDirectoryPath = PRIVATE_PATH . 'attachments/' . $orderId;
        }
        $htmlResponse = '';
        if (is_dir($attachmentsDirectoryPath)) {
            $attachmentsFileNames = scandir($attachmentsDirectoryPath);
            for ($i = 0; $i < count($attachmentsFileNames); $i++) {
                if ($attachmentsFileNames[$i] !== '..' &&
                        $attachmentsFileNames[$i] !== '.' &&
                        $attachmentsFileNames[$i] !== 'index.php' &&
                        $attachmentsFileNames[$i] !== 'archived') {
                    $filePath = '';
                    if ($isAdminAttachment) {
                        $filePath .= 'admin/';
                    }
                    $filePath .= $orderId . '/' . $attachmentsFileNames[$i];
                    $encryptedFilePath = $this->encode($filePath);

                    $htmlResponse .= "<span class='file'><a href='download/$encryptedFilePath'>$attachmentsFileNames[$i]</a>";
                    $htmlResponse .= "&nbsp;&nbsp;";
                    $htmlResponse .= "<a class='button attachment-buttons' href='download/$encryptedFilePath'><img src='images/download-icon.png'/></a>";
                    $htmlResponse .= $this->includeDeleteButtons($encryptedFilePath, $showDeleteButtons, $isAdminAttachment);
                    $htmlResponse .= "</span>";
                }
            }
        }
        return $htmlResponse;
    }

    // This function is used in includeAttachments() function.
    /** @param string $encryptedFilePath
     *  @param boolean $showDeleteButtons
     *  @return string $htmlResponse
     */
    private function includeDeleteButtons($encryptedFilePath, $showDeleteButtons = false, $isAdminAttachment = false) {
        $htmlResponse = '';
        if ($_SESSION['user_type'] == Constants::USER_TYPE_PURCHASING_PERSON ||
                $_SESSION['user_type'] == Constants::USER_TYPE_ADMINISTRATOR ||
                $showDeleteButtons) {
            $htmlResponse = "&nbsp;&nbsp;";
            if ($isAdminAttachment) {
                $htmlResponse .= "<a class='button attachment-buttons' onclick=\"deleteAdminAttachment('$encryptedFilePath')\"><img src='images/x-icon.png'/></a></a>";
            } else {
                $htmlResponse .= "<a class='button attachment-buttons' onclick=\"showDeleteConfirmationWindow('$encryptedFilePath')\"><img src='images/x-icon.png'/></a></a>";
            }
        }
        return $htmlResponse;
    }

    /**
     *  @param string $url
     *  @return string $url
     */
    public function addHttp($url) {
        if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
            $url = "http://" . $url;
        }
        return $url;
    }

    /**
     *  @param string $title
     *  @param string $error_msg
     */
    public function logError($title, $error_msg) {
        error_log("\n$title\n", 3, "php.log");
        error_log($error_msg, 3, "php.log");
        error_log("\n$title\n", 3, "php.log");
    }

    /**
     *  @param int $string_length
     *  @return string Random string created with the provided length
     */
    function generateRandomString($string_length) {
        $alpha_numeric = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        return substr(str_shuffle($alpha_numeric), 0, $string_length);
    }

    /**
     * @param string $username
     * @return string User first name with uppercase first letter
     */
    public function getUserFirstName($username) {
        return ucfirst(current(explode(".", $username)));
    }

}

?>