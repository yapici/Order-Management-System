<?php

/* ===================================================================================== */
/* Copyright 2015 Engin Yapici <engin.yapici@gmail.com>                                  */
/* Created on 12/27/2015                                                                 */
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
?>

<div class="popup-window admin-popup-window" id="projects-popup-window">
    <h1>Project</h1>
    <a class="popup-window-cancel-button" onclick="hidePopupWindows();">&#10006;</a>
    <table class="admin-popup-window-table" id="projects-popup-window-projects-table">
        <thead>
            <tr>
                <td>Id</td>
                <td>Project Name</td>
                <td>Project Number</td>
                <td>Active</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $Projects->populateProjectsTable();
            ?>
        </tbody>
        <tfoot>
            <tr class="empty-row">
                <td colspan="9">&nbsp;</td>
            </tr>
            <tr class="add-new-item-title-tr">
                <td colspan="9">Add New Project</td>
            </tr>
            <tr class="add-new-item-input-wrapper-tr">
                <td><b>+</b></td>
                <td><input id="add-new-project-name" type="text" placeholder="Name"/></td>
                <td><input id="add-new-project-number" type="text" placeholder="Number"/></td>
                <td colspan="3" class="add-new-item-button-holder-td"><a class="button" onclick="addNewProject();">Add Project</a></td>
            </tr>
        </tfoot>
    </table>
    <div class="error-div" id="projects-popup-window-error-div"></div>
    <a class="button admin-popup-window-close-button" onclick="hidePopupWindows()">Close</a>
</div>
