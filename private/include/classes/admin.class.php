<?php

/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/19/2015                                                                 */
/* Last modified on 12/31/2015                                                           */
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

class Admin {

    private $Session;

    /**
     * @param Session $session
     */
    function __construct($session) {
        $this->Session = $session;
    }

    /**
     *  @return boolean If the logged in user is an administrator, 'true' is returned.
     */
    public function isAdmin() {
        if (isset($_SESSION['user_type']) && ($_SESSION['user_type'] == '1' || $_SESSION['user_type'] == '2')) {
            return true;
        } else {
            return false;
        }
    }

    public function ajaxAdminChecks() {
        if (!$this->Session->isSessionValid()) {
            $response = "no_session";
        } else if ($_SESSION['user_type'] != Constants::USER_TYPE_PURCHASING_PERSON &&
                $_SESSION['user_type'] != Constants::USER_TYPE_ADMINISTRATOR) {
            $response = "unauthorized_access";
        } else {
            $response = true;
        }
        return $response;
    }

}
