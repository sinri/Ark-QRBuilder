<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2018/9/24
 * Time: 00:03
 */

use sinri\ark\qr\builder\QRCode;

require_once __DIR__ . '/autoload.php';

//---------------------------------------------------------
print("<h4>明示的に型番を指定</h4>");
$qr = new QRCode();
// エラー訂正レベルを設定
// QR_ERROR_CORRECT_LEVEL_L : 7%
// QR_ERROR_CORRECT_LEVEL_M : 15%
// QR_ERROR_CORRECT_LEVEL_Q : 25%
// QR_ERROR_CORRECT_LEVEL_H : 30%
$qr->setErrorCorrectLevel(QRCode::QR_ERROR_CORRECT_LEVEL_L);
// 型番(大きさ)を設定
// 1～40
$qr->setTypeNumber(4);
// データ(文字列※)を設定
// ※日本語はShiftJIS
$qr->addData("QR-Code");
// QRコードを作成
$qr->make();
// HTML出力
$qr->printHTML();
//---------------------------------------------------------
print("<h4>型番自動</h4>");
// 型番が最小となるQRコードを作成
$qr = QRCode::getMinimumQRCode("QR-Code", QRCode::QR_ERROR_CORRECT_LEVEL_L);
// HTML出力
$qr->printHTML();