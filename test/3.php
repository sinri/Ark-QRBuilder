<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2018/9/24
 * Time: 00:08
 */

use sinri\ark\qr\builder\QRCode;

require_once __DIR__ . '/autoload.php';

$qr = QRCode::getMinimumQRCode("QRコード", QRCode::QR_ERROR_CORRECT_LEVEL_L);
// イメージ作成(引数:サイズ,マージン)
$im = $qr->createImage(2, 4);
header("Content-type: image/gif");
imagegif($im);
imagedestroy($im);