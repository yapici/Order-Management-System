<div class="popup-window admin-popup-window" id="projects-popup-window">
    <h1>Projects</h1>
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
                <td><input id="add-new-project-number" type="text" placeholder="Project Number"/></td>
                <td colspan="3" class="add-new-item-button-holder-td"><a class="button" onclick="addNewProject();">Add Project</a></td>
            </tr>
        </tfoot>
    </table>
    <div class="error-div" id="projects-popup-window-error-div"></div>
    <div class="admin-popup-window-close-button-holder">
        <a class="button admin-popup-window-close-button" onclick="hidePopupWindows()">Close</a>
    </div>
</div>
