<?php

/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/17/2015                                                                 */
/* Last modified on 12/31/2015                                                           */
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
        $sql = "SELECT id, name, active FROM cost_centers";
        $stmt = $this->Database->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sanitizedArray = $this->Functions->sanitizeArray($row);
            $this->costCentersArray[$sanitizedArray['id']] = $sanitizedArray;
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
        foreach ($this->costCentersArray as $costCenterId => $costCenter) {
            if ($costCenter['active'] == '1') {
                $costCenterName = $costCenter['name'];
                $html .= "<option value='$costCenterId'>$costCenterName</option>";
            }
        }
        echo $html;
    }

    public function populateCostCentersTable() {
        $tableBody = '';
        foreach ($this->costCentersArray as $id => $costCenter) {
            $costCenterName = $costCenter['name'];
            $costCenterActive = $costCenter['active'];

            $tableBody .= "<tr id='cost-center-$id'>";
            $tableBody .= "<td>$id</td>";
            $tableBody .= "<td title='$costCenterName'><span>$costCenterName</span><input id='projects-popup-window-project-name' value='$costCenterName' type='text'/></td>";
            $tableBody .= "<td title='$costCenterActive'><span>$costCenterActive</span><input id='projects-popup-window-project-active' value='$costCenterActive' type='text'/></td>";
            $tableBody .= "</tr>";
        }
        echo $tableBody;
    }

    /**
     * @param array $costCenterDetailsArray
     * @return boolean PDO execute result
     */
    public function addNewCostCenter($costCenterDetailsArray) {
        $projectName = $costCenterDetailsArray['name'];

        $userId = $_SESSION['id'];
        $username = $_SESSION['username'];
        $currentDate = date("Y-m-d H:i:s");

        $sql = "INSERT INTO cost_centers (";
        $sql .= "name, date_added, added_by_user_id, added_by_username,";
        $sql .= " last_updated_date, last_updated_by_user_id, last_updated_by_username";
        $sql .= ") VALUES (:name, :currentDate, :userId, :username, :currentDate, :userId, :username)";

        $stmt = $this->Database->prepare($sql);
        $stmt->bindValue(':name', $projectName, PDO::PARAM_STR);
        $stmt->bindValue(':currentDate', $currentDate, PDO::PARAM_STR);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * @param string $costCenterId
     * @param string $fieldName
     * @param string $value
     * @return boolean PDO execute result
     */
    public function updateCostCenter($costCenterId, $fieldName, $value) {
        $userId = $_SESSION['id'];
        $username = $_SESSION['username'];
        $currentDate = date("Y-m-d H:i:s");

        // Inserting the information to the database
        $sql = "UPDATE cost_centers SET ";
        $sql .= "$fieldName = :value, ";
        $sql .= "last_updated_by_user_id = :last_updated_by_user_id, ";
        $sql .= "last_updated_by_username = :last_updated_by_username, ";
        $sql .= "last_updated_date = :last_updated_date ";
        $sql .= "WHERE id = :cost_center_id";

        $stmt = $this->Database->prepare($sql);

        $stmt->bindValue(':value', $value, PDO::PARAM_STR);
        $stmt->bindValue(':last_updated_by_user_id', $userId, PDO::PARAM_STR);
        $stmt->bindValue(':last_updated_by_username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':last_updated_date', $currentDate, PDO::PARAM_STR);
        $stmt->bindValue(':cost_center_id', $costCenterId, PDO::PARAM_STR);

        return $stmt->execute();
    }

}
?>