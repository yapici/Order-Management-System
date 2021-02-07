<?php
ini_set('display_errors', 0);
define("ROOT", dirname(filter_input(INPUT_SERVER, 'DOCUMENT_ROOT')));
define("PRIVATE_PATH", ROOT . "/private/");
define("PUBLIC_PATH", ROOT . "/public/");
define("BUILD_PATH", ROOT . "/build/");
define("CLASSES_PATH", PRIVATE_PATH . 'include/classes/');

// Setting the timezone to CDT
date_default_timezone_set('America/Chicago');

// Including all the class files under CLASSES_PATH
foreach (glob(CLASSES_PATH . '*.php') as $file) {
    include($file);
}

// Initializing the PDO Database ($Database)
require_once(PRIVATE_PATH . "include/database.php");

// Initializing all the required classes
require_once(PRIVATE_PATH . "include/init_classes.php");

// Including the automatic build number increase functions
require_once(BUILD_PATH . "build.php");
?>