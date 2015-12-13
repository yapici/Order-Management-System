<?php
/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 10/26/2015                                                                 */
/* Last modified on 12/12/2015                                                           */
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
?>


<div class="popup-window" id="item-details-popup-window">
    <a class="popup-window-cancel-button" onclick="hidePopupWindows()">&#10006;</a>
    <h1 id="popup-item-order-number">Order 100003</h1>
    <table class="top-panel">
        <tr>
            <td class="left-panel">
                <table>
                    <tr>
                        <td>Description:</td>
                        <td class="add-new-item-input-holder-td">
                            <span id="popup-item-description">GSTag Columns</span>
                        </td>
                    </tr>      
                    <tr>
                        <td>Quantity:</td>
                        <td class="add-new-item-input-holder-td">
                            <span id="popup-item-quantity">1</span>
                        </td>
                    </tr>
                    <tr>
                        <td title="Unit of Measurement">UoM:</td>
                        <td class="add-new-item-input-holder-td">
                            <span id="popup-item-uom">5/Box</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Vendor:</td>
                        <td class="add-new-item-input-holder-td">
                            <span id="popup-item-vendor">Biorad</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Catalog No:</td>
                        <td class="add-new-item-input-holder-td">
                            <span id="popup-item-catalog-no">12345</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Price:</td>
                        <td class="add-new-item-input-holder-td">
                            <span id="popup-item-price">$350.00</span>
                        </td>
                    </tr>                  
                </table>
            </td>
            <td class="right-panel">
                <table> 
                    <tr>
                        <td>Cost Center:</td>
                        <td class="add-new-item-input-holder-td">
                            <span id="popup-item-cost-center">Bio</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Project Name & No:</td>
                        <td class="add-new-item-input-holder-td">
                            <span id="popup-item-cost-center">Project 1/ABC123456</span>
                        </td>
                    </tr>   
                    <tr>
                        <td>Account Number:</td>
                        <td class="add-new-item-input-holder-td">
                            <span id="popup-item-account-no">0987654</span>
                        </td>
                    </tr>  
                    <tr>
                        <td>Comments:</td>
                        <td class="add-new-item-input-holder-td">
                            <span id="popup-item-comments">None</span>
                        </td>
                    </tr>  
                    <tr>
                        <td>Item Requested By:</td>
                        <td>
                            <span id="popup-item-requested-by">Engin Yapici</span>
                            <span id="popup-item-requested-date">on 22-Oct-2015 14:43 (GMT -05:00)</span>
                        </td>
                    </tr>
                    <tr>
                        <td>Item Needed By:</td>
                        <td class="add-new-item-input-holder-td">
                            <span id="popup-item-item-needed-by"><?php echo date('d-M-Y', strtotime("+10 days")); ?></span>
                        </td>
                    </tr> 
                </table>
            </td>
        </tr>
    </table>
    <hr class="horizontal-divider"></hr>
    <div class="bottom-panel">
        <table>
            <tr>
                <td>Status:</td><td id="popup-item-status">Ordered</td>
            </tr>
            <tr>
                <td>Last Updated By:</td>
                <td>
                    <span id="popup-item-last-updated-by">Steve Ennis</span>
                    <span id="popup-item-last-updated-date">on 22-Oct-2015 14:43 (GMT -05:00)</span>
                </td>
            </tr>
        </table>
        <hr class="horizontal-divider"></hr>
        <div id="attachments-holder">
            <?php
            require_once('item-details-popup-window-populate-attachments.php');
            ?>
        </div>
    </div>
    <a class="button" onclick="hidePopupWindow()">Close</a>
    <div class="error-div" id="item-details-popup-window-error-div"></div>
</div>

