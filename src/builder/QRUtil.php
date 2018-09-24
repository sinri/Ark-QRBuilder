<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2018/9/23
 * Time: 23:27
 */

namespace sinri\ark\qr\builder;


//---------------------------------------------------------------
// QRUtil
//---------------------------------------------------------------

define("QR_G15", (1 << 10) | (1 << 8) | (1 << 5)
    | (1 << 4) | (1 << 2) | (1 << 1) | (1 << 0));

define("QR_G18", (1 << 12) | (1 << 11) | (1 << 10)
    | (1 << 9) | (1 << 8) | (1 << 5) | (1 << 2) | (1 << 0));

define("QR_G15_MASK", (1 << 14) | (1 << 12) | (1 << 10)
    | (1 << 4) | (1 << 1));

class QRUtil
{

    static $QR_MAX_LENGTH = array(
        array(array(41, 25, 17, 10), array(34, 20, 14, 8), array(27, 16, 11, 7), array(17, 10, 7, 4)),
        array(array(77, 47, 32, 20), array(63, 38, 26, 16), array(48, 29, 20, 12), array(34, 20, 14, 8)),
        array(array(127, 77, 53, 32), array(101, 61, 42, 26), array(77, 47, 32, 20), array(58, 35, 24, 15)),
        array(array(187, 114, 78, 48), array(149, 90, 62, 38), array(111, 67, 46, 28), array(82, 50, 34, 21)),
        array(array(255, 154, 106, 65), array(202, 122, 84, 52), array(144, 87, 60, 37), array(106, 64, 44, 27)),
        array(array(322, 195, 134, 82), array(255, 154, 106, 65), array(178, 108, 74, 45), array(139, 84, 58, 36)),
        array(array(370, 224, 154, 95), array(293, 178, 122, 75), array(207, 125, 86, 53), array(154, 93, 64, 39)),
        array(array(461, 279, 192, 118), array(365, 221, 152, 93), array(259, 157, 108, 66), array(202, 122, 84, 52)),
        array(array(552, 335, 230, 141), array(432, 262, 180, 111), array(312, 189, 130, 80), array(235, 143, 98, 60)),
        array(array(652, 395, 271, 167), array(513, 311, 213, 131), array(364, 221, 151, 93), array(288, 174, 119, 74))
    );

    static $QR_PATTERN_POSITION_TABLE = array(
        array(),
        array(6, 18),
        array(6, 22),
        array(6, 26),
        array(6, 30),
        array(6, 34),
        array(6, 22, 38),
        array(6, 24, 42),
        array(6, 26, 46),
        array(6, 28, 50),
        array(6, 30, 54),
        array(6, 32, 58),
        array(6, 34, 62),
        array(6, 26, 46, 66),
        array(6, 26, 48, 70),
        array(6, 26, 50, 74),
        array(6, 30, 54, 78),
        array(6, 30, 56, 82),
        array(6, 30, 58, 86),
        array(6, 34, 62, 90),
        array(6, 28, 50, 72, 94),
        array(6, 26, 50, 74, 98),
        array(6, 30, 54, 78, 102),
        array(6, 28, 54, 80, 106),
        array(6, 32, 58, 84, 110),
        array(6, 30, 58, 86, 114),
        array(6, 34, 62, 90, 118),
        array(6, 26, 50, 74, 98, 122),
        array(6, 30, 54, 78, 102, 126),
        array(6, 26, 52, 78, 104, 130),
        array(6, 30, 56, 82, 108, 134),
        array(6, 34, 60, 86, 112, 138),
        array(6, 30, 58, 86, 114, 142),
        array(6, 34, 62, 90, 118, 146),
        array(6, 30, 54, 78, 102, 126, 150),
        array(6, 24, 50, 76, 102, 128, 154),
        array(6, 28, 54, 80, 106, 132, 158),
        array(6, 32, 58, 84, 110, 136, 162),
        array(6, 26, 54, 82, 110, 138, 166),
        array(6, 30, 58, 86, 114, 142, 170)
    );

    static function getPatternPosition($typeNumber)
    {
        return self::$QR_PATTERN_POSITION_TABLE[$typeNumber - 1];
    }

    static function getMaxLength($typeNumber, $mode, $errorCorrectLevel)
    {

        $t = $typeNumber - 1;
        $e = 0;
        $m = 0;

        switch ($errorCorrectLevel) {
            case QRCode::QR_ERROR_CORRECT_LEVEL_L :
                $e = 0;
                break;
            case QRCode::QR_ERROR_CORRECT_LEVEL_M :
                $e = 1;
                break;
            case QRCode::QR_ERROR_CORRECT_LEVEL_Q :
                $e = 2;
                break;
            case QRCode::QR_ERROR_CORRECT_LEVEL_H :
                $e = 3;
                break;
            default :
                trigger_error("e:$errorCorrectLevel", E_USER_ERROR);
        }

        switch ($mode) {
            case QRCode::QR_MODE_NUMBER    :
                $m = 0;
                break;
            case QRCode::QR_MODE_ALPHA_NUM :
                $m = 1;
                break;
            case QRCode::QR_MODE_8BIT_BYTE :
                $m = 2;
                break;
            case QRCode::QR_MODE_KANJI     :
                $m = 3;
                break;
            default :
                trigger_error("m:$mode", E_USER_ERROR);
        }

        return self::$QR_MAX_LENGTH[$t][$e][$m];
    }

    /**
     * @param $errorCorrectLength
     * @return QRPolynomial
     * @throws \Exception
     */
    static function getErrorCorrectPolynomial($errorCorrectLength)
    {

        $a = new QRPolynomial(array(1));

        for ($i = 0; $i < $errorCorrectLength; $i++) {
            $a = $a->multiply(new QRPolynomial(array(1, QRMath::gexp($i))));
        }

        return $a;
    }

    /**
     * @param $maskPattern
     * @param $i
     * @param $j
     * @return bool
     * @throws \Exception
     */
    static function getMask($maskPattern, $i, $j)
    {

        switch ($maskPattern) {

            case QRCode::QR_MASK_PATTERN000 :
                return ($i + $j) % 2 == 0;
            case QRCode::QR_MASK_PATTERN001 :
                return $i % 2 == 0;
            case QRCode::QR_MASK_PATTERN010 :
                return $j % 3 == 0;
            case QRCode::QR_MASK_PATTERN011 :
                return ($i + $j) % 3 == 0;
            case QRCode::QR_MASK_PATTERN100 :
                return (floor($i / 2) + floor($j / 3)) % 2 == 0;
            case QRCode::QR_MASK_PATTERN101 :
                return ($i * $j) % 2 + ($i * $j) % 3 == 0;
            case QRCode::QR_MASK_PATTERN110 :
                return (($i * $j) % 2 + ($i * $j) % 3) % 2 == 0;
            case QRCode::QR_MASK_PATTERN111 :
                return (($i * $j) % 3 + ($i + $j) % 2) % 2 == 0;

            default :
                //trigger_error("mask:$maskPattern", E_USER_ERROR);
        }
        throw new \Exception("mask:$maskPattern");
    }

    /**
     * @param QRCode $qrCode
     *
     * @return float|int
     */
    static function getLostPoint($qrCode)
    {

        $moduleCount = $qrCode->getModuleCount();

        $lostPoint = 0;


        // LEVEL1

        for ($row = 0; $row < $moduleCount; $row++) {

            for ($col = 0; $col < $moduleCount; $col++) {

                $sameCount = 0;
                $dark = $qrCode->isDark($row, $col);

                for ($r = -1; $r <= 1; $r++) {

                    if ($row + $r < 0 || $moduleCount <= $row + $r) {
                        continue;
                    }

                    for ($c = -1; $c <= 1; $c++) {

                        if (($col + $c < 0 || $moduleCount <= $col + $c) || ($r == 0 && $c == 0)) {
                            continue;
                        }

                        if ($dark == $qrCode->isDark($row + $r, $col + $c)) {
                            $sameCount++;
                        }
                    }
                }

                if ($sameCount > 5) {
                    $lostPoint += (3 + $sameCount - 5);
                }
            }
        }

        // LEVEL2

        for ($row = 0; $row < $moduleCount - 1; $row++) {
            for ($col = 0; $col < $moduleCount - 1; $col++) {
                $count = 0;
                if ($qrCode->isDark($row, $col)) $count++;
                if ($qrCode->isDark($row + 1, $col)) $count++;
                if ($qrCode->isDark($row, $col + 1)) $count++;
                if ($qrCode->isDark($row + 1, $col + 1)) $count++;
                if ($count == 0 || $count == 4) {
                    $lostPoint += 3;
                }
            }
        }

        // LEVEL3

        for ($row = 0; $row < $moduleCount; $row++) {
            for ($col = 0; $col < $moduleCount - 6; $col++) {
                if ($qrCode->isDark($row, $col)
                    && !$qrCode->isDark($row, $col + 1)
                    && $qrCode->isDark($row, $col + 2)
                    && $qrCode->isDark($row, $col + 3)
                    && $qrCode->isDark($row, $col + 4)
                    && !$qrCode->isDark($row, $col + 5)
                    && $qrCode->isDark($row, $col + 6)) {
                    $lostPoint += 40;
                }
            }
        }

        for ($col = 0; $col < $moduleCount; $col++) {
            for ($row = 0; $row < $moduleCount - 6; $row++) {
                if ($qrCode->isDark($row, $col)
                    && !$qrCode->isDark($row + 1, $col)
                    && $qrCode->isDark($row + 2, $col)
                    && $qrCode->isDark($row + 3, $col)
                    && $qrCode->isDark($row + 4, $col)
                    && !$qrCode->isDark($row + 5, $col)
                    && $qrCode->isDark($row + 6, $col)) {
                    $lostPoint += 40;
                }
            }
        }

        // LEVEL4

        $darkCount = 0;

        for ($col = 0; $col < $moduleCount; $col++) {
            for ($row = 0; $row < $moduleCount; $row++) {
                if ($qrCode->isDark($row, $col)) {
                    $darkCount++;
                }
            }
        }

        $ratio = abs(100 * $darkCount / $moduleCount / $moduleCount - 50) / 5;
        $lostPoint += $ratio * 10;

        return $lostPoint;
    }

    static function getMode($s)
    {
        if (QRUtil::isAlphaNum($s)) {
            if (QRUtil::isNumber($s)) {
                return QRCode::QR_MODE_NUMBER;
            }
            return QRCode::QR_MODE_ALPHA_NUM;
        } else if (QRUtil::isKanji($s)) {
            return QRCode::QR_MODE_KANJI;
        } else {
            return QRCode::QR_MODE_8BIT_BYTE;
        }
    }

    static function isNumber($s)
    {
        for ($i = 0; $i < strlen($s); $i++) {
            $c = ord($s[$i]);
            if (!(QRUtil::toCharCode('0') <= $c && $c <= QRUtil::toCharCode('9'))) {
                return false;
            }
        }
        return true;
    }

    static function isAlphaNum($s)
    {
        for ($i = 0; $i < strlen($s); $i++) {
            $c = ord($s[$i]);
            if (!(QRUtil::toCharCode('0') <= $c && $c <= QRUtil::toCharCode('9'))
                && !(QRUtil::toCharCode('A') <= $c && $c <= QRUtil::toCharCode('Z'))
                && strpos(" $%*+-./:", $s[$i]) === false) {
                return false;
            }
        }
        return true;
    }

    static function isKanji($s)
    {

        $data = $s;

        $i = 0;

        while ($i + 1 < strlen($data)) {

            $c = ((0xff & ord($data[$i])) << 8) | (0xff & ord($data[$i + 1]));

            if (!(0x8140 <= $c && $c <= 0x9FFC) && !(0xE040 <= $c && $c <= 0xEBBF)) {
                return false;
            }

            $i += 2;
        }

        if ($i < strlen($data)) {
            return false;
        }

        return true;
    }

    static function toCharCode($s)
    {
        return ord($s[0]);
    }

    static function getBCHTypeInfo($data)
    {
        $d = $data << 10;
        while (QRUtil::getBCHDigit($d) - QRUtil::getBCHDigit(QR_G15) >= 0) {
            $d ^= (QR_G15 << (QRUtil::getBCHDigit($d) - QRUtil::getBCHDigit(QR_G15)));
        }
        return (($data << 10) | $d) ^ QR_G15_MASK;
    }

    static function getBCHTypeNumber($data)
    {
        $d = $data << 12;
        while (QRUtil::getBCHDigit($d) - QRUtil::getBCHDigit(QR_G18) >= 0) {
            $d ^= (QR_G18 << (QRUtil::getBCHDigit($d) - QRUtil::getBCHDigit(QR_G18)));
        }
        return ($data << 12) | $d;
    }

    static function getBCHDigit($data)
    {

        $digit = 0;

        while ($data != 0) {
            $digit++;
            $data >>= 1;
        }

        return $digit;
    }
}