<?php
class Session {
    
    function __construct() {
        session_start();
    }

    function endSession() {
        session_unset();
        session_destroy();
    }

    function requestIpMatchesSession() {
        if (!isset($_SESSION['ip']) || !isset($_SERVER['REMOTE_ADDR'])) {
            return false;
        }
        if ($_SESSION['ip'] === $_SERVER['REMOTE_ADDR']) {
            return true;
        } else {
            return false;
        }
    }
    
    function requestUserAgentMatchesSession() {
        if (!isset($_SESSION['user_agent']) || !isset($_SERVER['HTTP_USER_AGENT'])) {
            return false;
        }
        if ($_SESSION['user_agent'] === $_SERVER['HTTP_USER_AGENT']) {
            return true;
        } else {
            return false;
        }
    }

    function lastLoginIsRecent() {
        $maxElapsed = 24 * 60 * 60; // 1 day
        if (!isset($_SESSION['last_login'])) {
            $this->afterSuccessfulLogout();
            return false;
        }
        if (($_SESSION['last_login'] + $maxElapsed) >= time()) {
            $_SESSION['last_login'] = time();
            return true;
        } else {
            $this->afterSuccessfulLogout();
            return false;
        }
    }

    function isSessionValid() {
        $checkIp = true;
        $checkUserAgent = true;
        $checkLastLogin = true;

        if ($checkIp && !$this->requestIpMatchesSession()) {
            return false;
        }
        if ($checkUserAgent && !$this->requestUserAgentMatchesSession()) {
            return false;
        }
        if ($checkLastLogin && !$this->lastLoginIsRecent()) {
            return false;
        }
        return true;
    }

    function isLoggedIn() {
        return (isset($_SESSION['logged_in']) && $_SESSION['logged_in']);
    }

    function afterSuccessfulLogin() {
        session_regenerate_id();

        $_SESSION['logged_in'] = true;

        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
        $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        $_SESSION['last_login'] = time();
    }

    function afterSuccessfulLogout() {
        $_SESSION['logged_in'] = false;
        $this->endSession();
    }
}
?>