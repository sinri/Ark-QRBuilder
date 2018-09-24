<?php
/**
 * Created by PhpStorm.
 * User: Sinri
 * Date: 2018/9/23
 * Time: 23:58
 */

require_once __DIR__ . '/../vendor/autoload.php';

\sinri\ark\core\ArkHelper::registerAutoload(
    'sinri\ark\qr',
    __DIR__ . '/../src'
);

//\sinri\ark\qr\builder\QRMath::init();