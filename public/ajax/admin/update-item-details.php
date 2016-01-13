<?php

/* ===================================================================================== */
/* Copyright 2016 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/13/2015                                                                 */
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

require('../../../private/include/include.php');
// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if (filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
    $adminCheckResponse = $Admin->ajaxAdminChecks();
    if ($adminCheckResponse !== true) {
        $jsonResponse['status'] = $adminCheckResponse;
    } else {
        // Getting the parameters passed through AJAX
        $sanitizedPostArray = $Functions->sanitizePostedVariables();
        $postedCostCenterId = $sanitizedPostArray['cost_center'];
        $postedProjectId = $sanitizedPostArray['project'];
        $postedOrderId = trim(substr($sanitizedPostArray['order_id'], 5));
        $postedStatus = $sanitizedPostArray['status'];

        if ($ItemDetails->updateItemDetails($sanitizedPostArray)) {
            
            if ($postedStatus == 'Ordered') {
                $ItemDetails->sendStatusChangeEmail($postedOrderId, 'Ordered');
            } else if ($postedStatus == 'Backordered') {
                $ItemDetails->sendStatusChangeEmail($postedOrderId, 'Backordered');
            } else if ($postedStatus == 'Delivered') {
                $ItemDetails->sendStatusChangeEmail($postedOrderId, 'Delivered');
            }
            
            ob_start();
            require_once(PRIVATE_PATH . 'require/orders-table-body-query.php');
            $jsonResponse['html_tbody'] = ob_get_clean();
            $jsonResponse['html_pagination'] = $pagination;
            $jsonResponse['cost_center_name'] = $CostCenters->getCostCentersArray()[$postedCostCenterId]['name'];
            $jsonResponse['quantity'] = $sanitizedPostArray['quantity'];
            $jsonResponse['catalog_no'] = $sanitizedPostArray['catalog_no'];
            $jsonResponse['uom'] = $sanitizedPostArray['uom'];
            $jsonResponse['weblink'] = $sanitizedPostArray['weblink'];
            $jsonResponse['comments'] = $sanitizedPostArray['comments'];
            $jsonResponse['invoice_no'] = $sanitizedPostArray['invoice_no'];
            $jsonResponse['vendor_order_no'] = $sanitizedPostArray['vendor_order_no'];
            
            $project = $Projects->getProjectsArray()[$postedProjectId];
            $jsonResponse['project'] = $project['name'] . ' / ' . $project['number'];
            
            $jsonResponse['status'] = "success";
        } else {
            $jsonResponse['status'] = "fail";
        }
    }
    echo json_encode($jsonResponse);
} else {
    $Functions->phpRedirect('');
}

