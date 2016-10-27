<?php

/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/12/2015                                                                 */
/* Last modified on 04/17/2016                                                           */
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

$currentPage = $Orders->paginationPageNumber;
$page = $currentPage - 1;
$next = $currentPage + 1;
$lastpage = ceil($Orders->totalNumberOfItems / $Orders->numberOfItemsPerPage);
$lpm1 = $lastpage - 1;
$lpm2 = $lastpage - 2;

// Number of adjacent pages should be shown on each side
$adjacents = 1;

$pagination = "";
if ($lastpage > 1) {
    //previous button
    if ($currentPage > 1) {
        $pagination .= "<a class=\"button page-button\" onclick=\"goToPage($page)\"><</a>";
    } else {
        $pagination .= "<a class=\"button gray-out-button\"><</a>";
    }

    //pages	
    if ($lastpage < 9 + $adjacents) { //not enough pages to bother breaking it up
        for ($counter = 1; $counter <= $lastpage; $counter++) {
            if ($counter == $currentPage) {
                $pagination .= "<a class=\"button gray-out-button\">$counter</a>";
            } else {
                $pagination .= "<a class=\"button page-button\" onclick=\"goToPage($counter)\">$counter</a>";
            }
        }
    } else { //enough pages to hide some
        //close to beginning; only hide later pages
        if ($currentPage < 5 + $adjacents) {
            if ($currentPage == 1) {
                $pagination .= "<a class=\"button gray-out-button\" onclick=\"goToPage(1)\">1</a>";
            } else {
                $pagination .= "<a class=\"button page-button\" onclick=\"goToPage(1)\">1</a>";
            }
            for ($counter = 2; $counter < 6 + $adjacents; $counter++) {
                if ($counter == $currentPage) {
                    $pagination .= "<a class=\"button gray-out-button\">$counter</a>";
                } else {
                    $pagination .= "<a class=\"button page-button\" onclick=\"goToPage($counter)\">$counter</a>";
                }
            }
            $pagination .= "&#8230;&nbsp;";
            $pagination .= "<a class=\"button page-button\" onclick=\"goToPage($lpm2)\">$lpm2</a>";
            $pagination .= "<a class=\"button page-button\" onclick=\"goToPage($lpm1)\">$lpm1</a>";
            $pagination .= "<a class=\"button page-button\" onclick=\"goToPage($lastpage)\">$lastpage</a>";
        } elseif ($currentPage > $adjacents &&
                $currentPage >= ($adjacents + 5) &&
                $currentPage < ($lastpage - (3 + $adjacents))) { //in middle; hide some front and some back
            $pagination .= "<a class=\"button page-button\" onclick=\"goToPage(1)\">1</a>";
            $pagination .= "<a class=\"button page-button\" onclick=\"goToPage(2)\">2</a>";
            $pagination .= "<a class=\"button page-button\" onclick=\"goToPage(3)\">3</a>";
            $pagination .= "&#8230;&nbsp;";
            for ($counter = $currentPage - $adjacents; $counter <= $currentPage + $adjacents; $counter++) {
                if ($counter == $currentPage) {
                    $pagination .= "<a class=\"button gray-out-button\">$counter</a>";
                } else {
                    $pagination .= "<a class=\"button page-button\" onclick=\"goToPage($counter)\">$counter</a>";
                }
            }
            $pagination .= "&#8230;&nbsp;";
            $pagination .= "<a class=\"button page-button\" onclick=\"goToPage($lpm2)\">$lpm2</a>";
            $pagination .= "<a class=\"button page-button\" onclick=\"goToPage($lpm1)\">$lpm1</a>";
            $pagination .= "<a class=\"button page-button\" onclick=\"goToPage($lastpage)\">$lastpage</a>";
        } else { //close to end; only hide early pages
            $pagination .= "<a class=\"button page-button\" onclick=\"goToPage(1)\">1</a>";
            $pagination .= "<a class=\"button page-button\" onclick=\"goToPage(2)\">2</a>";
            $pagination .= "<a class=\"button page-button\" onclick=\"goToPage(3)\">3</a>";
            $pagination .= "&#8230;&nbsp;";
            for ($counter = $lastpage - (4 + $adjacents); $counter <= $lastpage-1; $counter++) {
                if ($counter == $currentPage) {
                    $pagination .= "<a class=\"button gray-out-button\">$counter</a>";
                } else {
                    $pagination .= "<a class=\"button page-button\" onclick=\"goToPage($counter)\">$counter</a>";
                }
            }
            if ($currentPage == $lastpage) {
                $pagination .= "<a class=\"button gray-out-button\" onclick=\"goToPage($lastpage)\">$lastpage</a>";
            } else {
                $pagination .= "<a class=\"button page-button\" onclick=\"goToPage($lastpage)\">$lastpage</a>";
            }
        }
    }

//next button
    if ($currentPage < $counter - 1) {
        $pagination .= "<a class=\"button page-button next_and_previous_buttons\" onclick=\"goToPage($next)\">></a>";
    } else {
        $pagination .= "<a class=\"button gray-out-button next_and_previous_buttons\">></a>";
    }
}
?>

