<?php
ini_set('display_errors', 0);

function filter_input_fix ($type, $variable_name, $filter = FILTER_DEFAULT, $options = NULL )
{
    $checkTypes =[
        INPUT_GET,
        INPUT_POST,
        INPUT_COOKIE
    ];

    if ($options === NULL) {
        // No idea if this should be here or not
        // Maybe someone could let me know if this should be removed?
        $options = FILTER_NULL_ON_FAILURE;
    }

    if (in_array($type, $checkTypes) || filter_has_var($type, $variable_name)) {
        return filter_input($type, $variable_name, $filter, $options);
    } else if ($type == INPUT_SERVER && isset($_SERVER[$variable_name])) {
        return filter_var($_SERVER[$variable_name], $filter, $options);
    } else if ($type == INPUT_ENV && isset($_ENV[$variable_name])) {
        return filter_var($_ENV[$variable_name], $filter, $options);
    } else {
        return NULL;
    }
}

define("ROOT", dirname(filter_input_fix(INPUT_SERVER, 'DOCUMENT_ROOT')));
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