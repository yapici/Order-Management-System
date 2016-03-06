<?php

/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 03/06/2016                                                                 */
/* Last modified on 03/06/2016                                                           */
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

require('../../private/include/include.php');
// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if (filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
    if (!$Session->isSessionValid()) {
        $jsonResponse['status'] = "no_session";
    } else {
        // Getting the parameters passed through AJAX
        $sanitizedPostArray = $Functions->sanitizePostedVariables();
        $postedCostCenterId = $sanitizedPostArray['cost_center'];
        $postedProjectId = $sanitizedPostArray['project'];

        $postedOrderId = trim(substr($sanitizedPostArray['order_id'], 5));

        $latestStatus = $ItemDetails->getItemOrderStatus($postedOrderId);

        if ($latestStatus == "Pending") {
            if ($ItemDetails->updateItemDetails($sanitizedPostArray)) {
                ob_start();
                require_once(PRIVATE_PATH . 'require/orders-table-body-query.php');
                $jsonResponse['html_tbody'] = ob_get_clean();
                $jsonResponse['html_pagination'] = $pagination;
                $jsonResponse['cost_center_name'] = $CostCenters->getCostCentersArray()[$postedCostCenterId]['name'];
                $jsonResponse['description'] = $sanitizedPostArray['description'];
                $jsonResponse['quantity'] = $sanitizedPostArray['quantity'];
                $jsonResponse['catalog_no'] = $sanitizedPostArray['catalog_no'];
                $jsonResponse['uom'] = $sanitizedPostArray['uom'];
                $jsonResponse['weblink'] = $sanitizedPostArray['weblink'];
                $jsonResponse['comments'] = $sanitizedPostArray['comments'];
                $jsonResponse['sds'] = $sanitizedPostArray['sds'];
                $jsonResponse['vendor_name'] = $Vendors->getVendorsArray()[$sanitizedPostArray['vendor']]['name'];
                $jsonResponse['price'] = $sanitizedPostArray['price'];
                $jsonResponse['user'] = $_SESSION['username'];
                $jsonResponse['date'] = date('d-M-Y');

                $project = $Projects->getProjectsArray()[$postedProjectId];
                $jsonResponse['project'] = $project['name'] . ' / ' . $project['number'];

                $jsonResponse['status'] = "success";
            } else {
                $jsonResponse['status'] = "fail";
            }
        } else {
            $jsonResponse['status'] = "status_changed";
            $jsonResponse['latest_status'] = $latestStatus;
        }
    }
    echo json_encode($jsonResponse);
} else {
    $Functions->phpRedirect('');
}

