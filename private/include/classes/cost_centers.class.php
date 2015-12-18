<?php

/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/17/2015                                                                 */
/* Last modified on 12/17/2015                                                           */
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

class CostCenters {

    private $Database;
    private $Functions;

    /** @var array $costCentersArray */
    public $costCentersArray;

    /** @var array $costCenterIdsArray */
    public $costCenterIdsArray;

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
        $sql = "SELECT id, name FROM cost_centers";
        $stmt = $this->Database->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sanitizedArray = $this->Functions->sanitizeArray($row);
            $this->costCentersArray[$sanitizedArray['id']] = $sanitizedArray['name'];
            $this->costCenterIdsArray[$sanitizedArray['name']] = $sanitizedArray['id'];
        }
    }

    public function refreshArray() {
        $this->populateArray();
    }

    /**
     * @return array $costCentersArray
     */
    public function getCostCentersArray() {
        return $this->costCentersArray;
    }

    /**
     * @return array $costCenterIdsArray
     */
    public function getCostCenterIdsArray() {
        return $this->costCenterIdsArray;
    }

    public function populateCostCentersList() {
        $html = '';
        foreach ($this->costCentersArray as $costCenterId => $costCenterName) {
            $html .= "<option value='$costCenterId'>$costCenterName</option>";
        }
        echo $html;
    }

}

/** @var CostCenters $CostCenters */
$CostCenters = new CostCenters($Database, $Functions);
?>