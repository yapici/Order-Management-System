<?php

/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/24/2015                                                                 */
/* Last modified on 01/11/2016                                                           */
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

class Orders {

    /** @var Database $Database */
    private $Database;

    /** @var Functions $Functions */
    private $Functions;

    /** @var Admin $Admin */
    private $Admin;

    /** @var array $ordersArray */
    public $ordersArray;

    /** @var array $searchColumns */
    private $searchColumns = [
        'id',
        'description',
        'uom',
        'catalog_no',
        'price',
        'comments',
        'project',
        'vendor',
        'cost_center',
        'status',
        'requested_datetime',
        'status_updated_date',
        'status_updated_by_username',
        'item_needed_by_date',
        'ordered_date',
        'requested_by_username'
    ];

    /** @var string $o */
    private $o = 'o.';

    /** @var array $searchTables */
    private $searchTables = [
        'vendor' => array(
            'table_name' => 'vendors',
            'table_abbr' => 'v',
            'columns' => array('name', 'website', 'account_number')
        ),
        'project' => array(
            'table_name' => 'projects',
            'table_abbr' => 'p',
            'columns' => array('name', 'number')
        ),
        'cost_center' => array(
            'table_name' => 'cost_centers',
            'table_abbr' => 'c',
            'columns' => array('name')
        )
    ];

    /** @var int $paginationPageNumber */
    public $paginationPageNumber = 1;

    /** @var int $paginationStartPoint */
    public $paginationStartPoint = 0;

    /** @var int $numberOfItemsPerPage */
    public $numberOfItemsPerPage = 25;

    /** @var int $totalNumberOfItems */
    public $totalNumberOfItems;

    /** @var array $searchKeywordsArray */
    private $searchKeywordsArray;

    /**
     * @param Database $database
     * @param Functions $functions
     */
    function __construct($database, $functions, $admin) {
        $this->Database = $database;
        $this->Functions = $functions;
        $this->Admin = $admin;
        
        $this->setTotalNumberOfItems();
        if ($this->Admin->isAdmin()) {
            array_push($this->searchColumns, 'vendor_order_no', 'invoice_no');
        }
    }

    private function populateArray() {
        $o = $this->o;
        $sql = "SELECT ";
        $sql .= $o . "id, ";
        $sql .= $o . "description, ";
        $sql .= $o . "quantity, ";
        $sql .= $o . "uom, ";
        $sql .= $o . "vendor, ";
        $sql .= $o . "catalog_no, ";
        $sql .= $o . "price, ";
        $sql .= $o . "weblink, ";
        $sql .= $o . "cost_center, ";
        $sql .= $o . "project, ";
        $sql .= $o . "comments, ";
        $sql .= $o . "requested_datetime, ";
        $sql .= $o . "status_updated_date, ";
        $sql .= $o . "status, ";
        $sql .= $o . "requested_by_username, ";
        $sql .= $o . "item_needed_by_date, ";
        $sql .= $o . "ordered, ";
        $sql .= $o . "ordered_date, ";
        $sql .= $o . "ordered_by_username, ";
        if ($this->Admin->isAdmin()) {
            $sql .= $o . "vendor_order_no, ";
            $sql .= $o . "invoice_no, ";
        }
        $sql .= $o . "status_updated_by_username ";
        $sql .= "FROM orders o ";
        $limit_query = "LIMIT :start, :item_number";
        $stmt = $this->prepareStmt($sql, $limit_query);

        /* Pagination page number */
        $stmt->bindValue(':start', $this->paginationStartPoint, PDO::PARAM_INT);

        /* Number of items for a page */
        $stmt->bindValue(':item_number', $this->numberOfItemsPerPage, PDO::PARAM_INT);

        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->ordersArray[$row['id']] = $row;
        }

        $this->refreshTotalNumberOfItems();
    }

    public function refreshArray() {
        $this->populateArray();
    }

    /**
     * @return array $ordersArray
     */
    public function getOrdersArray() {
        $this->setPaginationParameters();
        $this->refreshArray();
        return $this->ordersArray;
    }

    /**
     * @return string $searchSqlString
     */
    private function getSearchQuery() {
        $searchSqlString = " ";
        $o = $this->o;
        if (isset($_SESSION['search_keywords']) && $_SESSION['search_keywords'] != "" && $_SESSION['search_keywords'] != "Search") {
            $searchKeywordsString = $_SESSION['search_keywords'];
            $this->searchKeywordsArray = str_getcsv($searchKeywordsString, ' ');
            $columns = $this->searchColumns;
            $searchTables = $this->searchTables;
            for ($i = 0; $i < count($this->searchKeywordsArray); $i++) {
                $searchSqlString .= "AND (";
                for ($k = 0; $k < count($columns); $k++) {
                    $currentColumn = $columns[$k];
                    if (substr($currentColumn, -8) == "datetime" || substr($currentColumn, -4) == "date") {
                        $searchSqlString .= '(' . $o . $currentColumn . " BETWEEN :keyword" . $i . $k . "a AND :keyword" . $i . $k . "b) OR ";
                    } else if (array_key_exists($currentColumn, $searchTables)) {
                        for ($l = 0; $l < count($searchTables[$currentColumn]['columns']); $l++) {
                            $searchSqlString .= "(" . $searchTables[$currentColumn]['table_abbr'] . "." . $searchTables[$currentColumn]['columns'][$l] . " LIKE :keyword" . $i . $k . $l . ") OR ";
                        }
                    } else {
                        $searchSqlString .= "(" . $o . $currentColumn . " LIKE :keyword" . $i . $k . ") OR ";
                    }
                }
                $searchSqlString = substr_replace($searchSqlString, "", -3); // to remove the 'OR' at the end.
                $searchSqlString .= ") ";
            }
        } else {
            $this->searchKeywordsArray = array();
        }
        return $searchSqlString;
    }

    /**
     * @return string $sortSqlString
     */
    private function getSortQuery() {
        $sortSqlString = " ORDER BY requested_datetime DESC ";
        if (isset($_SESSION['sort_column_name']) &&
                $_SESSION['sort_column_name'] != "") {
            if ($_SESSION['sort_column_name'] == "account_number") {
                $sortSqlString = " ORDER BY v.account_number";
            } else if ($_SESSION['sort_column_name'] == "vendor") {
                $sortSqlString = " ORDER BY v.name";
            } else {
                $sortSqlString = " ORDER BY " . $_SESSION['sort_column_name'];
            }
            
            if ($_SESSION['sort_up_or_down'] == 'up') {
                $sortSqlString .= " ASC ";
            } else {
                $sortSqlString .= " DESC ";
            }
        }
        return $sortSqlString;
    }

    private function setPaginationParameters() {
        if (isset(
                        $_SESSION['pagination_page_number'])) {
            $this->paginationPageNumber = $_SESSION['pagination_page_number'];
            $this->paginationStartPoint = ($this->paginationPageNumber - 1) * $this->numberOfItemsPerPage

            ;
        }
    }

    private function setTotalNumberOfItems() {
        $sql = "SELECT " . $this->o . "id FROM orders o ";
        $stmt = $this->prepareStmt($sql);
        $stmt->execute();
        $this->totalNumberOfItems = $stmt->rowCount();
    }

    /**
     * @param string $sql
     * @return queryString $stmt - PDO statement
     */
    private function prepareStmt($sql, $limit = '') {
        foreach ($this->searchTables as $columnName => $array) {
            $sql .= "LEFT JOIN " . $array['table_name'];
            $sql .= " " . $array['table_abbr'];
            $sql .= " ON " . $this->o . $columnName . " = " . $array['table_abbr'] . ".id ";
        }
        $sql .= "WHERE " . $this->o . "deleted = 0";
        $sql .= $this->getSearchQuery();
        $sql .= $this->getSortQuery();
        $sql .= $limit;

        $stmt = $this->Database->prepare($sql);
        for ($i = 0; $i < count($this->searchKeywordsArray); $i++) {
            $keyword = $this->searchKeywordsArray[$i];
            $searchTables = $this->searchTables;
            for ($k = 0; $k < count($this->searchColumns); $k++) {
                $paramName = ":keyword" . $i . $k;
                $currentColumn = $this->searchColumns[$k];
                if (substr($currentColumn, -8) == "datetime" || substr($currentColumn, -4) == "date") {
                    $dateKeyword = $this->Functions->convertStrDateToMysqlDate($keyword);
                    $stmt->bindValue($paramName . 'a', $dateKeyword . ' 00:00:00', PDO::PARAM_STR);
                    $stmt->bindValue($paramName . 'b', $dateKeyword . ' 23:59:59', PDO::PARAM_STR);
                } else if (array_key_exists($currentColumn, $searchTables)) {
                    for ($l = 0; $l < count($searchTables[$currentColumn]['columns']); $l++) {
                        $stmt->bindValue($paramName . $l, "%$keyword%", PDO::PARAM_STR);
                    }
                } else {
                    $stmt->bindValue($paramName, "%$keyword%", PDO::PARAM_INT);
                }
            }
        }
        return $stmt;
    }

    public function refreshTotalNumberOfItems() {
        $this->setTotalNumberOfItems();
    }

    public function getTotalNumberOfItems() {
        return $this->totalNumberOfItems;
    }

}
?>
