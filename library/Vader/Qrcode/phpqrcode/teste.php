<?php

include "qrlib.php";

$errorCorrectionLevel = 'H';
$matrixPointSize = 10;

//set it to writable location, a place for temp generated PNG files
$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'qrcode'.DIRECTORY_SEPARATOR;
$PNG_WEB_DIR = "qrcode/";

$filename = $PNG_TEMP_DIR.'qrcode_'.md5(date('Y/m/d H:i:s')).'.png';

QRcode::png('EventoID', $filename, $errorCorrectionLevel, $matrixPointSize, 2);
// QRcode::png('PalestraID', $filename, $errorCorrectionLevel, $matrixPointSize, 2);

//display generated file
echo '<img src="'.$PNG_WEB_DIR.basename($filename).'" /><hr/>';  
