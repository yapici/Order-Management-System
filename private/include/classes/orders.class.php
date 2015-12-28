<?php

/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/24/2015                                                                 */
/* Last modified on 12/27/2015                                                           */
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
    private $searchColumns = ['id',
        'description',
        'uom',
        'catalog_no',
        'price',
        'account_number',
        'project_name_and_number',
        'comments',
        'status',
        'vendor_name',
        'requested_datetime',
        'status_updated_date',
        'status_updated_by_username',
        'item_needed_by_date',
        'ordered_date',
        'requested_by_username'
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
        $sql = "SELECT ";
        $sql .= "id, ";
        $sql .= "description, ";
        $sql .= "quantity, ";
        $sql .= "uom, ";
        $sql .= "vendor, ";
        $sql .= "catalog_no, ";
        $sql .= "price, ";
        $sql .= "weblink, ";
        $sql .= "cost_center, ";
        $sql .= "project, ";
        $sql .= "comments, ";
        $sql .= "requested_datetime, ";
        $sql .= "status_updated_date, ";
        $sql .= "status, ";
        $sql .= "requested_by_username, ";
        $sql .= "item_needed_by_date, ";
        $sql .= "ordered, ";
        $sql .= "ordered_date, ";
        $sql .= "ordered_by_username, ";
        if ($this->Admin->isAdmin()) {
            $sql .= "vendor_order_no, ";
            $sql .= "invoice_no, ";
        }
        $sql .= "status_updated_by_username ";
        $sql .= "FROM orders WHERE deleted = 0";
        $sql .= $this->getSearchQuery();
        $sql .= $this->getSortQuery();
        $sql .= "LIMIT :start, :item_number";

        $stmt = $this->Database->prepare($sql);

        /* Search Keywords */
        for ($i = 0; $i < count($this->searchKeywordsArray); $i++) {
            $keyword = $this->searchKeywordsArray[$i];
            for ($k = 0; $k < count($this->searchColumns); $k++) {
                $paramName = ":keyword" . $i . $k;
                if (substr($this->searchColumns[$k], -8) == "datetime" || substr($this->searchColumns[$k], -4) == "date") {
                    $dateKeyword = $this->Functions->convertStrDateToMysqlDate($keyword);
                    $stmt->bindValue($paramName . 'a', $dateKeyword . ' 00:00:00', PDO::PARAM_STR);
                    $stmt->bindValue($paramName . 'b', $dateKeyword . ' 23:59:59', PDO::PARAM_STR);
                } else {
                    $stmt->bindValue($paramName, "%$keyword%", PDO::PARAM_INT);
                }
            }
        }

        /* Pagination page number */
        $stmt->bindValue(':start', $this->paginationStartPoint, PDO::PARAM_INT);

        /* Number of items for a page */
        $stmt->bindValue(':item_number', $this->numberOfItemsPerPage, PDO::PARAM_INT);

        $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sanitizedArray = $this->Functions->sanitizeArray($row);
            $this->ordersArray[$sanitizedArray['id']] = $sanitizedArray;
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
        if (isset($_SESSION['search_keywords']) && $_SESSION['search_keywords'] != "" && $_SESSION['search_keywords'] != "Search") {
            $searchKeywordsString = $_SESSION['search_keywords'];
            $this->searchKeywordsArray = preg_split('/[\s]+/', $searchKeywordsString);
            for ($i = 0; $i < count($this->searchKeywordsArray); $i++) {
                $searchSqlString .= "AND (";
                $columns = $this->searchColumns;
                for ($k = 0; $k < count($columns); $k++) {
                    if (substr($columns[$k], -8) == "datetime" || substr($columns[$k], -4) == "date") {
                        $searchSqlString .= '(' . $columns[$k] . " BETWEEN :keyword" . $i . $k . "a AND :keyword" . $i . $k . "b) OR ";
                    } else {
                        $searchSqlString .= $columns[$k] . " LIKE :keyword" . $i . $k . " OR ";
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
        if (isset($_SESSION['sort_column_name']) && $_SESSION['sort_column_name'] != "") {
            $sortSqlString = " ORDER BY " . $_SESSION['sort_column_name'];
            if ($_SESSION['sort_up_or_down'] == 'up') {
                $sortSqlString .= " ASC ";
            } else {
                $sortSqlString .= " DESC ";
            }
        }
        return $sortSqlString;
    }

    private function setPaginationParameters() {
        if (isset($_SESSION['pagination_page_number'])) {
            $this->paginationPageNumber = $_SESSION['pagination_page_number'];
            $this->paginationStartPoint = ($this->paginationPageNumber - 1) * $this->numberOfItemsPerPage;
        }
    }

    private function setTotalNumberOfItems() {
        $sql = "SELECT * FROM orders WHERE deleted = 0" . $this->getSearchQuery() . $this->getSortQuery();

        $stmt = $this->Database->prepare($sql);
        for ($i = 0; $i < count($this->searchKeywordsArray); $i++) {
            $keyword = $this->searchKeywordsArray[$i];
            for ($k = 0; $k < count($this->searchColumns); $k++) {
                $paramName = ":keyword" . $i . $k;
                if (substr($this->searchColumns[$k], -8) == "datetime" || substr($this->searchColumns[$k], -4) == "date") {
                    $dateKeyword = $this->Functions->convertStrDateToMysqlDate($keyword);
                    $stmt->bindValue($paramName . 'a', $dateKeyword . ' 00:00:00', PDO::PARAM_STR);
                    $stmt->bindValue($paramName . 'b', $dateKeyword . ' 23:59:59', PDO::PARAM_STR);
                } else {
                    $stmt->bindValue($paramName, "%$keyword%", PDO::PARAM_INT);
                }
            }
        }
        $stmt->execute();
        $this->totalNumberOfItems = $stmt->rowCount();
    }

    public function refreshTotalNumberOfItems() {
        $this->setTotalNumberOfItems();
    }

    public function getTotalNumberOfItems() {
        return $this->totalNumberOfItems;
    }

}

/** @var Orders $Orders */
$Orders = new Orders($Database, $Functions, $Admin);
?>
