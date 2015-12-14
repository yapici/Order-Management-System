<?php

/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/12/2015                                                                 */
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

include ('../../private/include/include.php');
// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if (filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
    $filecode = str_replace(' ', '', filter_input(INPUT_GET, 'file'));
    $filepath = PRIVATE_PATH . 'attachments/' . $Functions->decode($filecode);
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
        // Html response for ajax call
        $orderId = substr(dirname($filepath), strrpos(dirname($filepath), '/') + 1);
        require(PRIVATE_PATH . 'require/populate-attachments-echo-script.php');
        echo $htmlResponse;
    } else {
        // Html response for ajax call
        echo "error";
    }
} else {
    $Functions->phpRedirect('');
}
?>
