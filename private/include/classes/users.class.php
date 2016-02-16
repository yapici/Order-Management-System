<?php

/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/29/2015                                                                 */
/* Last modified on 02/15/2016                                                           */
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

class Users {

    private $Database;
    private $Functions;

    /** @var array $usersArray */
    public $usersArray;

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
        $sql = "SELECT id, email, phone, account_status, user_type FROM users ORDER BY id DESC";
        $stmt = $this->Database->prepare($sql);
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sanitizedArray = $this->Functions->sanitizeArray($row);
            $this->usersArray[$sanitizedArray['id']] = $sanitizedArray;
        }
    }

    public function refreshArray() {
        $this->populateArray();
    }

    /**
     * @return array $usersArray
     */
    public function getUsersArray() {
        return $this->usersArray;
    }

    public function populateUsersList() {
        $html = '';
        foreach ($this->usersArray as $userId => $user) {
            if ($user['active'] == '1') {
                $userName = $user['name'];
                $userNumber = $user['number'];
                $html .= "<option value='$userId'>$userName / $userNumber</option>";
            }
        }
        echo $html;
    }

    public function populateUsersTable() {
        $tableBody = '';
        foreach ($this->usersArray as $userId => $user) {
            $userEmail = $user['email'];
            $userPhone = $user['phone'];
            $accountStatus = $user['account_status'];
            $userType = $user['user_type'];

            $tableBody .= "<tr id='user-$userId'>";
            $tableBody .= "<td title='$userEmail'><a href='mailto:$userEmail'>$userEmail</a></td>";
            $tableBody .= "<td title='$userPhone'><span>$userPhone</span><input id='users-popup-window-user-phone' value='$userPhone' type='text'/></td>";
            
            $tableBody .= "<td title='Account Status'>";
            if ($accountStatus == '0') {
                $tableBody .= "<span>Inactive</span>";
                $tableBody .= "<select id='users-popup-window-user-account_status'>";
                $tableBody .= "<option value='0' selected>Inactive</option>";
                $tableBody .= "<option value='1'>Active</option>";
                $tableBody .= "</select>";
            } else {
                $tableBody .= "<span>Active</span>";
                $tableBody .= "<select id='users-popup-window-user-account_status'>";
                $tableBody .= "<option value='0'>Inactive</option>";
                $tableBody .= "<option value='1' selected>Active</option>";
                $tableBody .= "</select>";
            }
            $tableBody .= "</td>";
            
            $tableBody .= "<td title='User Type'>";
            if ($userType == '0') {
                $tableBody .= "<span>End User</span>";
                $tableBody .= "<select id='users-popup-window-user-user_type'>";
                $tableBody .= "<option value='0' selected>End User</option>";
                $tableBody .= "<option value='2'>Admin</option>";
                $tableBody .= "</select>";
            } else {
                $tableBody .= "<span>Admin</span>";
                $tableBody .= "<select id='users-popup-window-user-user_type'>";
                $tableBody .= "<option value='0'>End User</option>";
                $tableBody .= "<option value='2' selected>Admin</option>";
                $tableBody .= "</select>";
            }
            $tableBody .= "<span title='Reset Password' class='user-reset-password-button' onclick='showResetPasswordConfirmationPopup(this);'>";
            $tableBody .= "<img src='images/key-icon.png'/>";
            $tableBody .= "</span>";
            $tableBody .= "</td>";
            
            $tableBody .= "</tr>";
        }
        echo $tableBody;
    }

    /**
     * @param array $userDetailsArray
     * @return boolean PDO execute result
     */
    public function updateUser($userDetailsArray) {
        $id = $userDetailsArray['user_id'];
        $fieldName = $userDetailsArray['field_name'];
        $value = $userDetailsArray['value'];
        
        $userId = $_SESSION['id'];
        $username = $_SESSION['username'];
        $currentDate = date("Y-m-d H:i:s");

        // Inserting the information to the database
        $sql = "UPDATE users SET ";
        $sql .= "$fieldName = :value, ";
        $sql .= "last_updated_by_user_id = :last_updated_by_user_id, ";
        $sql .= "last_updated_by_username = :last_updated_by_username, ";
        $sql .= "last_updated_date = :last_updated_date ";
        $sql .= "WHERE id = :user_id";

        $stmt = $this->Database->prepare($sql);

        $stmt->bindValue(':value', $value, PDO::PARAM_STR);
        $stmt->bindValue(':last_updated_by_user_id', $userId, PDO::PARAM_STR);
        $stmt->bindValue(':last_updated_by_username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':last_updated_date', $currentDate, PDO::PARAM_STR);
        $stmt->bindValue(':user_id', $id, PDO::PARAM_STR);

        return $stmt->execute();
    }

}
?>


