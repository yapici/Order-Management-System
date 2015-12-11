<?php
/* ================================================================ */
/* Created by Engin Yapici on 10/19/2015                            */
/* Last modified by Engin Yapici on 10/23/2015                      */
/* Copyright Engin Yapici, 2015.                                    */
/* enginyapici@gmail.com                                            */
/* ================================================================ */

define("APP_ROOT", dirname(dirname(__FILE__)));
define("PRIVATE_PATH", APP_ROOT . "/");
define("DOMAIN_NAME", 'http://hireforall.com');

require_once(PRIVATE_PATH . "/include/passwords.php");
require_once(PRIVATE_PATH . "/include/database.php");
require_once(PRIVATE_PATH . "/include/functions.php");
require_once(PRIVATE_PATH . "/include/misc_functions.php");
require_once(PRIVATE_PATH . "/include/session_functions.php");
?>