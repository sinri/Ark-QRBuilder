<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2018/9/23
 * Time: 23:57
 */
//require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__ . '/autoload.php';

use sinri\ark\qr\builder\QRCode;

// The input parameters
$data = "TheDATA";
$errorCorrectLevel = QRCode::QR_ERROR_CORRECT_LEVEL_L;

$qr = QRCode::getMinimumQRCode($data, $errorCorrectLevel);


//header("Content-type: text/xml");

//print("<qrcode>");
//for ($r = 0; $r < $qr->getModuleCount(); $r++) {
//    print("<line>");
//    for ($c = 0; $c < $qr->getModuleCount(); $c++) {
//        print($qr->isDark($r, $c)? "1" : "0");
//    }
//    print("</line>");
//}
//print("</qrcode>");


for ($r = 0; $r < $qr->getModuleCount(); $r++) {
    for ($c = 0; $c < $qr->getModuleCount(); $c++) {
        echo($qr->isDark($r, $c) ? "█" : " ");
    }
    echo PHP_EOL;
}
