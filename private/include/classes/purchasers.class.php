<?php

/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 01/03/2016                                                                 */
/* Last modified on 02/07/2016                                                           */
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

class Purchasers {

    private $Database;
    private $Functions;

    /** @var array $purchasersArray */
    public $purchasersArray = array();

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
        $sql = "SELECT id, username, email FROM users WHERE user_type = :user_type ";
        $stmt = $this->Database->prepare($sql);
        $stmt->bindValue(':user_type', Constants::USER_TYPE_PURCHASING_PERSON, PDO::PARAM_STR);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sanitizedArray = $this->Functions->sanitizeArray($row);
            array_push($this->purchasersArray, $sanitizedArray);
        }
    }

    /**
     * @return array $purchasersArray
     */
    public function getPurchasersArray() {
        return $this->purchasersArray;
    }
    
    /**
     * @return boolean Returns true if the logged in user is a purchasing person
     */
    public function isPurchaser() {
        $userId = $_SESSION['id'];
        $purchasersArray = $this->purchasersArray;
        
        $isPurchaser = false;
        
        foreach ($purchasersArray as $purchaser) {
            if ($purchaser['id'] == $userId) {
                $isPurchaser = true;
            }
        }
        
        return $isPurchaser;
    }

}
?>