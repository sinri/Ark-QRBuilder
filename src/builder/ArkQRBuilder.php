<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2018/9/24
 * Time: 18:17
 */

namespace sinri\ark\qr\builder;


class ArkQRBuilder
{
    /**
     * @param string $data
     * @param int $errorCorrectLevel
     * @return QRCode
     * @throws \Exception
     */
    public static function quickMakeMinimumQRInstance($data, $errorCorrectLevel)
    {
        $qr = QRCode::getMinimumQRCode($data, $errorCorrectLevel);
        return $qr;
    }


    /**
     * @param string $data データ(文字列※)を設定 ※日本語はShiftJIS This might be data or string. Use ShiftJIS for Japanese.
     * @param int $type 型番(大きさ)を設定 The scale of text, 1-40
     * @param int $errorCorrectLevel エラー訂正レベルを設定 See QRCode::QR_ERROR_CORRECT_LEVEL_[L|M|Q|H]
     * @return QRCode
     * @throws \Exception
     */
    public static function makeQRInstance($data, $type = 4, $errorCorrectLevel = QRCode::QR_ERROR_CORRECT_LEVEL_L)
    {
        // エラー訂正レベルを設定
        // QR_ERROR_CORRECT_LEVEL_L : 7%
        // QR_ERROR_CORRECT_LEVEL_M : 15%
        // QR_ERROR_CORRECT_LEVEL_Q : 25%
        // QR_ERROR_CORRECT_LEVEL_H : 30%

        $qr = new QRCode();
        $qr->setErrorCorrectLevel($errorCorrectLevel);
        $qr->setTypeNumber($type);
        $qr->addData($data);
        $qr->make();
        return $qr;
    }
}