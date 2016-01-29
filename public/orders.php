<?php
/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 10/19/2015                                                                 */
/* Last modified on 01/28/2016                                                           */
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

require_once('../private/include/include.php');
if (!$Session->isSessionValid()) {
    $Functions->phpRedirect('');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
    <head>
        <title>Order Management System</title>
        <?php require_once ('include_references.php'); ?>
    </head>

    <body>
        <div class="gray-out-div"></div>
        <img class="progress-circle" src="images/ajax-loader.gif"/>
        <?php require_once (PRIVATE_PATH . 'require/popup-windows.php'); ?>
        <?php require_once (PRIVATE_PATH . 'require/header.php'); ?>        
        <div id="orders-main-body-wrapper" class='noselect'>
            <span id='button-holder-span'>
                <span title='Log Out' onclick='logoutAction();'><img class='absolute-buttons' id='logout-button' src='images/logout-icon.png'></img></span>
                <span title='Add New Item' onclick='showAddNewItemPopupWindow();'><img class='absolute-buttons' src='images/plus-icon.png'></img></span>
                <?php if ($Admin->isAdmin()) { ?>
                    <span>
                        <img class='absolute-buttons' id='menu-button' src='images/menu-icon.png'></img>
                        <span id='menu-items-wrapper-span'>
                            <ul id='menu-items-wrapper-ul'>
                                <li class='menu-items' title='Manage Vendors' onclick='showVendorsPopupWindow();'><img class='absolute-buttons' id='vendor-button' src='images/vendor-icon.png'></img></li>
                                <li class='menu-items' title='Manage Projects' onclick='showProjectsPopupWindow();'><img class='absolute-buttons' src='images/project-icon.png'></img></li>
                                <li class='menu-items' title='Manage Cost Centers' onclick='showCostCentersPopupWindow();'><img class='absolute-buttons' src='images/cost-center-icon.png'></img></li>
                                <li class='menu-items' title='Manage Users' onclick='showUsersPopupWindow();'><img class='absolute-buttons' src='images/users-icon.png'></img></li>
                            </ul>
                        </span>
                    </span>
                <?php } ?>
            </span>
            <div class="search-elements-wrapper">
                <input class='search-input' id="orders-search-input" placeholder="Search"
                <?php
                if (isset($_SESSION['search_keywords'])) {
                    echo "value='" . $_SESSION['search_keywords'] . "'";
                }
                ?>
                />

                <a class='search-cancel-button' id='orders-search-cancel-button' <?php
                if (!isset($_SESSION['search_keywords']) || $_SESSION['search_keywords'] == "" || $_SESSION['search_keywords'] == "Search") {
                    echo "style='display: none;'";
                }
                ?>onclick='searchAction("clear")'>Clear</a>
                <a class="button search-button" onclick='searchAction("search")'><img src="images/search_icon.png"/></a>
            </div>
            <div id="orders-error-div"></div>
            <?php
            echo '<div class="reset-sort-button-wrapper-div"><a class="reset-sort-button" ';
            if (isset($_SESSION['sort_column_name']) && $_SESSION['sort_column_name'] != "") {
                echo 'style="display: inline-block" ';
            } else {
                echo 'style="display: none" ';
            }
            echo 'onclick="sortByColumn(\'\')">Reset Sort</a></div>';
            ?>
            <table id="orders-table">
                <thead>
                    <tr>
                        <?php if ($Admin->isAdmin()) { ?>
                            <td onclick='sortByColumn($(this))'>Order No <a>&#9650;</a></td>
                            <td onclick='sortByColumn($(this))'>Description <a>&#9650;</a></td>
                            <td onclick='sortByColumn($(this))'>Vendor <a>&#9650;</a></td>
                            <td onclick='sortByColumn($(this))'>Catalog No <a>&#9650;</a></td>
                            <td onclick='sortByColumn($(this))'>Quantity <a>&#9650;</a></td>
                            <td onclick='sortByColumn($(this))'>Requested By <a>&#9650;</a></td>
                            <td onclick='sortByColumn($(this))'>Item Needed By <a>&#9650;</a></td>
                            <td onclick='sortByColumn($(this))'>Status <a>&#9650;</a></td>
                        <?php } else { ?>
                            <td onclick='sortByColumn($(this))'>Order No <a>&#9650;</a></td>
                            <td onclick='sortByColumn($(this))'>Description <a>&#9650;</a></td>
                            <td onclick='sortByColumn($(this))'>Vendor <a>&#9650;</a></td>
                            <td onclick='sortByColumn($(this))'>Catalog No <a>&#9650;</a></td>
                            <td onclick='sortByColumn($(this))'>Requested By <a>&#9650;</a></td>
                            <td onclick='sortByColumn($(this))'>Status <a>&#9650;</a></td>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php require_once (PRIVATE_PATH . 'require/orders-table-body-query.php'); ?>
                </tbody>
            </table>
            <div id='pagination-holder-div'><?php echo $pagination; ?></div>
        </div>
    </body>
</html>

