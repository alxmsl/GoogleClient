<?php
/**
 * This program is free software. It comes without any warranty, to
 * the extent permitted by applicable law. You can redistribute it
 * and/or modify it under the terms of the Do What The Fuck You Want
 * To Public License, Version 2, as published by Sam Hocevar. See
 * http://www.wtfpl.net/ for more details.
 *
 * Purchases subscriptions example
 * @author alxmsl
 * @date 5/28/13
 */

include '../vendor/autoload.php';

use alxmsl\Google\AndroidPublisher\Purchases\Subscriptions\Resource as SubscriptionsResource;
use alxmsl\Google\AndroidPublisher\Purchases\Subscriptions\SubscriptionsClient;

const PACKAGE_NAME    = 'com.example.package',
      ACCESS_TOKEN    = '4CcE5s_T0keN',
      SUBSCRIPTION_ID = 'com.example.package.product.1',
      PURCHASE_TOKEN  = 'puRCH45e_tokEN';

$Client = new SubscriptionsClient();
$Client->setPackage(PACKAGE_NAME)
    ->setAccessToken(ACCESS_TOKEN);

/** @var SubscriptionsResource $Resource */
$Resource = $Client->get(PRODUCT_ID, PURCHASE_TOKEN);
var_dump($Resource->isAutoRenewing() && !$Resource->isExpired());
