<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2018/9/24
 * Time: 17:14
 */

require_once __DIR__ . '/autoload.php';

$qr = \sinri\ark\qr\builder\ArkQRBuilder::makeQRInstance("LALALA", 8, \sinri\ark\qr\builder\QRCode::QR_ERROR_CORRECT_LEVEL_M);
$matrix = $qr->getQRMatrix();
print_r($matrix);