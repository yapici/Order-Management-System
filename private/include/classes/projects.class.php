<?php

/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/23/2015                                                                 */
/* Last modified on 12/28/2015                                                           */
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

class Projects {

    private $Database;
    private $Functions;

    /** @var array $projectsArray */
    public $projectsArray;

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
        $sql = "SELECT id, name, number, added_by_username, active FROM projects WHERE active = '1'";
        $stmt = $this->Database->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sanitizedArray = $this->Functions->sanitizeArray($row);
            $this->projectsArray[$sanitizedArray['id']] = $sanitizedArray;
        }
    }

    public function refreshArray() {
        $this->populateArray();
    }

    /**
     * @return array $projectsArray
     */
    public function getProjectsArray() {
        return $this->projectsArray;
    }

    public function populateProjectsList() {
        $html = '';
        foreach ($this->projectsArray as $projectId => $project) {
            $projectName = $project['name'];
            $projectNumber = $project['number'];
            $html .= "<option value='$projectId'>$projectName / $projectNumber</option>";
        }
        echo $html;
    }

    public function populateProjectsTable() {
        $tableBody = '';
        foreach ($this->projectsArray as $projectId => $project) {
            $projectName = $project['name'];
            $projectNumber = $project['number'];
            $projectActive = $project['active'];

            $tableBody .= "<tr id='project-$projectId'>";
            $tableBody .= "<td>$projectId</td>";
            $tableBody .= "<td title='$projectName'><span>$projectName</span><input id='projects-popup-window-project-name' value='$projectName' type='text'/></td>";
            $tableBody .= "<td title='$projectNumber'><span>$projectNumber</span><input id='projects-popup-window-project-number' value='$projectNumber' type='text'/></td>";
            $tableBody .= "<td title='$projectActive'><span>$projectActive</span><input id='projects-popup-window-project-active' value='$projectActive' type='text'/></td>";
            $tableBody .= "</tr>";
        }
        echo $tableBody;
    }

    /**
     * @param array $projectDetailsArray
     * @return boolean PDO execute result
     */
    public function addNewProject($projectDetailsArray) {
        $projectName = $projectDetailsArray['name'];
        $projectNumber = $projectDetailsArray['number'];

        $userId = $_SESSION['id'];
        $username = $_SESSION['username'];
        $currentDate = date("Y-m-d H:i:s");

        $sql = "INSERT INTO projects (";
        $sql .= "name, number, date_added, added_by_user_id, added_by_username,";
        $sql .= " last_updated_date, last_updated_by_user_id, last_updated_by_username, active";
        $sql .= ") VALUES (:name, :number, :currentDate, :userId, :username, :currentDate, :userId, :username, '1')";

        $stmt = $this->Database->prepare($sql);
        $stmt->bindValue(':name', $projectName, PDO::PARAM_STR);
        $stmt->bindValue(':number', $projectNumber, PDO::PARAM_STR);
        $stmt->bindValue(':currentDate', $currentDate, PDO::PARAM_STR);
        $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);

        return $stmt->execute();
    }

}

/** @var Projects $Projects */
$Projects = new Projects($Database, $Functions);
?>
