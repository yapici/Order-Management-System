<div class="popup-window admin-popup-window" id="users-popup-window">
    <h1>Users</h1>
    <a class="popup-window-cancel-button" onclick="hidePopupWindows();">&#10006;</a>
    <table class="admin-popup-window-table" id="users-popup-window-users-table">
        <thead>
            <tr>
                <td>E-mail</td>
                <td>Phone</td>
                <td>Account Status</td>
                <td>Account Type</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $Users->populateUsersTable();
            ?>
        </tbody>
    </table>
    <div class="error-div" id="users-popup-window-error-div"></div>
    <div class="admin-popup-window-close-button-holder">
        <a class="button admin-popup-window-close-button" onclick="hidePopupWindows()">Close</a>
    </div>
</div>


