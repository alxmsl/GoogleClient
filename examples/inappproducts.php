<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 *
 * In-app products example
 * @author alxmsl
 * @date 5/28/13
 */

include '../vendor/autoload.php';

use alxmsl\Google\AndroidPublisher\InAppProducts\Client;
use alxmsl\Google\AndroidPublisher\InAppProducts\Resource as InAppProductsResource;

const PACKAGE_NAME = 'com.example.package',
      ACCESS_TOKEN = '4CcE5s_T0keN',
      PRODUCT_ID   = 'com.example.package.product.1';

$Client = new Client();
$Client->setPackage(PACKAGE_NAME)
    ->setAccessToken(ACCESS_TOKEN);
/** @var InAppProductsResource $Resource */
$Resource = $Client->get(PRODUCT_ID);
var_dump($Resource->getPrices());
