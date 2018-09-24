<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2018/9/23
 * Time: 23:29
 */

namespace sinri\ark\qr\builder;

/**
 * Class QR8BitByte
 * @package sinri\ark\qr\builder
 */
class QR8BitByte extends QRData
{

    /**
     * QR8BitByte constructor.
     * @param $data
     */
    function __construct($data)
    {
        parent::__construct(QRCode::QR_MODE_8BIT_BYTE, $data);
    }

    /**
     * @param QRBitBuffer $buffer
     */
    function write(&$buffer)
    {

        $data = $this->getData();
        for ($i = 0; $i < strlen($data); $i++) {
            $buffer->put(ord($data[$i]), 8);
        }
    }

}