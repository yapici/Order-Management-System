<?php

/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/20/2015                                                                 */
/* Last modified on 12/20/2015                                                           */
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

class AccountNumbers {

    private $Database;
    private $Functions;

    /** @var array $accountNumbersArray */
    public $accountNumbersArray;

    /** @var array $accountNumberIdsArray */
    public $accountNumberIdsArray;

    /**
     * @param Database $database
     * @param Functions $functions
     */
    function __construct($database, $functions) {
        $this->Database = $database;
        $this->Functions = $functions;
        $this->populateArray();
    }

    private function populateArray() {
        $sql = "SELECT id, account_number FROM account_numbers";
        $stmt = $this->Database->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sanitizedArray = $this->Functions->sanitizeArray($row);
            $this->accountNumbersArray[$sanitizedArray['id']] = $sanitizedArray['account_number'];
            $this->accountNumberIdsArray[$sanitizedArray['account_number']] = $sanitizedArray['id'];
        }
    }

    public function refreshArray() {
        $this->populateArray();
    }

    /**
     * @return array $accountNumbersArray
     */
    public function getAccountNumbersArray() {
        return $this->accountNumbersArray;
    }

    /**
     * @return array $accountNumberIdsArray
     */
    public function getAccountNumberIdsArray() {
        return $this->accountNumberIdsArray;
    }

    public function populateAccountNumbersList() {
        $html = '';
        foreach ($this->accountNumbersArray as $accountNumberId => $accountNumber) {
            $html .= "<option value='$accountNumberId'>$accountNumber</option>";
        }
        echo $html;
    }

}

/** @var AccountNumbers $AccountNumbers */
$AccountNumbers = new AccountNumbers($Database, $Functions);
?>