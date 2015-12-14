<?php

/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 10/23/2015                                                                 */
/* Last modified on 12/13/2015                                                           */
/* ===================================================================================== */

/* ===================================================================================== */
/* The MIT License                                                                       */
/*                                                                                       */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>.                                 */
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

class Functions {
    /* ################################### -- Encryption Functions -- ##################################### */
    /* #################################################################################################### */

    var $skey = "dvds#4fw00#wfkm!8jwd#&mhg%uywb";

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

    function convertMysqlDateToPhpDate($date) {
        if ($date == "0000-00-00") {
            $date = "N/A";
        } else {
            $date = date('d-M-Y', strtotime($date));
        }
        return $date;
    }

    function convertStrDateToMysqlDate($date) {
        $originalDate = $date;
        $date = str_replace("-", "/", $originalDate);
        if ($date == "N/A") {
            $date = "0";
        } else {
            try {
                $date = date('Y-m-d', strtotime($date));
                if ($date == "1970-01-01") {
                    $date = preg_replace("/(\d+)\D+(\d+)\D+(\d+)/", "$3-$2-$1", $originalDate);
                    $date = date('Y-m-d', strtotime($date));
                }
            } catch (Exception $e) {
                $date = "0";
            }
        }

        error_log($date . "\n", 3, "php.log");
        error_log("\n\n", 3, "php.log");
        return $date;
    }

    /* /  ************************************************************************************************* */
    /* /  ****************************** -- Date Conversion Functions -- ********************************** */

    function getDomainFromEmail($email) {
        $domain = substr(strrchr($email, "@"), 1);
        return $domain;
    }

    /** @param $database Database 
     *  @param $userId int 
     */
    function getUsername($database, $userId) {
        $username = '';

        $sql = "SELECT username FROM users ";
        $sql .= "WHERE id = ?";
        $stmt = $database->prepare($sql);
        $stmt->bindValue(1, $userId, PDO::PARAM_STR);

        $result = $stmt->execute();

        if ($result) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $username = $row['username'];
        }
        return $username;
    }

    // This function is used in 'public/ajax/update-table-with-sort.php'.
    /** @param $columnName string. Column name in the database
     */
    function storeSortInSession($columnName) {
        if ($_SESSION['sort_column_name'] == $columnName && $_SESSION['sort_up_or_down'] == 'up') {
            $_SESSION['sort_up_or_down'] = 'down';
        } else {
            $_SESSION['sort_up_or_down'] = 'up';
            $_SESSION['sort_column_name'] = $columnName;
        }
    }

    // This function is used in 'public/ajax/upload-file.php'.
    /** @param $directory string. Base directory of the file
     *  @param $filename string
     *  @return $filePath string
     */
    function renameFileIfExists($directory, $filename) {
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

    // This function is used in 'public/ajax/add-new-item-action.php'.
    /** @return $sanitizedArray array
     */
    function sanitizePostedVariables() {
        $sanitizedArray = array();
        foreach ($_POST as $key => $value) {
            $sanitizedArray[$key] = htmlspecialchars(trim(filter_input(INPUT_POST, $key)));
        }
        return $sanitizedArray;
    }

}

$Functions = new Functions();
?>
