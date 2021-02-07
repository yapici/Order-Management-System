<?php
include ('../private/include/include.php');

$filecode = str_replace(' ', '', filter_input(INPUT_GET, 'file'));
$filename = $Functions->decode($filecode);
$filepath = PRIVATE_PATH . 'attachments/' . $filename;

if (file_exists($filepath) && filesize($filepath) > 4096) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($filepath));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filepath));
    ob_clean();
    flush();
    readfile($filepath);
    exit;
} else {
    $Functions->phpRedirect('');
}
?>