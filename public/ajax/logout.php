<?php
require('../../private/include/include.php');
// Below if statement prevents direct access to the file. It can only be accessed through "AJAX".
if (filter_input(INPUT_SERVER, 'HTTP_X_REQUESTED_WITH')) {
    $Session->afterSuccessfulLogout();
    echo 'success';
} else {
    $Functions->phpRedirect('');
}
?>
