<?php
require_once (PRIVATE_PATH . 'require/popup-windows/item-details-popup-window.php');
require_once (PRIVATE_PATH . 'require/popup-windows/delete-file-confirmation-popup-window.php');
require_once (PRIVATE_PATH . 'require/popup-windows/login-popup-window.php');

echo '<div class="popup-window" id="add-new-item-popup-window">';
require_once (PRIVATE_PATH . 'require/popup-windows/add-new-item-popup-window.php');
echo '</div>';

if ($Admin->isAdmin()) {
    require_once (PRIVATE_PATH . 'require/popup-windows/vendors-popup-window.php');
    require_once (PRIVATE_PATH . 'require/popup-windows/projects-popup-window.php');
    require_once (PRIVATE_PATH . 'require/popup-windows/cost-centers-popup-window.php');
    require_once (PRIVATE_PATH . 'require/popup-windows/users-popup-window.php');
    require_once (PRIVATE_PATH . 'require/popup-windows/reset-password-confirmation-popup-window.php');
    require_once (PRIVATE_PATH . 'require/popup-windows/delete-vendor-confirmation-popup-window.php');
    echo "<style>";
    require(PRIVATE_PATH . 'require/css/popup-windows.css');
    echo "</style>";
    echo "<script type='text/javascript'>";
    require(PRIVATE_PATH . 'require/js/popup-windows.js');
    echo "</script>";
}
?>
