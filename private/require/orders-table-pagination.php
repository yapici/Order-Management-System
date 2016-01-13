<?php
/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/12/2015                                                                 */
/* Last modified on 12/24/2015                                                           */
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

$page = $Orders->paginationPageNumber - 1;
$next = $Orders->paginationPageNumber + 1;
$lastpage = ceil($Orders->totalNumberOfItems / $Orders->numberOfItemsPerPage);
$lpm1 = $lastpage - 1;

// Number of adjacent pages should be shown on each side
$adjacents = 3;

$pagination = "";
if ($lastpage > 1) {
    //previous button
    if ($Orders->paginationPageNumber > 1) {
        $pagination .= "<a class=\"button page-button\" onclick=\"goToPage($page)\">&#10094;</a>";
    } else {
        $pagination .= "<a class=\"button gray-out-button\">&#10094;</a>";
    }

    //pages	
    if ($lastpage < 7 + ($adjacents * 2)) { //not enough pages to bother breaking it up
        for ($counter = 1; $counter <= $lastpage; $counter++) {
            if ($counter == $Orders->paginationPageNumber) {
                $pagination .= "<a class=\"button gray-out-button\">$counter</a>";
            } else {
                $pagination .= "<a class=\"button page-button\" onclick=\"goToPage($counter)\">$counter</a>";
            }
        }
    } elseif ($lastpage > 5 + ($adjacents * 2)) { //enough pages to hide some
        //close to beginning; only hide later pages
        if ($Orders->paginationPageNumber < 1 + ($adjacents * 2)) {
            for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                if ($counter == $Orders->paginationPageNumber) {
                    $pagination .= "<a class=\"button gray-out-button\">$counter</a>";
                } else {
                    $pagination .= "<a class=\"button page-button\" onclick=\"goToPage($counter)\">$counter</a>";
                }
            }
            $pagination .= "...";
            $pagination .= "<a class=\"button page-button\" onclick=\"goToPage($lpm1)\">$lpm1</a>";
            $pagination .= "<a class=\"button page-button\" onclick=\"goToPage($lastpage)\">$lastpage</a>";
        } elseif ($lastpage - ($adjacents * 2) > $Orders->paginationPageNumber && $Orders->paginationPageNumber > ($adjacents * 2)) { //in middle; hide some front and some back
            $pagination .= "<a class=\"button page-button\" onclick=\"goToPage(1)\">1</a>";
            $pagination .= "<a class=\"button page-button\" onclick=\"goToPage(2)\">2</a>";
            $pagination .= "...";
            for ($counter = $Orders->paginationPageNumber - $adjacents; $counter <= $Orders->paginationPageNumber + $adjacents; $counter++) {
                if ($counter == $Orders->paginationPageNumber) {
                    $pagination .= "<a class=\"button gray-out-button\">$counter</a>";
                } else {
                    $pagination .= "<a class=\"button page-button\" onclick=\"goToPage($counter)\">$counter</a>";
                }
            }
            $pagination .= "...";
            $pagination .= "<a class=\"button page-button\" onclick=\"goToPage($lpm1)\">$lpm1</a>";
            $pagination .= "<a class=\"button page-button\" onclick=\"goToPage($lastpage)\">$lastpage</a>";
        }
        //close to end; only hide early pages
        else {
            $pagination .= "<a class=\"button page-button\" onclick=\"goToPage(1)\">1</a>";
            $pagination .= "<a class=\"button page-button\" onclick=\"goToPage(2)\">2</a>";
            $pagination .= "...";
            for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                if ($counter == $Orders->paginationPageNumber) {
                    $pagination .= "<a class=\"button gray-out-button\">$counter</a>";
                } else {
                    $pagination .= "<a class=\"button page-button\" onclick=\"goToPage($counter)\">$counter</a>";
                }
            }
        }
    }

    //next button
    if ($Orders->paginationPageNumber < $counter - 1) {
        $pagination .= "<a class=\"button page-button next_and_previous_buttons\" onclick=\"goToPage($next)\">&#10095;</a>";
    } else {
        $pagination .= "<a class=\"button gray-out-button next_and_previous_buttons\">&#10095;</a>";
    }
}
?>

