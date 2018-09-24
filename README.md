# Ark-QRBuilder
The QR builder components of Ark 2.

## Usage

### 0x00. Create a QRCode Instance

To generate a QRCode Instance, you can use `\sinri\ark\qr\builder\ArkQRBuilder::makeQRInstance` or `\sinri\ark\qr\builder\ArkQRBuilder::quickMakeMinimumQRInstance`.

Full Parameters, and only 1st and 4th is required for quick maker.

* $data
* $mode default as QRCode::QR_MODE_AUTO_DETECT, 
* $type default as 4, 
* $errorCorrectLevel default as QRCode::QR_ERROR_CORRECT_LEVEL_L

They might return an parameter, name it as `$qr`.

### 0x01. Get Matrix

`$qr->getQRMatrix();`

### 0x02. Get HTML `<table>` block

`$qr->printHTML();`

### 0x03. Output as Image

```php
// イメージ作成(引数:サイズ,マージン)
$im = $qr->createImage(2, 4);
header("Content-type: image/gif");
imagegif($im);
imagedestroy($im);
```

## Basement

Based on [kazuhikoarase/qrcode-generator in PHP](https://github.com/kazuhikoarase/qrcode-generator), licensed under [MIT](http://www.opensource.org/licenses/mit-license.php).

```
//---------------------------------------------------------------
// QRCode for PHP5
//
// Copyright (c) 2009 Kazuhiko Arase
//
// URL: http://www.d-project.com/
//
// Licensed under the MIT license:
//   http://www.opensource.org/licenses/mit-license.php
//
// The word "QR Code" is registered trademark of
// DENSO WAVE INCORPORATED
//   http://www.denso-wave.com/qrcode/faqpatent-e.html
//
//---------------------------------------------------------------------
```