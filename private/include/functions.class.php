<?php
/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 10/23/2015                                                                 */
/* Last modified on 12/12/2015                                                           */
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
        if ($date == "N/A") {
            $date = "0";
        } else {
            try {
                $date = date('Y-m-d', strtotime($date));
            } catch (Exception $e) {
                $date = "0";
            }
        }
        return $date;
    }

    /* /  ************************************************************************************************* */
    /* /  ****************************** -- Date Conversion Functions -- ********************************** */

    function getDomainFromEmail($email) {
        $domain = substr(strrchr($email, "@"), 1);
        return $domain;
    }

}

$Functions = new Functions();
?>
