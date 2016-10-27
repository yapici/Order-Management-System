<?php

/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/23/2015                                                                 */
/* Last modified on 04/17/2016                                                           */
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

require_once (PRIVATE_PATH . 'require/popup-windows/item-details-popup-window.php');
require_once (PRIVATE_PATH . 'require/popup-windows/delete-file-confirmation-popup-window.php');
require_once (PRIVATE_PATH . 'require/popup-windows/login-popup-window.php');

echo '<div class="popup-window" id="add-new-item-popup-window">';
require_once (PRIVATE_PATH . 'require/popup-windows/add-new-item-popup-window.php');
echo '</div>';

if ($Admin->isAdmin()) {
    require_once (PRIVATE_PATH . 'require/popup-windows/vendors-popup-window.php');
    require_once (PRIVATE_PATH . 'require/popup-windows/projects-popup-window.php');
    require_once (PRIVATE_PATH . 'require/popup-windows/cost-centers-popup-window.php');
    require_once (PRIVATE_PATH . 'require/popup-windows/users-popup-window.php');
    require_once (PRIVATE_PATH . 'require/popup-windows/reset-password-confirmation-popup-window.php');
    require_once (PRIVATE_PATH . 'require/popup-windows/delete-vendor-confirmation-popup-window.php');
    echo "<style>";
    require(PRIVATE_PATH . 'require/css/popup-windows.css');
    echo "</style>";
    echo "<script type='text/javascript'>";
    require(PRIVATE_PATH . 'require/js/popup-windows.js');
    echo "</script>";
}
?>
