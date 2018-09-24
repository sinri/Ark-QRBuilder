<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2018/9/23
 * Time: 23:31
 */

namespace sinri\ark\qr\builder;


/**
 * Class QRBitBuffer
 * @package sinri\ark\qr\builder
 */
class QRBitBuffer
{

    var $buffer;
    var $length;

    function __construct()
    {
        $this->buffer = array();
        $this->length = 0;
    }

    function getBuffer()
    {
        return $this->buffer;
    }

    function getLengthInBits()
    {
        return $this->length;
    }

    function __toString()
    {
        $buffer = "";
        for ($i = 0; $i < $this->getLengthInBits(); $i++) {
            $buffer .= $this->get($i) ? '1' : '0';
        }
        return $buffer;
    }

    function get($index)
    {
        $bufIndex = (int)floor($index / 8);
        return (($this->buffer[$bufIndex] >> (7 - $index % 8)) & 1) == 1;
    }

    function put($num, $length)
    {

        for ($i = 0; $i < $length; $i++) {
            $this->putBit((($num >> ($length - $i - 1)) & 1) == 1);
        }
    }

    function putBit($bit)
    {

        $bufIndex = (int)floor($this->length / 8);
        if (count($this->buffer) <= $bufIndex) {
            $this->buffer[] = 0;
        }

        if ($bit) {
            $this->buffer[$bufIndex] |= (0x80 >> ($this->length % 8));
        }

        $this->length++;
    }
}