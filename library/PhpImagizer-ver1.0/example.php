<?php
include 'PhpImagizer.php';
// Source file name
$srcFileName = 'sourceImage.gif';
try {
// Get instance
    $imagizer = new PhpImagizer($srcFileName);
    $imagizer->fitSize(200);
    $imagizer->saveImg('DestFileName.gif');
} catch (PhpImagizerException $e) {
    // Do something (Log, send email?)
}