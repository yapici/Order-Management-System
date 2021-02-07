<?php
class Admin {

    private $Session;

    /**
     * @param Session $session
     */
    function __construct($session) {
        $this->Session = $session;
    }

    /**
     *  @return boolean If the logged in user is an administrator, 'true' is returned.
     */
    public function isAdmin() {
        if (isset($_SESSION['user_type']) && ($_SESSION['user_type'] == '1' || $_SESSION['user_type'] == '2')) {
            return true;
        } else {
            return false;
        }
    }

    public function ajaxAdminChecks() {
        if (!$this->Session->isSessionValid()) {
            $response = "no_session";
        } else if ($_SESSION['user_type'] != Constants::USER_TYPE_PURCHASING_PERSON &&
                $_SESSION['user_type'] != Constants::USER_TYPE_ADMINISTRATOR) {
            $response = "unauthorized_access";
        } else {
            $response = true;
        }
        return $response;
    }

}