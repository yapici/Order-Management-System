<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE" />
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/jquery-ui-1.11.4.min.js"></script>
<script src="js/main.js"></script>
<link href="css/jquery-ui-1.11.4.min.css" rel="stylesheet">
<link href="css/main.css" rel="stylesheet">
<link rel="icon" type="image/png" href="/images/favicon-96x96.png" sizes="96x96" />
<?php
/* Getting the current file's name without the extension and checking whether
 * there is are css and js files with the same name. If there are, they are included.
 */
$name = basename(filter_input_fix(INPUT_SERVER, 'SCRIPT_FILENAME'), '.php');

$cssFileName = "css/" . $name . ".css";
$cssFilePath = PUBLIC_PATH . $cssFileName;
if (file_exists($cssFilePath)) {
    echo "<link href='$cssFileName' rel='stylesheet'/>";
}

$jsFileName = "js/" . $name . ".js";
$jsFilePath = PUBLIC_PATH . $jsFileName;
if (file_exists($jsFilePath)) {
    echo "<script type='text/javascript' src='$jsFileName'></script>";
}
?>