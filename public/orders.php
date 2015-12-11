<?php
/* ================================================================ */
/* Created by Engin Yapici on 11/04/2014                            */
/* Last modified by Engin Yapici on 10/26/2015                      */
/* Copyright Engin Yapici, 2015.                                    */
/* enginyapici@gmail.com                                            */
/* ================================================================ */
require_once('../private/include/include.php');
$target = 'index.php';
if (!is_session_valid()) {
    header("Location: /$target");
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
        <?php require_once ('../private/require/item-details-popup-window.php'); ?>
        <?php require_once ('../private/require/add-new-item-popup-window.php'); ?>
        <?php require_once ('../private/require/header.php'); ?>        
        <div id="orders-main-body-wrapper" class='noselect'>
            <span id='logout-button' title='Log Out' onclick=' logoutAction();'><img src='images/logout-button.png'></img></span>
            <span id='add-new-item-button' title='Add New Item' onclick='showAddNewItemPopupWindow();'><img src='images/plus-icon.png'></img></span>
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
            <table id="orders-table">
                <thead>
                    <tr>
                        <td>Order No</td>
                        <td>Description</td>
                        <td>Vendor</td>
                        <td>Catalog No</td>
                        <td>Price</td>
                        <td>Status</td>
                        <td>Attachments</td>
                    </tr>
                </thead>
                <tbody>
                    <?php require_once ('../private/require/orders-table-body-query.php'); ?>
                </tbody>
            </table>
        </div>
        </div>
    </body>
</html>

