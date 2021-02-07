<?php
// Opening the json file that holds the file paths and file modification dates
$string = file_get_contents(BUILD_PATH . 'files.json');
$jsonArray = json_decode($string, true);

// Putting the values into a local array
$jsonFileArray = array();
foreach ($jsonArray as $filePath => $modifiedDate) {
    $jsonFileArray[$filePath] = $modifiedDate;
}

// Iterating through the directories and putting the file paths and modification dates into a local array
$filesArray = array();
$dir_iterator = new RecursiveDirectoryIterator(PUBLIC_PATH); // public directory
$recursive_iterator = new RecursiveIteratorIterator($dir_iterator);
foreach ($recursive_iterator as $file) {
    if ($file->isDir()) {
        continue;
    }
    if (substr($file, -7) != 'php.log' &&
            substr($file, -9) != 'error_log' &&
            substr($file, -9) != 'README.md') {
        $fileName = 'public/' . $file->getPathname();
        $fileModifiedDate = date('m/d/y H:i:s', $file->getMTime());
        $filesArray[$fileName] = $fileModifiedDate;
    }
}

$dir_iterator = new RecursiveDirectoryIterator(PRIVATE_PATH); // private directory
$recursive_iterator = new RecursiveIteratorIterator($dir_iterator);
foreach ($recursive_iterator as $file) {
    if ($file->isDir()) {
        continue;
    }
    if (!preg_match('/private\/attachments/', $file) &&
            substr($file, -7) != 'php.log' &&
            substr($file, -9) != 'error_log') {
        $fileName = $file->getPathname();
        $fileModifiedDate = date('m/d/y H:i:s', $file->getMTime());
        $filesArray[$fileName] = $fileModifiedDate;
    }
}

// Checking if there are any files that are modified/created/deleted
if ($jsonFileArray != $filesArray) {
    $file = BUILD_PATH . "build";
    file_put_contents($file, file_get_contents($file) + 1);
}

// Updating the json file with the latest modifiedDates
$jsonFile = fopen(BUILD_PATH . 'files.json', 'w');
fwrite($jsonFile, json_encode($filesArray, JSON_UNESCAPED_SLASHES));
fclose($jsonFile);
?>